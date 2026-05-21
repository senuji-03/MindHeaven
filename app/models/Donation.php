<?php

class Donation
{
    public static function createPendingDonation($data)
    {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO donations (
        donor_id,
        donor_name,
        donor_email,
        donor_phone,
        amount,
        currency,
        payment_method,
        payment_status,
        transaction_id,
        donor_message,
        event_id,
        gateway,
        return_status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $data['donor_id'] ?? null,
            $data['donor_name'] ?? null,
            $data['donor_email'] ?? null,
            $data['donor_phone'] ?? null,
            $data['amount'],
            $data['currency'] ?? 'LKR',
            $data['payment_method'] ?? 'online',
            'pending',
            $data['transaction_id'],
            $data['donor_message'] ?? null,
            $data['event_id'],
            'payhere',
            'pending'
        ]);

        return $pdo->lastInsertId();
    }

    public static function getByTransactionId($transactionId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM donations WHERE transaction_id = ?");
        $stmt->execute([$transactionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateReturnStatus($transactionId, $returnStatus)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE donations SET return_status = ? WHERE transaction_id = ?");
        return $stmt->execute([$returnStatus, $transactionId]);
    }

    public static function updateGatewayResponse($transactionId, $gatewayData)
    {
        $pdo = Database::getConnection();

        $sql = "UPDATE donations SET
                payment_status = ?,
                gateway_payment_id = ?,
                gateway_status_code = ?,
                gateway_status_message = ?,
                gateway_method = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE transaction_id = ?";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            $gatewayData['payment_status'] ?? 'pending',
            $gatewayData['gateway_payment_id'] ?? null,
            $gatewayData['gateway_status_code'] ?? null,
            $gatewayData['gateway_status_message'] ?? null,
            $gatewayData['gateway_method'] ?? null,
            $transactionId
        ]);
    }

    public static function getDonationsByDonor($donorId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT d.*, e.event_title, 
                   u.name as university_name, u.account_number, u.bank_name, u.bank_branch
            FROM donations d 
            LEFT JOIN university_rep_events e ON d.event_id = e.id 
            LEFT JOIN university_representatives ur ON e.university_rep_id = ur.user_id
            LEFT JOIN universities u ON ur.university_id = u.id
            WHERE d.donor_id = ?
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([$donorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDonationsForUniversityRep($repUserId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT d.*, e.event_title 
            FROM donations d
            JOIN university_rep_events e ON d.event_id = e.id
            WHERE e.university_rep_id = ?
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([$repUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDonationWithEventAndUniversity($donationId, $viewerUserId = null, $viewerRole = null)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT d.*, e.event_title, 
                   u.name AS university_name, u.account_number, u.bank_name, u.bank_branch
            FROM donations d
            LEFT JOIN university_rep_events e ON d.event_id = e.id
            LEFT JOIN university_representatives ur ON e.university_rep_id = ur.user_id
            LEFT JOIN universities u ON ur.university_id = u.id
            WHERE d.id = ? OR d.transaction_id = ?
        ");
        $stmt->execute([$donationId, $donationId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function generateUniqueTransactionId()
    {
        return 'TXN-' . time() . '-' . mt_rand(1000, 9999);
    }
}