<?php
require __DIR__ . '/lib/game.inc.php';
$view = new Game\CardsView($game);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cards</title>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
echo $view->presentCards();
echo $view->presentPrintCards()
?>
</body>
</html>
