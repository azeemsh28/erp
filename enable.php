<?php
session_start();
include_once("connect.php");
if($_SESSION['uRole'] != '1'){
    header("location:routine.php");
    }
        if(isset($_POST['uID'])){
                $uID= $_POST['uID'];
                $query="UPDATE users SET flag = 'false' WHERE UID='".$uID."'";
                $res=mysqli_query($conn, $query);
                echo json_encode($res);
            }   

?>