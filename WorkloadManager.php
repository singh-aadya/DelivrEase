<?php
require_once 'db.php';
require_once 'DeliveryWorker.php';
require_once 'FatigueTracker.php';
require_once 'LeaveManager.php';
class WorkloadManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateWorkerLoad($workerId) {
        // Increment worker's total deliveries and update last active timestamp
        $query = "UPDATE workers SET 
                    total_deliveries = total_deliveries + 1, 
                    last_active = NOW() 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $workerId);
        $stmt->execute();
    }

    public function getWorkersByZone($zone) {
        $query = "SELECT * FROM workers WHERE zone = ? AND is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $zone);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function calculateWorkloadBalance() {
        // Calculate workload distribution across all workers
        $query = "SELECT 
                    AVG(total_deliveries) as avg_deliveries, 
                    STDDEV(total_deliveries) as workload_variance 
                  FROM workers";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    public static function get_available_workers($zone_id, $delivery_date = null) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT w.id FROM workers w
            JOIN worker_zones wz ON w.id = wz.worker_id
            WHERE wz.zone_id = ? AND w.status = 'Available'
        ");
        $stmt->execute([$zone_id]);
        $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $workers = [];
        foreach ($ids as $id) {
            $worker = new DeliveryWorker($id);
            $date = $delivery_date ?: date('Y-m-d');
            if ($worker->is_available($date) && LeaveManager::check_availability($worker->id, $date)) {
                $workers[] = $worker;
            }
        }
        return $workers;
    }
    public static function assign_order($order) {
        $delivery_date = $order->eta ? date('Y-m-d', strtotime($order->eta)) : date('Y-m-d');
        $workers = self::get_available_workers($order->zone_id, $delivery_date);
        if (empty($workers)) return null;
        // Pick worker with lowest fatigue
        usort($workers, function($a, $b) {
            return $a->fatigue_score <=> $b->fatigue_score;
        });
        $order->assigned_worker_id = $workers[0]->id;
        $order->save();
        FatigueTracker::update_fatigue($workers[0]->id);
        return $workers[0];
    }
} 