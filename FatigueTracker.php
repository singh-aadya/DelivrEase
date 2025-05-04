<?php
require_once 'db.php';
class FatigueTracker {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateFatigueScore($workerId, $orderDetails) {
        // Calculate fatigue based on order characteristics
        $fatigueIncrement = $this->calculateFatigueIncrement($orderDetails);
        
        $query = "UPDATE workers SET 
                    fatigue_score = LEAST(100, fatigue_score + ?), 
                    last_delivery_timestamp = NOW() 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("di", $fatigueIncrement, $workerId);
        $stmt->execute();
    }

    private function calculateFatigueIncrement($orderDetails) {
        // Dynamic fatigue calculation based on order weight, zone complexity
        $baseIncrement = 5; // Base fatigue increment
        $weightFactor = $orderDetails['order_weight'] * 0.5;
        $zoneFactor = $this->getZoneComplexity($orderDetails['zone']);
        
        return $baseIncrement + $weightFactor + $zoneFactor;
    }

    private function getZoneComplexity($zone) {
        // Assign complexity score based on zone characteristics
        $complexityMap = [
            'urban' => 3,
            'suburban' => 2,
            'rural' => 1
        ];
        return $complexityMap[$zone] ?? 2;
    }

    public function getFatigueScore($workerId) {
        $query = "SELECT fatigue_score FROM workers WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $workerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['fatigue_score'];
    }

    public function isWorkerAvailable($workerId) {
        $query = "SELECT fatigue_score, current_status FROM workers WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $workerId);
        $stmt->execute();
        $worker = $stmt->get_result()->fetch_assoc();
        
        return $worker['fatigue_score'] < 70 && $worker['current_status'] == 'available';
    }

    public function resetFatigue() {
        // Daily reset of fatigue scores
        $query = "UPDATE workers SET fatigue_score = 0";
        $this->conn->query($query);
    }

    public static function calculate_fatigue($worker_id) {
        global $pdo;
        // Number of deliveries in last 24 hours
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM deliveries WHERE assigned_worker_id = ? AND created_at > NOW() - INTERVAL 1 DAY");
        $stmt->execute([$worker_id]);
        $deliveries = $stmt->fetchColumn();
        // Simulate total distance (e.g., 5km per delivery)
        $distance_km = $deliveries * 5;
        // Simulate total hours (e.g., 0.5 hour per delivery)
        $hours_on_delivery = $deliveries * 0.5;
        $fatigue = ($deliveries * 10) + ($distance_km * 2) + ($hours_on_delivery * 5);
        return round($fatigue);
    }
    public static function update_fatigue($worker_id) {
        global $pdo;
        $score = self::calculate_fatigue($worker_id);
        $stmt = $pdo->prepare("UPDATE workers SET fatigue_score = ? WHERE id = ?");
        $stmt->execute([$score, $worker_id]);
    }
}
