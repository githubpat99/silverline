<?php
function call_flask_api() {
    $url = 'https://4f3a-2a02-1210-8ed8-8c00-2ddf-4402-e954-1442.ngrok-free.app/calculate-kpis'; // ngrok URL
    $data = json_encode([
        "bank" => 10000,
        "depot" => 5000
    ]);

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ],
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        // Log the error
        $error = error_get_last();
        echo "Error occurred while calling the API: ";
        var_dump($error);
    } else {
        // Decode and display the result
        $response = json_decode($result, true);
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }
}

// Call the function
call_flask_api();
?>
