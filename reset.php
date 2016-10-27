<?php
$_SESSION = array();
session_destroy();

if (isset($_COOKIE["ps"])) {
    setcookie("ps", '', time() - 1800, '/');
}

header('Location: index.php');
exit;
?>