<?php


header("Access-Control-Allow-Origin: *");

$status=htmlentities($_POST["status"]);

if(empty($status))
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


$sql= "Select * from damage  where current_status='$status' ORDER BY id DESC ";
$id="myBtn";
$result=mysqli_query($access->con,$sql);
$no_of_rows=mysqli_num_rows($result);

$temp_array=array();

if ($no_of_rows > 0)
{
    $output = '';
    $output .= '  
                <table class="table table-bordered"> 
                   <thead>
                     <tr>  
                          <th style="border: 1px solid black;">Reference Number</th>
                          <th style="border: 1px solid black;">Date</th>
                          <th style="border: 1px solid black;">Time</th> 
                          <th style="border: 1px solid black;">User ID</th>
                          <th style="border: 1px solid black;">Picture</th> 
                          <th style="border: 1px solid black;">Map View</th>
                          <th style="border: 1px solid black;">User Comment</th> 
                          <th style="border: 1px solid black;">Current Status</th>
                          <th style="border: 1px solid black;">Status Change </th>
                          <th style="border: 1px solid black;">Copy Coordinate</th>
                     </tr> 
                   </thead>
           ';
    while($row=mysqli_fetch_assoc($result))
    {
        $lat=$row["lat"];
        $lng=$row["lng"];
        $lat_lng=$lat.",".$lng;
        $change="No Modification";
        if($row["current_status"]=="NEW")
        {
            $change="WIP";
        }
        else if($row["current_status"]=="WIP")
        {
            $change="Complete";
        }
		else if($row["current_status"]=="Complete")
        {
            $change="Delete";
        }
		
		
		if($row["current_status"]!="Detete")
        {
        
		
			$urls="https://maps.google.com/maps?q=".$lat.",".$lng."&z=14&output=embed&iwloc=0";
			$output .= '
  
                    <tbody>
                     <tr>  
                          <td  style="border: 1px solid black;">' . $row["dam_id"]. '</td>  
                          <td  style="border: 1px solid black;"> '.$row["date"] .'</td>
                          <td  style="border: 1px solid black;"> '.$row["time"] . '</td>
                          <td  style="border: 1px solid black;"> '.$row["user_id"] . '</td>
                          <td  style="border: 1px solid black; width:320px; height:320px"> <img width="300px" height="300px"  src='.$row["pic_path"].'></img> </td>
                          <td style="border: 1px solid black; width:320px; height:320px"> <iframe width="300px" height="300px" frameborder="0" style="border:0" src='.$urls.' allowfullscreen></iframe>  </td>
                          <td style="border: 1px solid black;" > '.$row["comment"] . '</td>
                          <td  style="border: 1px solid black;">'.$row["current_status"].'</td>
                          <td  style="border: 1px solid black;"> <input type="button" value="'.$change.'" id="'.$id .'" class="btn btn-success"  onclick="status(\''.$row["dam_id"].'\',\''.$change.'\')" > </input></td>
                          <td  style="border: 1px solid black;"> <input type="button" name="Copy GPS" value="Copy GPS" id="'.$id .'" class="btn btn-danger" onclick="window.prompt(\'Copy to clipboard: Ctrl+C, Enter\',\''.$lat_lng.'\')" ></td>
                     </tr>  
                   </tbody>
                ';
		}
    }
    $output .= '</table>';
    $access->disconnect();
    echo $output;
}
else
{
    $access->disconnect();
    echo "";
}




?>
