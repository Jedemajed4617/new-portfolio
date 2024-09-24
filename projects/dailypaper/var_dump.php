<?php
$servername = "server64.web-hosting.com";
$username = "tgsoqmsy_jedemajed";
$password = "Fcmedemblik2006!";
$dbname = "tgsoqmsy_dailypaper";
 
// Create connection in mysqli
 
$mysqli = new mysqli($servername, $username, $password, $dbname);
 
//Check connection in mysqli
if(!$mysqli){
    die("Error on the connection");
};
