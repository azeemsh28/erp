<?php 
session_start();
include_once("connect.php");
if(isset($_SESSION["uId"])){
//    var_dump($_POST);
    $type=$_POST['type'];
    $uId=$_POST['uID'];
//    if($ty != 'backtoseat'){
//        $typeid= '0';
//    }    
    if($type == 'otherpurpose'){
        $type = $_POST['typeDetail'];
    }
//    $query="INSERT INTO officetimings (UID, type, typeid) VALUES ('".$uid."','".$ty."','".$typeid."')";
    $q="SELECT ID, type FROM officetimings WHERE UID='".$uId."'ORDER BY ID DESC LIMIT 1";
    $r=mysqli_query($conn, $q);
    $ro=mysqli_fetch_array($r,MYSQLI_ASSOC);
    
    $a='';
    if(($ro==null || $ro['type'] == 'officeout') && $_POST['type'] == 'officein'){
        $a='a';
        $query="INSERT INTO officetimings (UID, type) VALUES ('".$uId."','".$type."')";
        $res=mysqli_query($conn, $query);
    }else if($_POST['type'] == 'backtoseat' && $ro['type'] != 'officeout' && $ro['type'] != 'officein' && $ro['type'] != 'backtoseat'){
        $query="INSERT INTO officetimings (UID, type, typeid) VALUES ('".$uId."','".$type."','".$ro['ID']."')";
                $a=$ro['type'];
        var_dump($query);
        $res=mysqli_query($conn, $query);
    }else if($_POST['type'] == 'officeout' && ($ro['type'] == 'officein' || $ro['type'] == 'backtoseat')){
                $a=$ro['type'];
        $query="INSERT INTO officetimings (UID, type) VALUES ('".$uId."','".$type."')";
        $res=mysqli_query($conn, $query);
    }else if($ro['type'] == 'backtoseat' || $ro['type'] == 'officein'){
        $query="INSERT INTO officetimings (UID, type) VALUES ('".$uId."','".$type."')";
                $a=$ro['type'];
        $res=mysqli_query($conn, $query);
    }    
//    $query="INSERT INTO officetimings (UID, type) VALUES ('".$uId."','".$type."')";
//    $res=mysqli_query($conn, $query);
}
    $query1="SELECT type, time FROM officetimings WHERE UID='".$uId."'";
    $result=mysqli_query($conn, $query1);
    $recordsArray ="";
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $recordsArray=$row;
    }
//echo $a;
//var_dump($a);
echo json_encode($recordsArray);
?>