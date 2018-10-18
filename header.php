<?php 
session_start();
include_once("connect.php");
if(!isset($_SESSION['uName']) && !isset($_SESSION['uRole']) && basename($_SERVER['PHP_SELF']) != 'index.php'){
header("location:index.php");                                                     
}
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <link rel="stylesheet" href="routine.css">
</head>
<body>
    <div class="container"></div>
    <header>
        <div class="row">
            <div class="col-md-2">
                <img id="logoImg" src="img/AdMazim.png" alt="Admaxim Logo" height="60"></div>
            <div class="col-md-7">
                <h2 align="center">Employees Attendence Activity System</h2></div>
            <!--        <h1 align="center">Employee Attendence System</h1>-->
            <?php if(isset($_SESSION["uName"])){ ?>
            <div id="welcomeNoteDiv" class="col-md-3">
                <div class="row float-right">
                    <?php
//                if($_SESSION["uName"] == 'ammara' || $_SESSION["uName"] == 'humna' || $_SESSION["uName"] == 'iram' || $_SESSION["uName"] == 'nafeesa')
                        if(isset($_SESSION['uGender'])){
                            if($_SESSION['uGender'] == 'female'){
                                echo "Welcome  Ms. ". strtoupper($_SESSION["uName"]); 
                            }elseif($_SESSION['uGender'] == 'male' && $_SESSION['uRole'] !='1'){
                                echo "Welcome  Mr. ". strtoupper($_SESSION["uName"]); 
                            }else{
//                              echo "Welcome  Mr. ". strtoupper($_SESSION["uName"]);
                                echo "Welcome  Mr. Admin";
                            }
                        }  ?>&nbsp;&nbsp;
                    <a id="logoutBtn" href="logout.php" onclick="return confirm('Are you sure you want to LOGOUT ?');">Logout</a>
                </div><br>
                <div class="row float-right" id="headerBtn">
                    <?php  if($_SESSION['uRole']=='3'){ ?>
                                <input type="button" name="" value="View Members" onclick="window.location.href='member_view.php'">
                                <input type="button" name="" value="Back" onclick="window.location.href='routine.php'">
                    <?php   }else if($_SESSION['uRole']=='4'){ ?>
                                <input type="button" name="" value="View Members" onclick="window.location.href='member_view.php'">
                                <input type="button" name="" value="Admin page" onclick="window.location.href='admin.php'">
                                <input type="button" name="" value="Back" onclick="window.location.href='routine.php'">
                    <?php   }else if($_SESSION['uRole']=='5'){ ?>
                                <input type="button" name="" value="Admin page" onclick="window.location.href='admin.php'">
                                <input type="button" name="" value="Back" onclick="window.location.href='routine.php'">
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
        