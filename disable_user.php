<?php
    include_once("header.php");
    $query = "SELECT UID, Username, Password FROM users WHERE flag = 'true'";
    $res = mysqli_query($conn, $query);
//    $row=mysqli_fetch_all($res,MYSQLI_ASSOC);
    $recordsArray ="";
    while($row=mysqli_fetch_all($res,MYSQLI_ASSOC)){
        $recordsArray=$row;
    }
    
?>


        <script>
            function enable(uId, uName, elem) {
                console.log(elem);
                if (confirm("Do you want to enable user '" + uName + "' ? ")) {
                    $.ajax({
                        url: "enable.php",
                        method: "POST",
                        dataType: "json",
                        data: {
                            uID: uId
                        },
                        success: function(data) {
                            console.log(data);
                            if (data == true) {

                                $(elem).parents('tr').remove();
                            }
                        }
                    });
                }
            }

        </script>
        </header>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <h1>Disabled Users</h1>
                </div>
                <div class="col-md-3">
                    <form  id="addButtonForm" action="admin.php" method="post">
                        <input type="button" value="Return to previous page" onclick="window.location.href='admin.php'">
                    </form>
                </div>                    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
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
                    <td>
                        <?php echo $i+1; ?> </td>
                    <td>
                        <?php echo $recordsArray[$i]['Username']; ?> </td>
                    <td class="fitcontent">

                        
                    <form class="viewBtnForm" action="user_view.php" method="post">
                    <input type="hidden" name="uId" value="<?php echo $recordsArray[$i]['UID'] ?>">
                    <input type="hidden" name="uName" value="<?php echo $recordsArray[$i]['Username'] ?>">
                    <input type="button" name="editBtn" value="EDIT" onclick="edit('<?php echo $recordsArray[$i]['UID']?>','<?php echo $recordsArray[$i]['Username']?>','<?php echo $recordsArray[$i]['Password']?>')" disabled>
                    <input type="button" name="enableBtn" value="ENABLE" onclick="enable('<?php echo $recordsArray[$i]['UID']?>','<?php echo $recordsArray[$i]['Username']?>', this)">
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
