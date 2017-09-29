<?php

class access
{

    var $host=null;
    var $user=null;
    var $pass=null;
    var $dbname=null;
    var $con=null;
    var $result=null;
    var $payment;
    var $hand;
    var $submitted;


    function __construct($dbhost,$dbuser,$dbpass,$dbname)
    {
        $this->host=$dbhost;
        $this->user=$dbuser;
        $this->pass=$dbpass;
        $this->dbname=$dbname;
    }

    public function connect()
    {
        $this->con=new mysqli($this->host,$this->user,$this->pass,$this->dbname);
        if(mysqli_connect_error())
        {
            echo "Could no connect databe";
        }
        $this->con->set_charset("utf8");
    }

    public function disconnect()
    {
        if($this->con!=null) {
            $this->con->close();
        }
    }

    public function register_tec($firstname,$lastname,$email,$password,$username,$address,$phone)
    {
        $tec_id=$this->check_tec_id();
        $sql = "INSERT INTO tech SET  tec_id=?, firstname=?, lastname=?, username=?, password=?,phone=?, email=?, address=?";
        $statement = $this->con->prepare($sql);

        if (!$statement) {
            throw new Exception($statement->error);
        }
        $statement->bind_param("ssssssss", $tec_id,$firstname, $lastname, $username, $password, $phone,$email,$address);

        $statement->execute();

        return 1;
    }

    public function check_tec_id()
    {
        $sql= "Select * from tech ORDER BY id DESC LIMIT 1; ";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            $row=$result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row))
            {
                //echo substr('abcdef', 1, 3);  // bcd

                $id=substr($row["tec_id"], 3, 6);
                $id=$id+1;
                return ("TEC".$id);
            }
        }
        else
        {
            return ("TEC111111");
        }
    }

    public function admin_login($username,$passwrd)
    {
        $returnArray=array();

        $sql= "Select * from admin where username='$username' and password='$passwrd' ";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            $row=$result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row))
            {
                $returnArray["username"]=$row["username"];
                $returnArray["email"]=$row["email"];
                $returnArray["phone"]=$row["phone"];
                $returnArray["name"]=$row["firstname"]."  ".$row["lastname"];
                $returnArray["id"]=$row["admin_id"];
            }
        }

        return $returnArray;
    }

    public function tech_login($username,$password)
    {
        $returnArray=array();

        $sql= "Select * from tech where username='$username' and password='$password' ";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            $row=$result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row))
            {
                $returnArray["username"]=$row["username"];
                $returnArray["email"]=$row["email"];
                $returnArray["phone"]=$row["phone"];
                $returnArray["name"]=$row["firstname"]."  ".$row["lastname"];
                $returnArray["id"]=$row["tec_id"];
            }
        }

        return $returnArray;
    }


    public function check_username($username)
    {
        $returncode=-1;

        $sql= "Select * from tech where username='$username'";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            $row=$result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row))
            {
                $returncode=1;
            }
        }
        else
        {
            $sql= "Select * from admin where username='$username'";
            $result=$this->con->query($sql);

            if ($result !=null && (mysqli_num_rows($result)>=1))
            {
                $row=$result->fetch_array(MYSQLI_ASSOC);
                if(!empty($row))
                {
                    $returncode=1;
                }
            }
            else
            {
                $returncode=0;
            }
        }

        return $returncode;
    }

    public function fiber_damage($pic_path,$comment,$lat,$long,$userid)
    {
        $status="NEW";
        date_default_timezone_set("Asia/Colombo");
        $date=date("Y-m-d");
        $time=date("h:i:sa");
        $dam_id=$this->fiber_damage_ceck_id();
        $sql = "INSERT INTO damage SET  dam_id=?, pic_path=?, comment=?, lat=?, lng=?,user_id=?,date=?,time=?,current_status=?";
        if($statement = $this->con->prepare($sql)) {
            $statement->bind_param("sssssssss", $dam_id, $pic_path, $comment, $lat, $long, $userid, $date,$time,$status);

            $statement->execute();

            return true;
        }
        else
        {
            return false;
        }


    }

    public function fiber_damage_ceck_id()
    {

        $id="";

        $today_year=date("y");
        $today_month=date("m");
        $today_date=date("d");


        $sql= "Select * from damage ORDER BY id DESC LIMIT 1; ";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            $row=$result->fetch_array(MYSQLI_ASSOC);
            if(!empty($row))
            {
                //echo substr('abcdef', 1, 3);  // bcd

                $dam_id=$row["dam_id"];

                $pir=substr($dam_id, 0, 3);
                $id_year=substr($dam_id, 3, 2);
                $id_month=substr($dam_id, 5, 2);
                $id_date=substr($dam_id, 7, 2);
                $id_id=substr($dam_id, 9, 3);

                if($today_year==$id_year)
                {
                    if($today_month==$id_month)
                    {
                        if($today_date==$id_date)
                        {
                            $id_id+=1;
                            if($id_id/100<1)
                            {
                             
                                if($id_id/10<1)
                                {
                                    $id=$pir."".$id_year."".$id_month."".$id_date."00".$id_id;
                                }
                                else
                                {
                                    $id=$pir."".$id_year."".$id_month."".$id_date."0".$id_id;
                                }
                            }
                            else
                            {
                                $id=$pir."".$id_year."".$id_month."".$id_date."".$id_id;
                            }
                        }
                        else
                        {
                            $id=$pir."".$id_year."".$id_month."".$today_date."000";
                        }
                    }
                    else
                    {
                        $id=$pir."".$id_year."".$today_month."".$today_date."000";
                    }
                }
                else
                {
                    $id=$pir."".$today_year."".$today_month."".$today_date."000";
                }

                return $id;
            }
        }
        else
        {
            $id="PIR".$today_year."".$today_month."".$today_date."000";
            return $id;
        }
    }

    public function get_damage_details()
    {
        $returnArray=array();
        $query= "Select * from damage ORDER BY id DESC; ";

        $result=mysqli_query($this->con,$query);
        $no_of_rows=mysqli_num_rows($result);

        if ($no_of_rows > 0)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $returnArray[]=$row;
            }
        }

        return $returnArray;
    }
    public function get_damage_details_pdf($from,$to,$wip,$new,$completed)
    {
        $returnArray=array();
        $WIP="WIP";
        $NEW="NEW";
        $COMPLETED="Complete";

        if($from =="empty" && $to =="empty" && $wip=="empty" && $new=="empty" && $completed=="empty")
        {
            //$query= "Select * from damage WHERE date between '$from' AND '$to'";
            $query= "Select * from damage ORDER BY id DESC";
            $result=mysqli_query($this->con,$query);
            $no_of_rows=mysqli_num_rows($result);

            if ($no_of_rows > 0)
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $returnArray[]=$row;
                }
            }
        }
        else
        {
            if($from !="empty" && $to !="empty" && $wip!="empty" && $new !="empty" && $completed!="empty")
            {
                $query= "Select * from damage WHERE (date between '$from' AND '$to') AND (current_status='$WIP'  OR current_status='$NEW' OR current_status='$COMPLETED' ) ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($from !="empty" && $to !="empty" && $wip!="empty" && $new !="empty")
            {
                $query= "Select * from damage WHERE (date between '$from' AND '$to') AND (current_status='$WIP'  OR current_status='$NEW') ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($from !="empty" && $to !="empty" && $wip!="empty" && $completed!="empty")
            {
                $query= "Select * from damage WHERE (date between '$from' AND '$to') AND (current_status='$WIP'  OR current_status='$COMPLETED') ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($from !="empty" && $to !="empty" && $new!="empty" && $completed!="empty")
            {
                $query= "Select * from damage WHERE (date between '$from' AND '$to') AND (current_status='$NEW'  OR current_status='$COMPLETED') ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($from !="empty" && $to!="empty" && $wip!="empty")
            {
                $query= "Select * from damage WHERE (date between '$from' AND '$to') AND (current_status='$WIP') ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($from !="empty" && $to!="empty" && $new!="empty")
            {
                $query= "Select * from damage WHERE (date between '$from' AND '$to') AND (current_status='$NEW') ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($from !="empty" && $to!="empty" && $completed!="empty")
            {
                $query= "Select * from damage WHERE (date between '$from' AND '$to') AND (current_status='$COMPLETED') ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($new!="empty" && $wip!="empty" && $completed!="empty")
            {
                $query= "Select * from damage WHERE  current_status='$NEW' OR current_status='$WIP' OR current_status='$COMPLETED' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($from !="empty" && $to!="empty")
            {
                $query= "Select * from damage WHERE date between '$from' AND '$to' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($new!="empty" && $wip!="empty")
            {
                $query= "Select * from damage WHERE  current_status='$NEW' OR current_status='$WIP' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($new!="empty" && $completed!="empty")
            {
                $query= "Select * from damage WHERE  current_status='$NEW' OR current_status='$COMPLETED' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($wip!="empty" && $completed!="empty")
            {
                $query= "Select * from damage WHERE  current_status='$WIP' OR current_status='$COMPLETED' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($wip!="empty")
            {
                $query= "Select * from damage WHERE  current_status='$WIP' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($completed!="empty")
            {
                $query= "Select * from damage WHERE  current_status='$COMPLETED' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else if($new!="empty")
            {
                $query= "Select * from damage WHERE  current_status='$NEW' ORDER BY id DESC";
                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
            else
            {
                $query= "Select * from damage ORDER BY id DESC; ";

                $result=mysqli_query($this->con,$query);
                $no_of_rows=mysqli_num_rows($result);

                if ($no_of_rows > 0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $returnArray[]=$row;
                    }
                }
            }
        }

        return $returnArray;
    }
    public function otp($rand)
    {
        $sql= "Select * from user where otp=$rand ";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function otp_insert($phone,$rand)
    {
        $rand="".$rand;
        if($this->check_user($phone))
        {
            $sql = "UPDATE user SET  otp=? WHERE phone=$phone";

            if($statement = $this->con->prepare($sql)) {

               $statement->bind_param("s", $rand);
               $statement->execute();
               return true;
           }
           else
           {
               return false;
           }
        }
        else
        {
            $sql = "INSERT INTO user SET  phone=?, otp=?";
            if($statement = $this->con->prepare($sql)) {
                $statement->bind_param("ss", $phone, $rand);

                $statement->execute();
                return true;
            }
            else
            {
                return false;
            }
        }

    }

    public function check_user($phone)
    {
        $sql= "Select * from user where phone=$phone ";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function otp_cehck($phone,$otp)
    {
        $sql= "Select * from user where phone=$phone and otp=$otp";
        $result=$this->con->query($sql);

        if ($result !=null && (mysqli_num_rows($result)>=1))
        {
            $this->update_otp($phone);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function update_otp($phone)
    {
        $otp="";
        $sql = "UPDATE user SET  otp=? WHERE phone=$phone";

        if($statement = $this->con->prepare($sql)) {

            $statement->bind_param("s", $otp);
            $statement->execute();
            return true;
        }
        else
        {
            return false;
        }
    }
	
	public function change_damage($id,$change,$comment)
    {
        date_default_timezone_set("Asia/Colombo");
        $date=date("Y-m-d");
        $time=date("h:i:sa");

        if ($change=="WIP")
        {
            $sql = "UPDATE damage SET current_status='$change',wip_date='$date',wip_comment='$comment' WHERE dam_id='$id'";

            if (mysqli_query($this->con, $sql)) {
                return true;
            } else {
                return false;
            }
        }

        if ($change=="Complete")
        {
            $sql = "UPDATE damage SET current_status='$change',completed_date='$date',completed_comment='$comment' WHERE dam_id='$id'";

            if (mysqli_query($this->con, $sql)) {
                return true;
            } else {
                return false;
            }
        }
		if ($change=="Delete")
        {
            $sql = "UPDATE damage SET current_status='$change',delete_date='$date',delete_comment='$comment' WHERE dam_id='$id'";

            if (mysqli_query($this->con, $sql)) {
                return true;
            } else {
                return false;
            }
        }

    }

public function get_admin()
{
    $returnArray=array();
    $query= "Select phone from admin ";

    $result=mysqli_query($this->con,$query);
    $no_of_rows=mysqli_num_rows($result);

    if ($no_of_rows > 0)
    {
        while($row=mysqli_fetch_assoc($result))
        {
            array_push($returnArray,$row["phone"]);
        }
    }
    return $returnArray;
}

}
?>
