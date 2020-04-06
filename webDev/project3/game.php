<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Game\GameView($game);
?>
<!doctype html>
<html>
<head>
    <meta charset ="utf-8">
    <title>Game Page</title>
    <link href="styles.css" type="text/css" rel="stylesheet" />
    <script src="dist/main.js"></script>
</head>
<body>
<?php echo $view->presentGrid(); ?>
</body>
</html>

