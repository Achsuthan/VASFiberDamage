<?php


header("Access-Control-Allow-Origin: *");

$username=htmlentities($_REQUEST["username"]);

if (empty($username))
{
    $returnArray["status"]="800";
    $returnArray["message"]="Missing Required information";
    echo json_encode($returnArray);
    return;
}

$file=parse_ini_file("Test.ini");

$host=trim($file["dbhost"]);
$user=trim($file["dbuser"]);
$pass=trim($file["dbpass"]);
$dbname=trim($file["dbname"]);

require ("Secure/access.php");

$access=new access($host,$user,$pass,$dbname);
$access->connect();


$result=$access->check_username($username);
if($result==0)
{
    $returnArray["staus"]="200";
    $returnArray["message"]="username not found ";
    $access->disconnect();
    echo json_encode($returnArray);
}
else if($result==1)
{
    $returnArray["status"]="400";
    $returnArray["message"]="username found";
    $access->disconnect();
    echo json_encode($returnArray);
}




?>