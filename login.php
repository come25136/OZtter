<?php
// Booting
require __DIR__ . '/bootstrap.php';

// Redirect unlogined user to login page
require_logined_session();

try {
    $screen_name = $_SESSION['client']->get('account/verify_credentials')->screen_name;
} catch (RuntimeException $e) {
    if ($e->getCode() == 88) {
        $screen_name = "API limit";
    } elseif ($e->getCode() == 89) {
        require __DIR__ . '/reset.php';
    }
}
?>
<!-- side: @toki25136 video: @Aodaruma_ -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>OZtter - Login</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="css/lib/oztter_gwd.css" rel="stylesheet" type="text/css" id="gwd-text-style">

    <link href="css/progress.css" rel="stylesheet" type="text/css">
    <link href="css/login.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script data-source="js/lib/googbase_min.js" data-version="3" data-exports-type="googbase"
            src="js/lib/googbase_min.js"></script>
    <script data-source="js/lib/gwd_webcomponents_min.js" data-version="5" data-exports-type="gwd_webcomponents"
            src="js/lib/gwd_webcomponents_min.js"></script>
    <script data-source="js/lib/gwdoval_min.js" data-version="3" data-exports-type="gwd-oval"
            src="js/lib/gwdoval_min.js"></script>
    <script data-source="js/lib/gwdbezierpath_min.js" data-version="3" data-exports-type="gwd-bezierpath"
            src="js/lib/gwdbezierpath_min.js"></script>
    <script data-source="js/lib/gwdrectangle_min.js" data-version="3" data-exports-type="gwd-rectangle"
            src="js/lib/gwdrectangle_min.js"></script>

    <script src="js/progress.js"></script>
    <?php include_once("lib/analyticstracking.php"); ?>
</head>

<body>
<div id="oztter">
    <canvas is="gwd-bezierpath" width="300" height="150" class="gwd-canvas-1yo9 gwd-gen-1kekgwdanimation"
            anchors="[[[0.03,76.78,0],[0,74.81,0],[0,74.81,0]],[[300.14,0,0],[300.14,0,0],[300.14,0,0]],[[300.28,150,0],[300.28,150,0],[300.28,150,0]]]"
            closed="" stroke-width="0" stroke-color="null" fill-color="[1,0,0.6352941176470588,1]" geom-type="5"
            id="-"></canvas>
    <canvas is="gwd-rectangle" width="99" height="150" class="gwd-canvas-ry3d gwd-gen-3szrgwdanimation" id="-x"
            x-off="0" y-off="0.5" stroke-width="0" stroke-color="[0,0,0,1]" fill-color="[1,1,1,1]" tl-radius="0"
            tr-radius="0" bl-radius="0" br-radius="0" stroke-style="Solid"></canvas>
    <canvas is="gwd-oval" width="150" height="150" class="gwd-canvas-1o2e gwd-gen-ozd6gwdanimation"
            x-off="0.11111111111108585" y-off="0.0555555555555145" stroke-width="1" stroke-color="null"
            fill-color="[1,0,0.6352941176470588,1]" inner-radius="0" stroke-style="Solid" id="O1"></canvas>
    <canvas is="gwd-oval" width="110" height="110" class="gwd-canvas-1pho gwd-gen-1ivcgwdanimation"
            x-off="0.2777777777778283" y-off="0.33333333333325754" stroke-width="1" stroke-color="null"
            fill-color="[1,1,1,1]" inner-radius="0" stroke-style="Solid" id="O2"></canvas>
    <canvas is="gwd-bezierpath" width="131" height="101" class="gwd-canvas-bcax gwd-gen-1hgtgwdanimation"
            anchors="[[[126.71,97.04,0],[126.71,97.04,0],[126.71,97.04,0]],[[5.16,68.4,0],[5.16,68.4,0],[5.16,68.4,0]],[[127.09,4,0],[127.09,4,0],[127.09,4,0]],[[4,35.7,0],[4,35.7,0],[4,35.7,0]]]"
            stroke-width="8" stroke-color="[1,1,1,1]" fill-color="null" geom-type="5" id="Z"></canvas>
    <p class="gwd-p-1o7d gwd-gen-1vzogwdanimation">tter</p>
</div>

<div id="form">
    <div id="progressbar">
        <canvas id="progress" height="18px"></canvas>
        <div id="progress-t"></div>
        <p id="auth">認証中</p>
    </div>

    <p id="welcome">Welcome!</p>

    <div class="form">
        <label class="label">ニックネーム</label>
        <input type="text" class="input" value="<?php echo $screen_name; ?>">
    </div>

    <div class="form">
        <label class="label" style="margin-left: 16px;">パスワード</label>
        <input type="password" class="input" style="margin-left: 11px;" value="****">
    </div>
</div>
</body>
</html>
