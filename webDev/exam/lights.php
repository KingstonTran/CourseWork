<?php
require __DIR__ . '/lib/lights.inc.php';
$view = new SuperLights\SuperLightsView($lights);
?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link href="lights.css" type="text/css" rel="stylesheet" />
    <title>Super Lights</title>
</head>

<body>

<form id="gameform" action="post/lights.php" method="POST">
    <fieldset>


        <?php echo$view->present();
        ?>
        <p><input type="submit" name="newgame" value="New Game"></p>
        <p><a href="./">Goodbye!</a></p>

    </fieldset>
</form>


</body>
</html>