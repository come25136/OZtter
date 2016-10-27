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
/*
try {
    push('Info', 'info.png', 'connecting');

    $client = new Client([$Twitter['ck'], $Twitter['cs'], $_GET['at'], $_GET['ats']]);
    $client->streaming('user', function ($status) {
        if (isset($status->text)) {
            push('Tweet', str_replace('normal', 'bigger', $status->user->profile_image_url_https), $status->text, $status->id_str);
        }
    });
} catch (HttpException $e) {
    if ($e->getCode() == 89) {
        $_SESSION = array();
        session_destroy();
    }

    push('Error', null, $e->getCode());
}
*/
function push($event, $icon, $value, $id = null)
{
    echo "event: $event\n";
    echo "data: " . json_encode(['icon_url' => $icon, 'value' => $value, 'id' => $id], JSON_UNESCAPED_UNICODE) . "\n\n";

    ob_flush();
    flush();
}


while (true) {
    push("Info", "info.png", "OZtter<br><br>push test");

    usleep(1000000);
}

?>
