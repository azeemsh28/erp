<?php
    include_once("header.php");
    $query="SELECT * FROM users WHERE flag='false'";
    $res=mysqli_query($conn, $query);
//    $row=mysqli_fetch_all($res,MYSQLI_ASSOC);
    $recordsArray="";
    while($row=mysqli_fetch_all($res,MYSQLI_ASSOC)){
        $recordsArray=$row;
    }
//  var_dump($recordsArray);
    if(isset($_POST['submit'])){
        $uName=$_POST['uName'];
        $pWord=$_POST['pWord'];
        $uRole=$_POST['uRole'];
        $fLag=$_POST['fLag'];
        $gEnder=$_POST['gEnder'];
        $dEptt=$_POST['dEptt'];
        $sTatus=$_POST['sTatus'];
//      var_dump($_POST);
        if(isset($_POST['uId']) && $_POST['uId']!=''){
            $uId=$_POST['uId'];
            $query="UPDATE users SET Username='".$uName."', Password='".$pWord."', Userrole='".$uRole."', flag='".$fLag."', gender='".$gEnder."', Department='".$dEptt."', status='".$sTatus."'WHERE UID='".$uId."'";
//            var_dump($query);
            $res=mysqli_query($conn, $query);   
        }else{
//            $uRole='2';
//            $uFlag='false';
            $query="INSERT INTO users(Username, Password, Userrole, flag, gender, Department, status) VALUES ('".$uName."','".$pWord."','".$uRole."','".$fLag."','".$gEnder."','".$dEptt."','".$sTatus."')";
            $res=mysqli_query($conn, $query);   
            if(!$res){
              ?>
    <script>
        alert('user already exist,try again');
        $("#dialogBoxDiv").dialog("open");
    </script>
    <?php
            }
        }
    }
//if(isset($_POST['logout'])){
//    header("location:index.php");
//}
?>

        <script>
            function edit(uId, uName, pWord, uRol, fg, gd, dt, st){
                $("#dialogBoxDiv").dialog({
                title: "Edit user"
                });
                $("#dialogBoxDiv").dialog("open");
                document.getElementById("ui").value=uId;
                document.getElementById("un").value=uName;
                document.getElementById("pw").value=pWord;
                document.getElementById("ur").value=uRol;
                document.getElementById("flg").value=fg;
                document.getElementById("gndr").value=gd;
                document.getElementById("dpt").value=dt;
                document.getElementById("sts").value=st;
            }
            function disable(uId, uName, elem){
                console.log(elem);
                if(confirm("Do you want to disable user '" + uName + "' ?")){
                    $.ajax({
                        url: "disable.php",
                        method: "POST",
                        dataType: "json",
                        data: {
                            uID: uId
                        },
                        success: function(data){
                            console.log(data);
                            if(data == true){
                                $(elem).parents('tr').remove();
                            }
                        }
                    });
                }
            }
            $(document).ready(function(){
                $(function(){
                    $("#dialogBoxDiv").dialog({
                        autoOpen: false,
                        position: { my: "left top", at: "right top", of: "#usersRecordsTable"  },
                        title: "Dialog Title"
                    });
                    $("#addBtn").click(function(){
                        document.getElementById("ui").value="";
                        document.getElementById("un").value="";
                        document.getElementById("pw").value="";
                        document.getElementById("cpw").value="";
                        document.getElementById("ur").value="";
                        document.getElementById("flg").value="";
                        document.getElementById("gndr").value="";
                        document.getElementById("dpt").value="";
                        document.getElementById("sts").value="";
                        $("#dialogBoxDiv").dialog({
                        title: "Add new user"
                        });
                        $("#dialogBoxDiv").dialog("open");
                        return false;
                    });
                });
                //            $("#logoutBtn").click(function(){if(confirm("DO YOU REALLY WANT TO LOGOUT ?")){document.forms["logoutButton"].submit();}});
            });
            //          function logOut(){if(confirm("Do You Really Want To LOGOUT ?")){}}
        </script>
        </header>
        <!--
    <form onsubmit="logOut()" id="logoutButton" action="admin.php" method="post">
    <input type="hidden" name="logoutField" value="Press to logout">
    <input id="logoutBtn" type="submit" name="logout" value="LOGOUT">
    </form><br>
-->
        <!--    <a href="index.php" onclick="return confirm('Are you sure to logout?');">Logout</a>-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <h2>Active Users</h2>
                </div>
                <div class="col-md-3">
                    <form  id="addButtonForm" action="admin.php" method="post">
                        <input id="addBtn" type="submit" name="add" value="ADD New User">
                        <input type="button" value="View disabled users" onclick="window.location.href='disable_user.php'">
<!--                        <input type="button" name="" value="Back" onclick="window.location.href='routine.php'">-->
                    </form>
                </div>                    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table id="usersRecordsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Username</th>
                                <th class="fitcontent">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                for($i=0; $i<count($recordsArray); $i++){ ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo $recordsArray[$i]['Username']; ?></td>
                    <td class="fitcontent">
                    <form class="viewBtnForm" action="user_view.php" method="post">
                    <input type="hidden" name="uId" value="<?php echo $recordsArray[$i]['UID'] ?>">
                    <input type="hidden" name="uName" value="<?php echo $recordsArray[$i]['Username'] ?>">
                    <input type="button" name="editBtn" value="EDIT" onclick="edit('<?php echo $recordsArray[$i]['UID']?>','<?php echo $recordsArray[$i]['Username']?>','<?php echo $recordsArray[$i]['Password']?>','<?php echo $recordsArray[$i]['Userrole']?>','<?php echo $recordsArray[$i]['flag']?>','<?php echo $recordsArray[$i]['gender']?>','<?php echo $recordsArray[$i]['Department']?>','<?php echo $recordsArray[$i]['status']?>')">
                    <input type="button" name="disableBtn" value="DISABLE" onclick="disable('<?php echo $recordsArray[$i]['UID']?>','<?php echo $recordsArray[$i]['Username']?>', this)">
                    <input type="submit" name="view" value="VIEW">
                    </form>
                    </td>
                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="dialogBoxDiv" title="Basic dialog">
            <form id="add/editForm" action="admin.php" method="post">
             <input id="ui" type="hidden" name="uId" value="">
             <b>Username:</b><input id="un" type="text" name="uName" value=""><br>
             <b>Password:</b><input id="pw" type="text" name="pWord" value=""><br>
             <b>Confirm password:</b><input id="cpw" type="text" name="confirmPassword" value=""><br>
             <b>Userrole:</b><input id="ur" type="text" name="uRole" value=""><br>    
             <b>Flag:</b><br><input id="flg" type="text" name="fLag" value=""><br>    
             <b>Gender:</b><input id="gndr" type="text" name="gEnder" value=""><br>    
             <b>Department:</b><input id="dpt" type="text" name="dEptt" value=""><br>    
             <b>Status:</b><br><input id="sts" type="text" name="sTatus" value=""><br><br>   
                <input type="submit" name="submit" value="Submit">
                <input type="submit" name="cancel" value="Cancel">
            </form>
        </div>
        </body>
        </html>