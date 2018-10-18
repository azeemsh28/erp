<?php 
include_once("header.php");
if(isset($_POST['view'])){
    $_SESSION["usID"]=$_POST['uId'];
    $_SESSION["usNAME"]=$_POST['uName'];
}
    $sDate='';
    $eDate='';
    $usrId=$_SESSION["usID"];
    $usrName=$_SESSION["usNAME"];
    $msg = "You are viewing <b>Today's</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
    $condition="AND date(time)=CURDATE()";

if(isset($_POST['all_records'])){
    $condition='';
$msg = "You are viewing <b>All</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
}

if(isset($_POST['last_month'])){
   $condition="AND YEAR(time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND 
      MONTH(time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)";
 $msg = "You are viewing <b>Last Month's</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
}
if(isset($_POST['this_month'])){
   $condition="AND YEAR(time) = YEAR(CURRENT_DATE()) AND 
      MONTH(time) = MONTH(CURRENT_DATE())";
  $msg =  "You are viewing <b>Current Month's</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
}
if(isset($_POST['yesterday'])){
   $condition="AND date(time) = CURDATE() - INTERVAL 1 DAY";
   $msg =  "You are viewing <b>Yesterday's</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
}
if(isset($_POST['today'])){
   $condition="AND date(time)=CURDATE() ";
    $msg =  "You are viewing <b>Today's</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
}
if(isset($_POST['submit'])){
    if(($_POST['startDate'] != '') && ($_POST['endDate'] != '')){
    $sDate= $_POST['startDate'];
    $eDate= $_POST['endDate'];
    $condition="AND date(time) BETWEEN'".$sDate."' AND'".$eDate."'";
    $msg = "You are viewing records from ".$sDate." to ".$eDate." for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";   
    }else{ ?>
<script>
    alert('you enter incorrect date,try again');

</script>
<?php }
}

if(isset($_POST['prev']) || isset($_POST['next'])){
    $cd= $_POST['curD'];
    $timeStamp = date('Y-m-d', strtotime($cd));
    $condition=" AND date(time)='".$timeStamp."'";
//    $res =mysqli_query($conn, $query);
//    $recordsArray ="";
//    while($row=mysqli_fetch_all($res,MYSQLI_ASSOC)){
//        $recordsArray=$row;
//    }
     if(isset($_POST['prev']) || isset($_POST['next'])){
        $msg = "You are viewing <b>".$timeStamp."</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
     }
        }

if(isset($_POST['buttons']))
{
    if($_POST['buttons']=='allrecords'){
        $condition.='';
    }
    else if($_POST['buttons']=='officein/out'){
        $condition.=" AND (type='officein' OR type='officeout')";
    }
    else if($_POST['buttons']=='breaks'){
        $condition.=" AND (type!='officein' AND type!='officeout' AND type NOT LIKE '%meeting%' )";
    }
    else
    {
      $condition.=" AND (type LIKE '%".$_POST['buttons']."%' OR type='backtoseat')"; 
       
    }
}
//    var_dump($condition);
    $query ="SELECT type, time FROM officetimings WHERE UID='".$usrId."' ".$condition;
//    var_dump($query);

    $res =mysqli_query($conn, $query);
//    var_dump($res);

    $recordsArray ="";
    while($row=mysqli_fetch_all($res,MYSQLI_ASSOC)){
        $recordsArray=$row;
    }
// var_dump($recordsArray);

//if(isset($_POST['prev']) || isset($_POST['next'])){
//   
//    
//    $cd= $_POST['curD'];
//    $timeStamp = date('Y-m-d', strtotime($cd));
//    $query ="SELECT type, time FROM officetimings WHERE UID='".$usrId."' AND date(time)='".$timeStamp."'";
//    $res =mysqli_query($conn, $query);
//    $recordsArray ="";
//    while($row=mysqli_fetch_all($res,MYSQLI_ASSOC)){
//        $recordsArray=$row;
//    }
//     if(isset($_POST['prev']) || isset($_POST['next'])){
//        $msg = "You are viewing <b>".$timeStamp."</b> records for <span style='text-transform:  capitalize;font-weight: 800;'>".$usrName."</span>";
//     }
//        }

    
    $q="SELECT btnID, btnColor FROM buttons";
    $r=mysqli_query($conn, $q);
    $buttonsArray ="";
    while($ro=mysqli_fetch_all($r,MYSQLI_ASSOC)){
        $buttonsArray=$ro;
    }    
?>

<script>
    function getWeekDay(date) {
        var weekday = new Array(7);
        weekday[0] = "Sunday";
        weekday[1] = "Monday";
        weekday[2] = "Tuesday";
        weekday[3] = "Wednesday";
        weekday[4] = "Thursday";
        weekday[5] = "Friday";
        weekday[6] = "Saturday";
        return weekday[date.getDay()];
    }

    buttonsArray = <?php echo json_encode($buttonsArray); ?>;
    var recordsArray = <?php echo json_encode($recordsArray); ?>;
    msg = <?php echo json_encode($msg); ?>;
    var i;
    flag1 = false;
    offHours = 0 + 'h ' + 0 + 'm ' + 0 + 's';
    brkHours = 0 + 'h ' + 0 + 'm ' + 0 + 's';
    workHours = 0 + 'h ' + 0 + 'm ' + 0 + 's';
    offtimehours = 0;
    offtimemins = 0;
    offtimesecs = 0;
    diffInMeetingTimings = 0;
    DFInofficetime = 0;
    dfInreasontime = 0;
    diffofmeetinghours = 0;
    styleSheet = document.createElement('style');
    for (i = 0; i < buttonsArray.length; i++) {
        styleSheet.innerHTML += '.' + buttonsArray[i].btnID + "{ background-color :" + buttonsArray[i].btnColor + "}";
    }

    d = new Date();
    <?php 
            if(isset($_POST['curD']) && $_POST['curD']!=''){?>
    d = new Date("<?php echo $_POST['curD']; ?>");
    <?php } ?>

    function startTime_() {
        var today = new Date();
        var DD = today.getDate();
        var MM = today.getMonth() + 1;
        var YYYY = today.getFullYear();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('span1').innerHTML =
            DD + "/" + MM + "/" + YYYY + " " + h + ":" + m + ":" + s;
        var t = setTimeout(startTime_, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }

    $(document).ready(function() {
        startTime_();
        startTime = 0;
        reaStartTime = 0;
        var dd = d.getDate();
        var mm = d.getMonth() + 1;
        var yyyy = d.getFullYear();

        c = new Date();
        var DD = c.getDate();
        var MM = c.getMonth() + 1;
        var YYYY = c.getFullYear();
        for (i = 0; i < recordsArray.length; i++) {
            tableRecords(recordsArray[i]);
            document.getElementById('brkHoursSpan').innerHTML = brkHours;
        }
        document.getElementById("p1").innerHTML = msg;
        //            document.getElementById("span1").innerHTML = c;
        document.body.appendChild(styleSheet);
        //            document.getElementById("span1").innerHTML = d.toUTCString().substring(0, 16);

        if ((dd == DD) & (mm == MM) & (yyyy == YYYY)) {
            document.getElementById("nextBtn").disabled = true;
        }
        <?php
            if(isset($_POST['buttons'])): ?>
        $("option[value='<?php echo $_POST['buttons'] ?>']").attr('selected', 'selected');
        <?php endif;?>
    });

    function navigate(a) {
        da = d.setDate(d.getDate() + a);
        dat = d.toDateString();
        //                console.log(dat);
        //                console.log(d.toUTCString().substring(0,16));
        //                document.getElementById("span1").innerHTML=d.toUTCString().substring(0,16);
        document.getElementById("dateField").value = dat;
        //            document.forms["prev/nextBtnForm"].submit();
        document.forms["recordsBtn"].submit();
    }
    flag = false;
    function tableRecords(data) {
        var table = document.getElementById("userRecordsTable");
        var Rows = table.tBodies[0].rows;
        var row = Rows.length;
        day = getWeekDay(new Date(Date.parse(data['time'])));
        date = $.datepicker.formatDate('dd MM yy', new Date(Date.parse(data['time'])));
        time = new Date(Date.parse(data['time'])).toTimeString().split(' ')[0];
        if (data['type'] != 'backtoseat') {
            flag = true;
            var latestRow = document.getElementById("userRecordsTable").getElementsByTagName("tbody")[0].insertRow(0);
            cell1 = latestRow.insertCell(0);
            cell2 = latestRow.insertCell(1);
            cell3 = latestRow.insertCell(2);
            cell4 = latestRow.insertCell(3);
            cell5 = latestRow.insertCell(4);
            cell6 = latestRow.insertCell(5);
            cell7 = latestRow.insertCell(6);
            latestRow.className = "otherpurpose " + data['type'];
            if (data['type'] != 'officeout') {
                if (data['type'] == 'officein') {
                    startTime = data['time'];
                } else {
                    if (data['type'].match(/\Wmeeting\W|\Wmeeting|meeting/)) {
                        flag1 = true;
                    }
                    reaStartTime = data['time'];
                }
                cell1.innerHTML = document.getElementsByTagName("tr").length - 1;
                cell2.innerHTML = day;
                cell3.innerHTML = date;
                cell4.innerHTML = data['type'];
                cell5.innerHTML = time;
            } else {
                cell1.innerHTML = document.getElementsByTagName("tr").length - 1;
                cell2.innerHTML = day;
                cell3.innerHTML = date;
                cell4.innerHTML = data['type'];
                cell6.innerHTML = time;
                var officeStartTime = startTime.split(/[- :]/);
                var officeStartTimeUTC = new Date(officeStartTime[0], officeStartTime[1] - 1, officeStartTime[2], officeStartTime[3], officeStartTime[4], officeStartTime[5]);
                var officeEndTime = data['time'].split(/[- :]/);
                var officeEndTimeUTC = new Date(officeEndTime[0], officeEndTime[1] - 1, officeEndTime[2], officeEndTime[3], officeEndTime[4], officeEndTime[5]);
                var diff = officeEndTimeUTC.getTime();
                var DIFF = officeStartTimeUTC.getTime();
                var DF = diff - DIFF;
                DFInofficetime += DF;
                var hrs = Math.floor((DF % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var mins = Math.floor((DF % (1000 * 60 * 60)) / (1000 * 60));
                var secs = Math.floor((DF % (1000 * 60)) / 1000);
                var ttime = hrs + 'h ' + mins + 'm ' + secs + 's ';
                cell7.innerHTML = ttime;
                offtimehours = Math.floor((DFInofficetime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                offtimemins = Math.floor((DFInofficetime % (1000 * 60 * 60)) / (1000 * 60));
                offtimesecs = Math.floor((DFInofficetime % (1000 * 60)) / 1000);
                var diffofworkhours = DFInofficetime - dfInreasontime;
                workingTimingsHours = Math.floor((diffofworkhours % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                workingTimingsMinutes = Math.floor((diffofworkhours % (1000 * 60 * 60)) / (1000 * 60));
                workingTimingsSeconds = Math.floor((diffofworkhours % (1000 * 60)) / 1000);
                workHours = workingTimingsHours + 'h ' + workingTimingsMinutes + 'm ' + workingTimingsSeconds + 's ';
                document.getElementById('workHoursSpan').innerHTML = workHours;
                offHours = offtimehours + 'h ' + offtimemins + 'm ' + offtimesecs + 's';
                document.getElementById('ofcHoursSpan').innerHTML = offHours;
            }
        } else {
            if (flag == true) {     
                var reasonStartTime = reaStartTime.split(/[- :]/);
                var reasonStartTimeUTC = new Date(reasonStartTime[0], reasonStartTime[1] - 1, reasonStartTime[2], reasonStartTime[3], reasonStartTime[4], reasonStartTime[5]);
                cell6.innerHTML = time;
                var reasonEndTime = data['time'].split(/[- :]/);
                var reasonEndTimeUTC = new Date(reasonEndTime[0], reasonEndTime[1] - 1, reasonEndTime[2], reasonEndTime[3], reasonEndTime[4], reasonEndTime[5]);
                var dif = reasonEndTimeUTC.getTime();
                var DIF = reasonStartTimeUTC.getTime();
                var df = dif - DIF;
                var hours = Math.floor((df % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((df % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((df % (1000 * 60)) / 1000);
                var times = hours + "h " + minutes + "m " + seconds + "s ";
                cell7.innerHTML = times;
                if (flag1) {
                    flag1 = false;
                } else {
                    dfInreasontime += df;
                };
                hours = Math.floor((dfInreasontime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                minutes = Math.floor((dfInreasontime % (1000 * 60 * 60)) / (1000 * 60));
                seconds = Math.floor((dfInreasontime % (1000 * 60)) / 1000);
                brkHours = hours + 'h ' + minutes + 'm ' + seconds + 's';
                document.getElementById('brkHoursSpan').innerHTML = brkHours;
                flag = false;
            }
        }
    }

</script>
</header>

<div class="container">
    <div class="row">
        <div id="p1" class="col-md-6"></div>
    </div>
    <div class="row">
        <form id="recordsBtn" action="member_data.php" method="post">
            <select name="buttons">
                    <option value="allrecords">All records</option>
                    <option value="officein/out">Office In/Out</option>
                    <option value="breaks">Breaks</option>
                    <option value="O.p">Other purpose break</option>
                    <option value="meeting">meeting</option>
                    <option value="washroom">washroom break</option>
                    <option value="smooking">Smooking break</option>
                    <option value="prayer">prayer break</option>
                    <option value="lunch">lunch break</option>
                </select>
            <input type="submit" name="all_records" value="- present">
            <input type="submit" name="last_month" value="Last Month">
            <input type="submit" name="this_month" value="This Month">
            <input type="submit" name="yesterday" value="Yesterday">
            <input type="submit" name="today" value="Today">
            <input type="date" name="startDate" value="<?php echo $sDate ?>">
            <input type="date" name="endDate" value="<?php echo $eDate ?>">
            <input type="submit" name="submit" value="Submit">
            <input type="button" value="Back" onclick="window.location.href='member_view.php'">
            <input id="dateField" type="hidden" name="curD" value="">
            <input class="col-md-2" id="prevBtn" type="submit" name="prev" value="Prev" onclick="navigate(-1)">
            <span class="col-md-8" style="text-align:center; padding: 5px" id="span1"></span>
            <input class="col-md-2" id="nextBtn" type="submit" name="next" value="Next" onclick="navigate(1)">
        </form>
    </div>
    <div class="row">
        OFFICE HOURS:<span id="ofcHoursSpan" class="col-md-2">
        </span> BREAK HOURS:<span id="brkHoursSpan" class="col-md-2">
        </span> WORKING HOURS:<span id="workHoursSpan" class="col-md-2">
        </span>
    </div>
    <div class="row">
        <table class="table table-bordered" id="userRecordsTable">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Elapse Time</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
</body>
</html>