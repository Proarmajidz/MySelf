<?php
// Disable error display to prevent HTML errors in JSON response
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $userMessage = $input['message'] ?? '';

    if (empty($userMessage)) {
        echo json_encode(['error' => 'Message is required']);
        exit;
    }

    // Load database
    if (!file_exists('database.json')) {
        echo json_encode(['error' => 'Database file not found']);
        exit;
    }

    $dbContent = file_get_contents('database.json');
    $db = json_decode($dbContent, true);

    if (!$db || !isset($db['data'])) {
        echo json_encode(['error' => 'Invalid database format']);
        exit;
    }

    // Create context from database
    $context = "You are a helpful assistant. You can only answer questions based on the following information:\n\n";
    foreach ($db['data'] as $item) {
        $context .= "- {$item['label']}: {$item['value']}\n";
    }
    $context .= "\nIf the user asks about something not in this list, politely tell them: 'I'm sorry. Anything else except that?";
    $context .= "\nIf something similar the question just clarify";
    // Call OpenRouter API
    $apiKey = getenv('OPENROUTER_API_KEY') ?: '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';

    $data = [
        'model' => 'google/gemini-2.5-flash-lite',
        'messages' => [
            [
                'role' => 'system',
                'content' => $context
            ],
            [
                'role' => 'user',
                'content' => $userMessage
            ]
        ]
    ];

    $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
    
    if ($ch === false) {
        echo json_encode(['error' => 'Failed to initialize cURL']);
        exit;
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
        'HTTP-Referer: http://localhost',
        'X-Title: Personal Info Chatbot'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        echo json_encode(['error' => 'cURL request failed', 'details' => $curlError]);
        exit;
    }

    if ($httpCode !== 200) {
        echo json_encode(['error' => 'API request failed', 'http_code' => $httpCode, 'details' => $response]);
        exit;
    }

    $result = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON response from API', 'details' => json_last_error_msg()]);
        exit;
    }

    if (isset($result['choices'][0]['message']['content'])) {
        echo json_encode(['response' => $result['choices'][0]['message']['content']]);
    } else {
        echo json_encode(['error' => 'Unexpected API response format', 'details' => $result]);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Server error', 'message' => $e->getMessage()]);
}
