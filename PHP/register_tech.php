<?php


header("Access-Control-Allow-Origin: *");

$firstname=htmlentities($_REQUEST["firstname"]);
$lastname=htmlentities($_REQUEST["lastname"]);
$email=htmlentities($_REQUEST["email"]);
$password=htmlentities($_REQUEST["password"]);
$username=htmlentities($_REQUEST["username"]);
$address=htmlentities($_REQUEST["address"]);
$phone=htmlentities($_REQUEST["phone"]);


if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($username) ||
     empty($address) || empty($phone) )
{
    $returnArray["status"]="800";
    $returnArray["message"]="Missing Required information";
    echo json_encode($returnArray);
    return;
}

//$salt=openssl_random_pseudo_bytes(20);
//$securedpassword=sha1($password.$salt);

$file=parse_ini_file("Test.ini");

$host=trim($file["dbhost"]);
$user=trim($file["dbuser"]);
$pass=trim($file["dbpass"]);
$dbname=trim($file["dbname"]);

require ("Secure/access.php");

$access=new access($host,$user,$pass,$dbname);
$access->connect();


$result=$access->register_tec($firstname,$lastname,$email,$password,$username,$address,$phone);
if($result==1)
{
    $returnArray["status"]="200";
    $returnArray["message"]="Insert successfully ";
}
else
{
    $returnArray["status"]="400";
    $returnArray["message"]="Value Not inserted ";
}

$access->disconnect();
echo json_encode($returnArray);

?>