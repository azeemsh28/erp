<?php 
include_once("header.php");
if(isset($_SESSION["uName"])){ 
    $query="SELECT * FROM buttons";
    $res=mysqli_query($conn, $query);
    $buttonsArray ="";
    while($row=mysqli_fetch_all($res,MYSQLI_ASSOC)){
        $buttonsArray=$row;
    }    
}
if(isset($_SESSION["uId"])){ 
    $uId=$_SESSION["uId"];
    
    $query="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE() ORDER BY ID DESC LIMIT 1";
//    ( OR date(time) = CURDATE() - INTERVAL 1 DAY) 
//    $query="SELECT type, time FROM officetimings WHERE UID='".$uId."'";
    $res=mysqli_query($conn, $query);
    $recordsArray="";
    $que="";$re="";
   var_dump($res);
    $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
    if($row['type']=='officeout'){
        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND (date(time)=CURDATE() OR date(time)=CURDATE() - INTERVAL 1 DAY)";
        $re=mysqli_query($conn,$que);
    }else if($row['type']=='officein'){
        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE()";
        $re=mysqli_query($conn,$que);
    }else if($row['type']!='officein' || $row['type']!='officeout'){
        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE()";
        $re=mysqli_query($conn,$que);
    }
    var_dump($row);
//    $dbTime=$row['time'];
//    $ti=date('Y-m-d', strtotime($dbTime));
//    var_dump($row['time']);
//    var_dump($ti);
//    $tim=date('Y-m-d');
//    var_dump($tim);
//    var_dump($row);
//    var_dump($row['type']); var_dump("==========");
    //var_dump($row); var_dump("==========");
//    var_dump(date('m'));
//    if($row['type']=="" || $row['type']==null){
//        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE()";
//        $re=mysqli_query($conn,$que);
//    }else if($row['type']=='officeout' && $ti == $tim){
//        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND (date(time)=CURDATE() OR date(time) = CURDATE() - INTERVAL 1 DAY)";
//        $re=mysqli_query($conn,$que);
//    }else if($row['type']=='officein' && $ti == $tim){
//        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE()";
//        $re=mysqli_query($conn,$que);
//    }else if(($row['type']!='officein' || $row['type']!='officeout') && $ti == $tim){
//        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE()";
//        $re=mysqli_query($conn,$que);
//    }
//        $foundOfficeIn ='false';
//        $recordsR="";
//        while($r=mysqli_fetch_all($res,MYSQLI_ASSOC)){
//            $recordsR=$r;   
//        }
//        if($foundOfficeIn=='true'){
//        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE()";
//        $re=mysqli_query($conn,$que);
////        var_dump($re);
//    }else{
//        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND (date(time)=CURDATE() OR date(time) = CURDATE() - INTERVAL 1 DAY)";
//        $re=mysqli_query($conn,$que);
//        }
//         var_dump($re);
//    }
    
//    else{
//        $que="SELECT type, time FROM officetimings WHERE UID='".$uId."' AND date(time)=CURDATE() - INTERVAL 1 DAY";
//        $re=mysqli_query($conn,$que);
//    }
   
    //var_dump($que); var_dump("==========");
    while($ro=mysqli_fetch_all($re,MYSQLI_ASSOC)){
//        var_dump($ro);
        $recordsArray=$ro;
    }
}
?>

     
<!--
if($_SESSION['uRole']=='3'){
<input type="button" name="" value="View Members" onclick="window.location.href='member_view.php'">

   else if($_SESSION['uRole']=='4'){

<input type="button" name="" value="View Members" onclick="window.location.href='member_view.php'">
<input type="button" name="" value="Admin page" onclick="window.location.href='admin.php'">

   else if($_SESSION['uRole']=='5'){
    
<input type="button" name="" value="Admin page" onclick="window.location.href='admin.php'">
 }

-->

<script>
    uId=<?php echo $_SESSION["uId"] ?>;
    buttonsArray=<?php echo json_encode($buttonsArray); ?>;
    recordsArray=<?php echo json_encode($recordsArray); ?>;
    console.log(buttonsArray);
    console.log(recordsArray);
    
    $(document).ready(function(){
        initialise();
        
    });
</script>
<script type="text/javascript" src="routine.js"></script>
</header>

<div class="container">
    <div class="row" id="buttonsContainerDiv">
    <form id="btnCreateForm" action="routine.php" method="post"></form>
    </div>
    <br>
    <div class="row">
        OFFICE SPENT HOURS:<span id="officeHoursSpan" class="col-md-2">
        </span>
<!--
        OFFICE HOURS:<span id="officeTotalHoursSpan" class="col-md-4">
        </span>
-->
        BREAK HOURS:<span id="breakHoursSpan" class="col-md-2">
        </span>
        WORKING HOURS:<span id="workingHoursSpan" class="col-md-2">
        </span>
<!--        spentHoursInOffice-->
    </div>
    <div class="row">
        <table class="table" id="routineTable">
            <thead>
                <tr>
                    <th>Sr.</th><th>Day</th><th>Date</th><th>Type</th><th>Start Time</th><th>End Time</th><th>Elapse Time</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
</body>
</html>