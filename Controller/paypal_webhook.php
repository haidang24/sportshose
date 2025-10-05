<?php
// Minimal PayPal webhook to verify completed payments
require_once __DIR__ . '/../config/paypal.php';

$payload = file_get_contents('php://input');
$event = json_decode($payload, true);

http_response_code(200); // Acknowledge receipt

// Optional: verify the transmission (via CERT URL, transmission id, etc.)
// For simplicity, we trust Sandbox here. In production, implement full verification.

if (($event['event_type'] ?? '') === 'CHECKOUT.ORDER.APPROVED') {
  // You could fetch and capture here or log approved event
}
if (($event['event_type'] ?? '') === 'CHECKOUT.ORDER.COMPLETED') {
  // Idempotent handling if needed
}

echo 'OK';

