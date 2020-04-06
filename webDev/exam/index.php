<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Super Lights Signin</title>
    <link href="lights.css" type="text/css" rel="stylesheet" />

</head>
<body>
<form id="signin" action="post/lights.php" method="POST">
    <fieldset>
        <p><img src="img/banner.png" width="521" height="346" alt="Super Lights Banner"></p>
        <p>Welcome to Super Lights</p>
        <p><label for="name">Your Name: </label>
            <input type="text" name="name" id="name"></p>
        <p><input type="hidden" name="start" value="start"></p>
        <p><input type="submit" value="Start Game"></p>
    </fieldset>
</form>
</body>
</html>