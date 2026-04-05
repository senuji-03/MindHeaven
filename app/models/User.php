<?php

require_once __DIR__ . '/../../core/Database.php';

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function activate($id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET status = 'active', account_status = 'active', suspended_until = NULL WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deactivate($id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET status = 'inactive', account_status = 'inactive' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function softDelete($id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_deleted = 1, status = 'inactive', account_status = 'inactive' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function resetStrikes($id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET strike_count = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function addStrike($id)
    {
        // Increment strike count, set last strike date, and update status if needed
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET strike_count = strike_count + 1, 
                last_strike_date = NOW(),
                status = CASE 
                    WHEN strike_count >= 3 THEN 'suspended'
                    ELSE status 
                END,
                account_status = CASE 
                    WHEN strike_count >= 3 THEN 'suspended'
                    ELSE 'warned' 
                END
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    public function removeStrike($id)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET strike_count = GREATEST(0, strike_count - 1),
                status = CASE 
                    WHEN strike_count <= 0 THEN 'active'
                    ELSE status 
                END,
                account_status = CASE 
                    WHEN strike_count <= 0 THEN 'active'
                    ELSE account_status 
                END
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    public function suspendUser($id, $until)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET status = 'suspended',
                account_status = 'suspended',
                suspended_until = ?
            WHERE id = ?
        ");
        return $stmt->execute([$until, $id]);
    }

    public function unsuspendUser($id)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET status = 'active',
                account_status = 'active',
                suspended_until = NULL
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    public function isSuspended($id)
    {
        $user = $this->getById($id);
        if (!$user)
            return false;

        // Standardized check on account_status
        if ($user['account_status'] === 'inactive' || $user['account_status'] === 'banned')
            return true;

        if ($user['account_status'] === 'suspended') {
            $suspensionTime = $user['suspended_until'];
            if ($suspensionTime) {
                // Check if suspension time has passed
                if (new DateTime() > new DateTime($suspensionTime)) {
                    // Auto-unsuspend if time passed
                    $this->unsuspendUser($id);
                    return false;
                }
                return true;
            }
            return true; // Indefinite suspension
        }
        return false;
    }

    public function getTotalCount()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }
}
