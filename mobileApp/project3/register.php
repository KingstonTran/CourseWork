<?php
require_once "db.inc.php";
echo '<?xml version="1.0" encoding="UTF-8"?>';

// Ensure the xml post item exists
if(!isset($_POST['xml'])) {
    echo '<neighborhoodtunerds status="no" msg="missing XML" />';
    exit;
}

processXml(stripslashes($_POST['xml']));
echo '<neighborhoodtunerds status="yes"/>';
/**
 * Process the XML query
 * @param $xmltext the provided XML
 */
function processXml($xmltext) {
    // Load the XML
    $xml = new XMLReader();
    if(!$xml->XML($xmltext)) {
        echo '<neighborhoodtunerds status="no" msg="invalid XML" />';
        exit;
    }
    $pdo = pdo_connect();
    while($xml->read()) {
        if($xml->nodeType == XMLReader::ELEMENT &&
            $xml->name == "neighborhoodtunerds") {

            // We have the neighborhoodtunerds tag
            $magic = $xml->getAttribute("magic");
            if($magic != "NechAtHa6RuzeR8x") {
                echo '<neighborhoodtunerds status="no" msg="magic" />';
                exit;
            }

            $user = $xml->getAttribute("user");
            $password = $xml->getAttribute("password");
            $userQ = $pdo->quote($user);
            $passwordQ = $pdo->quote($password);

            getUser($pdo, $user);

            $query = <<<QUERY
INSERT INTO tunesuser(user,password)
VALUES($userQ,$passwordQ)
QUERY;
            if(!$pdo->query($query)) {
                echo '<neighborhoodtunerds status="no" msg="insertfail">' . $query . '</neighborhoodtunerds>';
                exit;
            }
            echo '<neighborhoodtunerds status="yes" msq="inserted"/>';
            exit;

        }
    }

    // Connect to the database
    echo '<neighborhoodtunerds save="no" msg="invalid XML" />';
}

/**
 * Ask the database for the user ID. If the user exists, the password
 * must match.
 * @param $pdo PHP Data Object
 * @param $user The user name
 * @return void exits if found user
 */
function getUser($pdo, $user) {
    // Does the user exist in the database?
    $userQ = $pdo->quote($user);
    $queryQ = "SELECT password from tunesuser where user=$userQ";

    $rows = $pdo->query($queryQ);
    if($row = $rows->fetch()) {
        // We found the record in the database
        echo '<neighborhoodtunerds status="no" msg="user already exists" />';
        exit;
    }
}
?>
