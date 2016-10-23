<?php
$_SESSION = array();
session_destroy();

if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", '', time() - 1800, '/');
}

header('Location: index.php');
exit;
?>