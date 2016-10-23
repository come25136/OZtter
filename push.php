<?php
set_time_limit(0);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/api-keys.php';

use mpyw\Cowitter\Client;
use mpyw\Cowitter\HttpException;

if (!isset($_GET['at']) || $_GET['at'] === '' || !isset($_GET['ats']) || $_GET['ats'] === '') {
    header('Location: login-twitter.php');
    exit;
}

header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("X-Accel-Buffering: no");

ob_flush();
flush();

try {
    push("info.png", "connecting");

    $client = new Client([$Twitter['ck'], $Twitter['cs'], $_GET['at'], $_GET['ats']]);
    $client->streaming('user', function ($status) {
        if (isset($status->text)) {
            push(str_replace("normal", "bigger", $status->user->profile_image_url_https), $status->text);
        }
    });
} catch (HttpException $e) {
    $_SESSION = array();
    session_destroy();

    push(null, $e->getCode());
}

function push($icon, $value)
{
    echo "event: message\n";
    echo "data: " . json_encode(["Icon_url" => $icon, "Value" => $value], JSON_UNESCAPED_UNICODE) . "\n\n";

    ob_flush();
    flush();
}

/*
while (true) {
    push("https://pbs.twimg.com/profile_images/783226143134539776/oTd9F7qd_bigger.jpg", "OZtter<br><br>push test");

    usleep(10000);
}
*/
?>
