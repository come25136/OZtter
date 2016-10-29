<?php
// Booting
require __DIR__ . '/bootstrap.php';

// Redirect unlogined user to login page
require_logined_session();

if (isset($_GET['limit']) && $_GET['limit'] && ctype_digit(strval($_GET['limit']))) {
    $limit = $_GET['limit'];
} else {
    $limit = 300;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>OZtter</title>

    <link href="css/lib/jquery-ui.min.css">
    <link href="css/lib/jquery-ui.structure.min.css">

    <link href="css/src/get_tweet.css" rel="stylesheet" type="text/css">
    <link href="css/title_bar.min.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/lib/jquery-ui.min.js"></script>

    <script src="js/get_tweet.min.js"></script>
    <script src="js/title_bar.js"></script>
    <?php #include_once("lib/analyticstracking.php"); ?>
    <script>
        main("<?php echo $_SESSION['client']->token; ?>", "<?php echo $_SESSION['client']->token_secret; ?>", "<?php echo $limit; ?>");
    </script>
</head>
<body>
<div id="tweets"></div>
</body>
</html>
