<?php
require_once "db.inc.php";
echo '<?xml version="1.0" encoding="UTF-8"?>';

if(!isset($_GET['magic']) || $_GET['magic'] != "NechAtHa6RuzeR8x") {
    echo '<neighborhoodtunerds status="no" msg="magic" />';
    exit;
}

// Process in a function
process($_GET['user'], $_GET['password']);

/**
 * Process the query
 * @param $user the user to look for
 * @param $password the user password
 */
function process($user, $password) {

    // Connect to the database
    $pdo = pdo_connect();

    if(getUser($pdo, $user, $password)){
        echo '<neighborhoodtunerds status="yes"/>';
    }


}

/**
 * Ask the database for the user ID. If the user exists, the password
 * must match.
 * @param $pdo PHP Data Object
 * @param $user The user name
 * @param $password Password
 * @return bool if successful or not
 */
function getUser($pdo, $user, $password) {
    // Does the user exist in the database?
    $userQ = $pdo->quote($user);
    $query = "SELECT password from tunesuser where user=$userQ";

    $rows = $pdo->query($query);
    if($row = $rows->fetch()) {
        // We found the record in the database
        // Check the password
        if($row['password'] != $password) {
            echo '<neighborhoodtunerds status="no" msg="password error" />';
            exit;
        }
        else{
//            $sizeQ = $pdo->quote($size);
//            $queryLogin = "UPDATE tunesuser SET loggedin='1', size=$sizeQ WHERE user=$userQ;";
//            $pdo->query($queryLogin);
            return true;
        }
    }

    echo '<neighborhoodtunerds status="no" msg="user error" />';
    exit;
}
?>