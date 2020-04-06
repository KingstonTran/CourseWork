<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 2/15/2019
 * Time: 11:33 AM
 */
require 'lib/game.inc.php';
$view = new Game\StartView($game);
?>

<!doctype html>
<html>
<head>
    <meta charset ="utf-8">
    <title>Start Page</title>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php echo $view->present(); ?>
</body>
</html>
