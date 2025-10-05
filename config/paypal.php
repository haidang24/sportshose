<?php
// PayPal sandbox configuration
// Replace the placeholders below with your Sandbox credentials

define('PAYPAL_MODE', 'sandbox'); // 'sandbox' or 'live'
// Sandbox credentials (provided)
define('PAYPAL_CLIENT_ID', getenv('PAYPAL_CLIENT_ID') ?: 'AZvIU6INrhjnHNS3BHM8fDCI_23YhD_nRJbTwBIL5MfqhJZCZn4cnuP26QAT3FyG9399x_oQl49VpIbz');
define('PAYPAL_SECRET', getenv('PAYPAL_SECRET') ?: 'EMUKpiQFeEh2fO9pjEm6t2cqMvuhCHLv2jacI9j3gO6l4kqCYsLTnFskQs2I273jtCmmxsAUNYrU6_Qk');
define('PAYPAL_CURRENCY', 'USD'); // USD recommended. If using VND, convert to USD when creating order

// Optional: VND -> USD conversion (approx). Update as needed.
define('EXCHANGE_RATE_VND_TO_USD', 26000);


