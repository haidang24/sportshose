<?php
// Simple proxy endpoint for Gemini API
// Route: Controller/gemini.php?action=chat

header('Content-Type: application/json');

require_once __DIR__ . '/../config/gemini.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'chat';

if ($action !== 'chat') {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
    exit;
}

if (!defined('GEMINI_API_KEY') || GEMINI_API_KEY === '') {
    http_response_code(500);
    echo json_encode(['error' => 'Missing GEMINI_API_KEY environment variable']);
    exit;
}

// Accept JSON body only
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$message = isset($data['message']) ? trim($data['message']) : '';
$history = isset($data['history']) && is_array($data['history']) ? $data['history'] : [];
$model = isset($data['model']) && is_string($data['model']) && $data['model'] !== '' ? $data['model'] : GEMINI_DEFAULT_MODEL;

if ($message === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit;
}

// Build Gemini payload
$contents = [];

// Convert history messages to Gemini content format (role: user|model)
foreach ($history as $turn) {
    if (!isset($turn['role']) || !isset($turn['text'])) {
        continue;
    }
    $role = $turn['role'] === 'model' ? 'model' : 'user';
    $contents[] = [
        'role' => $role,
        'parts' => [['text' => (string)$turn['text']]],
    ];
}

// Append current user message
$contents[] = [
    'role' => 'user',
    'parts' => [['text' => $message]],
];

$payload = [
    'contents' => $contents,
    // lightweight safety by default
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 512,
    ],
];

$url = GEMINI_API_BASE . '/models/' . rawurlencode($model) . ':generateContent?key=' . urlencode(GEMINI_API_KEY);

// Perform HTTP POST with graceful fallback if cURL is unavailable
$response = null;
$status = 0;
$curlErr = '';

if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    $curlErr = curl_error($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($response === false) {
        http_response_code(502);
        echo json_encode(['error' => 'Upstream error', 'detail' => $curlErr]);
        exit;
    }
} else {
    // Fallback using streams
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($payload),
            'ignore_errors' => true,
            'timeout' => 15,
        ]
    ];
    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);
    // Parse status from $http_response_header
    $status = 0;
    if (isset($http_response_header) && is_array($http_response_header)) {
        foreach ($http_response_header as $hdr) {
            if (preg_match('/^HTTP\/\d+\.\d+\s+(\d+)/', $hdr, $m)) {
                $status = (int) $m[1];
                break;
            }
        }
    }
    if ($response === false) {
        http_response_code(502);
        echo json_encode(['error' => 'Không thể kết nối tới Gemini. Vui lòng bật cURL hoặc kiểm tra mạng.']);
        exit;
    }
}

$json = json_decode($response, true);
if ($status < 200 || $status >= 300 || $json === null) {
    http_response_code(502);
    echo json_encode(['error' => 'Phản hồi không hợp lệ từ Gemini', 'status' => $status]);
    exit;
}

// Extract the text from candidates[0].content.parts[*].text
$replyText = '';
if (isset($json['candidates'][0]['content']['parts']) && is_array($json['candidates'][0]['content']['parts'])) {
    foreach ($json['candidates'][0]['content']['parts'] as $part) {
        if (isset($part['text'])) {
            $replyText .= (string)$part['text'];
        }
    }
}

echo json_encode([
    'message' => $replyText !== '' ? $replyText : '[Không có phản hồi]',
]);


