<?php
/**
 * API endpoint for order details
 */

// Only set header if not already sent
if (!headers_sent()) {
    header('Content-Type: application/json');
}

// Skip method check for testing
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_POST['order_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing order_id parameter']);
    exit;
}

try {
    require_once 'Model/DBConfig.php';
    require_once 'Model/API.php';
    require_once 'Model/Order.php';
    
    $Order = new Order();
    $order_id = $_POST['order_id'];
    
    $result = $Order->getAll_DetailsOrderByID($order_id);
    
    if ($result instanceof PDOStatement) {
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
