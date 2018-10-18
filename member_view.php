<?php
    include_once("header.php");
    if($_SESSION['uStatus']=='developmentTeam_leader'){
    $query="SELECT UID, Username FROM users WHERE Department='development' AND flag='false'";
    $res=mysqli_query($conn, $query);
    }else if($_SESSION['uStatus']=='designTeam_leader'){
    $query="SELECT UID, Username FROM users WHERE Department='designers' AND flag='false'";
    $res=mysqli_query($conn, $query);
    }else if($_SESSION['uStatus']=='qaTeam_leader'){
    $query="SELECT UID, Username FROM users WHERE Department='qa' AND flag='false'";
    $res=mysqli_query($conn, $query);
    }else if($_SESSION['uStatus']=='csrTeam_leader'){
    $query="SELECT UID, Username FROM users WHERE Department='csr' AND flag='false'";
    $res=mysqli_query($conn, $query);
    }
//    $row=mysqli_fetch_all($res,MYSQLI_ASSOC);
    $recordsArray="";
    while($row=mysqli_fetch_all($res,MYSQLI_ASSOC)){
        $recordsArray=$row;
    }
//  var_dump($recordsArray);
?>

        <script>
        </script>
        </header>

            <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <h2>Team Members</h2>
                </div>
<!--
                <div class="col-md-3">
                <input type="button" name="" value="Back" onclick="window.location.href='routine.php'">
                </div>                    
-->
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
                    <form class="viewBtnForm" action="member_data.php" method="post">
                    <input type="hidden" name="uId" value="<?php echo $recordsArray[$i]['UID'] ?>">
                    <input type="hidden" name="uName" value="<?php echo $recordsArray[$i]['Username'] ?>">
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
        </body>
        </html>