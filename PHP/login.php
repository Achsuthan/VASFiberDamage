<?php


header("Access-Control-Allow-Origin: *");

$username=htmlentities($_REQUEST["username"]);
$password=htmlentities($_REQUEST["password"]);

if (empty($username) || empty($password))
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


$result=$access->admin_login($username,$password);
if($result)
{
    $result["person"]="Admin";
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
    /*$result=$access->tech_login($username,$password);
    if($result)
    {
        $result["person"]="User";
        $result["status"]="200";
        $result["message"]="username not found ";
        $access->disconnect();
        echo json_encode($result);
    }
    else
    {

        $returnArray["status"] = "400";
        $returnArray["message"] = "User not found";
        $access->disconnect();
        echo json_encode($returnArray);
    }*/
}
?>