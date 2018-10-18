<?php 
include_once("header.php");
if(isset($_SESSION['uName']) && isset($_SESSION['uRole'])){
    if($_SESSION['uRole'] != '1'){
        header("location:routine.php");
    }
    else{
        header("location:admin.php");
    }
}
?>

</header>
<div id="loginFormDiv" class="center">
    <form id="loginForm" action="index.php" method="post">
        <h3><i>Login Form:</i></h3>
        <b>Username:</b><input id="u1" type="text" name="uName" value="" placeholder="Enter username here" required><br>
        <b>Password:</b><input id="ps1" type="password" name="pWord" value="" placeholder="Enter password here" required><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input id="s1" type="submit" name="submit" value="submit">
        <input id="c1" type="submit" name="cancel" value="cancel">
    </form>
</div>
</body>
</html>

<?php 
if(isset($_POST['submit'])){
    $uName=$_POST['uName'];
    $pWord=$_POST['pWord'];
    $query="SELECT * FROM users WHERE Username='".$uName. "'AND Password='".$pWord."'" ;
//    var_dump($query);
    $res=mysqli_query($conn,$query);
    $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
    if(($uName !='') && ($pWord !='')){
//        var_dump($row);
        if($row != ''){
            if(($uName==$row['Username']) && ($pWord==$row['Password']) && ($row['flag']=='false')){
                $_SESSION["uId"]=$row['UID'];
                $_SESSION["uName"]=$row['Username'];
                $_SESSION['uRole']=$row['Userrole'];
                $_SESSION['uGender']=$row['gender'];
                $_SESSION['uFlag']=$row['flag'];
                $_SESSION['uDepartment']=$row['Department'];
                $_SESSION['uStatus']=$row['status'];
                if($row['Userrole'] !='1'){
                    header("location:routine.php");
                }
                else{
                    header("location:admin.php");
                }
            }
//            else if(($uname != $row['Username']) && ($pwd == $row['Password'])){
//            echo "you entered incorrect username";
//            }else if(($uname == $row['Username']) && ($pwd != $row['Password'])){
//            echo "you entered incorrect password";
//            }
        }else{
            echo "you entered incorrect username & password";
        }     
    }else{
        echo "Please enter username and password";
    }    
}
?>