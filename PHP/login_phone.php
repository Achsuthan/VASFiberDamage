<?php


header("Access-Control-Allow-Origin: *");

$phone=htmlentities($_POST["phone"]);

if (empty($phone))
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






// SMPP SMS sender part //****************************************************************************************
//****************************************************************************************************************

$s = new smpp();

$s->debug=1;
$s->open("10.62.230.110", 2775, "galaxy", "gal123");
$ts=time();




$rand="";
$result="";

do
{
    $rand=rand(1000,9999);
    $result=$access->otp($rand);
}
while($result);

$result=$access->otp_insert($phone,$rand);
if($result)
{
	$ret_val=$s->send_long("Galaxy",$phone,$rand);
    
	$returnArray["status"]="200";
    	$returnArray["message"]="Login success";
	$ret_val_close=$s->close();

}
else
{
    $returnArray["status"]="400";
    $returnArray["message"]="Login Error";
}

$access->disconnect();
echo json_encode($returnArray);



$s->send_long("Galaxy",$phone,$rand);






//$Numbers=array("94773337006","94773337088");
//$Message=date("Y/m/d H:i:s",($ts+1800))."\n"."Current: ".round($total[sizeof($timeArray)-1],0)."\n"."2 Min. Before: ".round($total[sizeof($timeArray)-2],0)."\n"."5 Min. Before: ".round($total[sizeof($timeArray)-3],0);
//foreach($Numbers as $Num)
//{
  //  $s->send_long("MDA",$Num,$Message);
//}



class smpp {

    var $socket=0;
    var $seq=0;
    var $debug=0;
    var $data_coding=0;
    var $timeout = 2;

    //////////////////////////////////////////////////
    function send_pdu($id,$data) {

        // increment sequence
        $this->seq +=1;
        // PDU = PDU_header + PDU_content
        $pdu = pack('NNNN', strlen($data)+16, $id, 0, $this->seq) . $data;
        // send PDU
        fputs($this->socket, $pdu);

        // Get response length
        $data = fread($this->socket, 4);
        //if($data==false) die("\nSend PDU: Connection closed!");
        $tmp = unpack('Nlength', $data);
        $command_length = $tmp['length'];
        if($command_length<12) return;

        // Get response
        $data = fread($this->socket, $command_length-4);
        $pdu = unpack('Nid/Nstatus/Nseq', $data);
        //if($this->debug) print "\n< R PDU (id,status,seq): " .join(" ",$pdu) ;

        return $pdu;
    }


    //////////////////////////////////////////////////
    function open($host,$port,$system_id,$password) {

        // Open the socket
        $this->socket = fsockopen($host, $port, $errno, $errstr, $this->timeout);
        if ($this->socket===false)
            die("$errstr ($errno)<br />");
        if (function_exists('stream_set_timeout'))
            stream_set_timeout($this->socket, $this->timeout); // function exists for php4.3+
       // if($this->debug) print "\n> Connected" ;


        // Send Bind operation
        $data  = sprintf("%s\0%s\0", $system_id, $password); // system_id, password
        $data .= sprintf("%s\0%c", "", 0x34);  // system_type, interface_version
        $data .= sprintf("%c%c%s\0", 5, 0, ""); // addr_ton, addr_npi, address_range

        $ret = $this->send_pdu(2, $data);
        //if($this->debug) print "\n> Bind done!" ;

        return ($ret['status']==0);
    }


    //////////////////////////////////////////////////
    function submit_sm($source_addr,$destintation_addr,$short_message,$optional='') {

        $data  = sprintf("%s\0", ""); // service_type
        $data .= sprintf("%c%c%s\0", 5,0,$source_addr); // source_addr_ton, source_addr_npi, source_addr
        $data .= sprintf("%c%c%s\0", 1,1,$destintation_addr); // dest_addr_ton, dest_addr_npi, destintation_addr
        $data .= sprintf("%c%c%c", 0,0,0); // esm_class, protocol_id, priority_flag
        $data .= sprintf("%s\0%s\0", "",""); // schedule_delivery_time, validity_period
        $data .= sprintf("%c%c", 0,0); // registered_delivery, replace_if_present_flag
        $data .= sprintf("%c%c", $this->data_coding,0); // data_coding, sm_default_msg_id
        $data .= sprintf("%c%s", strlen($short_message), $short_message); // sm_length, short_message
        $data .= $optional;

        $ret = $this->send_pdu(4, $data);
        return ($ret['status']==0);
    }


    //////////////////////////////////////////////////
    function close() {

        $ret = $this->send_pdu(6, "");
        fclose($this->socket);
        return true;
    }


    //////////////////////////////////////////////////
    function send_long($source_addr,$destintation_addr,$short_message,$utf=0,$flash=0) {

        if($utf)
            $this->data_coding=0x08;

        if($flash)
            $this->data_coding=$this->data_coding | 0x10;


        $size = strlen($short_message);
        if($utf) $size+=20;

        if ($size<160) { // Only one part :)
            $this->submit_sm($source_addr,$destintation_addr,$short_message);

        } else { // Multipart
            $sar_msg_ref_num =  rand(1,255);
            $sar_total_segments = ceil(strlen($short_message)/130);

            for($sar_segment_seqnum=1; $sar_segment_seqnum<=$sar_total_segments; $sar_segment_seqnum++) {
                $part = substr($short_message, 0 ,130);
                $short_message = substr($short_message, 130);

                $optional  = pack('nnn', 0x020C, 2, $sar_msg_ref_num);
                $optional .= pack('nnc', 0x020E, 1, $sar_total_segments);
                $optional .= pack('nnc', 0x020F, 1, $sar_segment_seqnum);

                if ($this->submit_sm($source_addr,$destintation_addr,$part,$optional)===false)
                    return false;

            }
        }


        return true;

    }

}





?>
