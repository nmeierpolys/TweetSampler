<?php
session_start(); 

require_once('twitterphp.php');
// require twitterOAuth lib
require_once('twitterOAuth.php');

$zoom = $_GET["zoom"];

$db = new DB();
$db->open();
$zoom = $_GET["zoom"];
$db->getZoomedTweets($zoom);
$db->close();
?>