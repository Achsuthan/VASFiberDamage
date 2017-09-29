<?php


header("Access-Control-Allow-Origin: *");

$phone=htmlentities($_POST["phone"]);
$otp=htmlentities($_POST["otp"]);

if (empty($phone) || empty($otp))
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

$returnArray=array();


$result=$access->otp_cehck($phone,$otp);
if($result)
{
    $returnArray["person"]="Admin";
    $returnArray["status"]="200";
    $returnArray["message"]="Login success";
}
else
{
    $returnArray["status"] = "400";
    $returnArray["message"] = "User not found";
}
$access->disconnect();
echo json_encode($returnArray);
?>