<?php


header("Access-Control-Allow-Origin: *");

$change=htmlentities($_POST["change"]);
$id=htmlentities($_POST["id"]);
$comment=htmlentities($_POST["comment"]);

if (empty($change) || empty($id))
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


$result=$access->change_damage($id,$change,$comment);
if($result)
{
    $result["status"]="200";
    $result["message"]="Login success";
    $access->disconnect();
    echo json_encode($result);
}
else
{
    $returnArray["status"] = "400";
    $returnArray["message"] = "User not found";
    $access->disconnect();
    echo json_encode($returnArray);
}
?>