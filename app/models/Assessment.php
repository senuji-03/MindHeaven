<?php
require_once __DIR__ . '/../../core/Database.php';

class Assessment
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Save assessment result
     */
    public function saveResult($userId, $data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO assessment_results 
            (user_id, anxiety_score, depression_score, stress_score, total_score, interpretation) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $total = $data['anxiety'] + $data['depression'] + $data['stress'];
        
        $interpretation = json_encode([
            'anxiety' => $this->getSeverity('anxiety', $data['anxiety']),
            'depression' => $this->getSeverity('depression', $data['depression']),
            'stress' => $this->getSeverity('stress', $data['stress'])
        ]);

        return $stmt->execute([
            $userId,
            $data['anxiety'],
            $data['depression'],
            $data['stress'],
            $total,
            $interpretation
        ]);
    }

    /**
     * Get user's assessment history for trends
     */
    public function getHistory($userId, $limit = 7)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM assessment_results 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->bindValue(1, (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Clinical Severity Labels based on DASS-21 (Multiplied by 2)
     */
    public function getSeverity($category, $score)
    {
        // Multiply by 2 for DASS-21 normalization to DASS-42
        $finalScore = $score * 2;

        switch ($category) {
            case 'depression':
                if ($finalScore <= 9) return 'Normal';
                if ($finalScore <= 13) return 'Mild';
                if ($finalScore <= 20) return 'Moderate';
                if ($finalScore <= 27) return 'Severe';
                return 'Extremely Severe';
            
            case 'anxiety':
                if ($finalScore <= 7) return 'Normal';
                if ($finalScore <= 9) return 'Mild';
                if ($finalScore <= 14) return 'Moderate';
                if ($finalScore <= 19) return 'Severe';
                return 'Extremely Severe';

            case 'stress':
                if ($finalScore <= 14) return 'Normal';
                if ($finalScore <= 18) return 'Mild';
                if ($finalScore <= 25) return 'Moderate';
                if ($finalScore <= 33) return 'Severe';
                return 'Extremely Severe';
            
            default:
                return 'Normal';
        }
    }
}
