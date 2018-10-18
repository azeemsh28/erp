var i;
flag=false;
officeHours=0+'h '+0+'m '+0+'s';
breakHours=0+'h '+0+'m '+0+'s';
//spentHours=0+'h '+0+'m '+0+'s';
workingHours=0+'h '+0+'m '+0+'s';
breaktimehours=0;
breaktimemins=0;
breaktimesecs=0;
officetimehours=0;
officetimemins=0;
officetimesecs=0;
diffInOfficeTimings=0;
diffInReasonTimings=0;
diffInMeetingTimings=0;
function initialise(){
    styleSheet = document.createElement('style');
    for(i=0; i<buttonsArray.length; i++){
        var btn=document.createElement("button");
        btn.id=buttonsArray[i].btnID;
        btn.name=buttonsArray[i].btnID;
        btn.value=buttonsArray[i].btnValue;
        btn.innerHTML=btn.value;
        btn.disabled=true;
        styleSheet.innerHTML += '.' + btn.id + "{ background-color :" + buttonsArray[i].btnColor + " }";
        document.getElementById("btnCreateForm").appendChild(btn);
    }
    document.body.appendChild(styleSheet);
    document.getElementById("officein").disabled = false;
    $(document).ready(function(){
        $("button").click(function(e){
            if(e.target.id=='officein'){
                document.getElementById('otherpurpose').disabled=false;
                document.getElementById('meeting').disabled=false;
                document.getElementById('washroom').disabled=false;
                document.getElementById('smoking').disabled=false;
                document.getElementById('prayer').disabled=false;
                document.getElementById('lunch').disabled=false;
                document.getElementById('backtoseat').disabled=true;
                document.getElementById('officein').disabled=true;
                document.getElementById('officeout').disabled=false;
                ajaxPass(e.target.id);
            }else if(e.target.id=='officeout'){
                if(confirm("Are you sure you want to OFFICE OUT ?")){
                    document.getElementById('otherpurpose').disabled=true;
                    document.getElementById('meeting').disabled=true;
                    document.getElementById('washroom').disabled=true;
                    document.getElementById('smoking').disabled=true;
                    document.getElementById('prayer').disabled=true;
                    document.getElementById('lunch').disabled=true;
                    document.getElementById('backtoseat').disabled=true;
                    document.getElementById('officein').disabled=false;
                    document.getElementById('officeout').disabled=true;
                    ajaxPass(e.target.id);
                }
            }else if((e.target.id!='officein') && (e.target.id!='officeout') && (e.target.id!='backtoseat')){
                if(e.target.id!='otherpurpose'){
                    timer();
                    ajaxPass(e.target.id);
                }else{
                    ajaxPass(e.target.id);
                }
            }else if(e.target.id=='backtoseat'){
                stop();
                
                ajaxPass(e.target.id);
            }
        });
    });
    show();
    document.getElementById('officeHoursSpan').innerHTML=officeHours;
}

function timer(){
    document.getElementById('otherpurpose').disabled=true;
    document.getElementById('meeting').disabled=true;
    document.getElementById('washroom').disabled=true;
    document.getElementById('smoking').disabled=true;
    document.getElementById('prayer').disabled=true;
    document.getElementById('lunch').disabled=true;
    document.getElementById('backtoseat').disabled=false;
    document.getElementById('officein').disabled=true;
    document.getElementById('officeout').disabled=true;
}

function stop(){
    document.getElementById('otherpurpose').disabled=false;
    document.getElementById('meeting').disabled=false;
    document.getElementById('washroom').disabled=false;
    document.getElementById('smoking').disabled=false;
    document.getElementById('prayer').disabled=false;
    document.getElementById('lunch').disabled=false;
    document.getElementById('backtoseat').disabled=true;
    document.getElementById('officein').disabled=true;
    document.getElementById('officeout').disabled=false;
}

function ajaxPass(reason){
    var callAjax = true;
    if(reason=='otherpurpose'){
        var reaSon = (prompt("Please Enter Your Reason: ", ""));
        //var reaSon="O.p - " + prompt("Please Enter Your Reason: ", "");
        if (reaSon == null || reaSon == 'null' || reaSon == "") {
            alert("User cancelled the prompt.");
            callAjax = false;
        }else{
            timer();
            reaSon = "O.p - " + reaSon;
        }
    }
    
    if(callAjax == true)
    {
    $.ajax({
            url: "save_routine_settings.php",
            method: "POST",
            dataType: "json",
            data: {
            type: reason,
            typeDetail: reaSon,
            uID: uId
            },
            success: function(data){
            console.log(data);
            Routine(data);
            },
            complete: function(data, status){
            if(status=='parsererror'){
                window.location.href='/erp';
            }
            console.log(data + " , " + status);
            }
            });
    }
}

function show(){
    var i;
    OFFICESTARTTIME=0;
    reaStartTime=0;
    for(i=0; i<recordsArray.length; i++){
        Routine(recordsArray[i]);
        document.getElementById("breakHoursSpan").innerHTML=breakHours;        
        document.getElementById("workingHoursSpan").innerHTML=workingHours;        
    }
}

function Routine(data){
    var table=document.getElementById("routineTable");
    var row=table.tBodies[0].rows;
    var rowLength=row.length;
    day = getWeekDay(new Date(Date.parse(data['time'])));
    date = $.datepicker.formatDate('dd MM yy', new Date(Date.parse(data['time'])));
    time = new Date(Date.parse(data['time'])).toTimeString().split(' ')[0];
    if(data['type']!='backtoseat'){
        var latestRow=document.getElementById("routineTable").getElementsByTagName("tbody")[0].insertRow(0);
        CELL1=latestRow.insertCell(0);
        CELL2=latestRow.insertCell(1);
        CELL3=latestRow.insertCell(2);
        CELL4=latestRow.insertCell(3);
        CELL5=latestRow.insertCell(4);
        CELL6=latestRow.insertCell(5);
        CELL7=latestRow.insertCell(6);
        latestRow.className="otherpurpose " + data['type'];
        if(data['type']!='officeout'){
            document.getElementById("backtoseat").disabled=false;
            document.getElementById("officein").disabled=true;
            document.getElementById("otherpurpose").disabled=true;
            document.getElementById("meeting").disabled=true;
            document.getElementById("washroom").disabled=true;
            document.getElementById("smoking").disabled=true;
            document.getElementById("prayer").disabled=true;
            document.getElementById("lunch").disabled=true;
            document.getElementById("officeout").disabled=true;
            if(data['type']=='officein'){
                OFFICESTARTTIME=data['time'];
                startTime_();
                document.getElementById("officeout").disabled=false;
                document.getElementById("officein").disabled=true;
                document.getElementById("otherpurpose").disabled=false;
                document.getElementById("meeting").disabled=false;
                document.getElementById("washroom").disabled=false;
                document.getElementById("smoking").disabled=false;
                document.getElementById("prayer").disabled=false;
                document.getElementById("lunch").disabled=false;
                document.getElementById("backtoseat").disabled=true;
            }else{
                if(data['type'].match(/\Wmeeting\W|\Wmeeting|meeting/)){
                flag=true;
                }
                    reaStartTime=data['time'];
                }
            CELL1.innerHTML=document.getElementsByTagName("tr").length - 1;
            CELL2.innerHTML=day;
            CELL3.innerHTML=date;
            CELL4.innerHTML=data['type'];
            CELL5.innerHTML=time;
        }else{
            document.getElementById("officeout").disabled=true;
            document.getElementById("officein").disabled=false;
            document.getElementById("otherpurpose").disabled=true;
            document.getElementById("meeting").disabled=true;
            document.getElementById("washroom").disabled=true;
            document.getElementById("smoking").disabled=true;
            document.getElementById("prayer").disabled=true;
            document.getElementById("lunch").disabled=true;
            document.getElementById("backtoseat").disabled=true;
            CELL1.innerHTML=document.getElementsByTagName("tr").length - 1;
            CELL2.innerHTML=day;
            CELL3.innerHTML=date;
            CELL4.innerHTML=data['type'];
            CELL6.innerHTML=time;
            officeStartTime=OFFICESTARTTIME.split(/[- :]/);
            officeStartTimeUTC=new Date(officeStartTime[0], officeStartTime[1] - 1, officeStartTime[2], officeStartTime[3], officeStartTime[4], officeStartTime[5]);
            var officeEndTime=data['time'].split(/[- :]/);
            var officeEndTimeUTC=new Date(officeEndTime[0], officeEndTime[1] - 1, officeEndTime[2], officeEndTime[3], officeEndTime[4], officeEndTime[5]);
            var offIceEndTime=officeEndTimeUTC.getTime();
            offIceStartTime=officeStartTimeUTC.getTime();
            var differenceInOfficeTimings=offIceEndTime - offIceStartTime;
            diffInOfficeTimings+=differenceInOfficeTimings;
            officeTimingsHours=Math.floor((differenceInOfficeTimings % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            officeTimingsMinutes=Math.floor((differenceInOfficeTimings % (1000 * 60 * 60)) / (1000 * 60));
            officeTimingsSeconds=Math.floor((differenceInOfficeTimings % (1000 * 60)) / 1000);
            officeTimingsTime=officeTimingsHours + 'h ' + officeTimingsMinutes + 'm ' + officeTimingsSeconds + 's ';
            CELL7.innerHTML=officeTimingsTime;
            clearTimeout(t);
            officeTimingsHours=Math.floor((diffInOfficeTimings % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            officeTimingsMinutes=Math.floor((diffInOfficeTimings % (1000 * 60 * 60)) / (1000 * 60));
            officeTimingsSeconds=Math.floor((diffInOfficeTimings % (1000 * 60)) / 1000);
            var diffofworkinghours=diffInOfficeTimings-diffInReasonTimings;
            workingTimingsHours=Math.floor((diffofworkinghours % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            workingTimingsMinutes=Math.floor((diffofworkinghours % (1000 * 60 * 60)) / (1000 * 60));
            workingTimingsSeconds=Math.floor((diffofworkinghours % (1000 * 60)) / 1000);
            workingHours=workingTimingsHours + 'h ' + workingTimingsMinutes + 'm ' + workingTimingsSeconds + 's ';
            officeHours=officeTimingsHours+'h '+officeTimingsMinutes+'m '+officeTimingsSeconds+'s';
            document.getElementById('officeHoursSpan').innerHTML=officeHours; 
        }
    }else{
        document.getElementById("backtoseat").disabled=true;
        document.getElementById("officein").disabled=true;
        document.getElementById("otherpurpose").disabled=false;
        document.getElementById("meeting").disabled=false;
        document.getElementById("washroom").disabled=false;
        document.getElementById("smoking").disabled=false;
        document.getElementById("prayer").disabled=false;
        document.getElementById("lunch").disabled=false;
        document.getElementById("officeout").disabled=false;
        var reasonStartTime=reaStartTime.split(/[- :]/);
        var reasonStartTimeUTC=new Date(reasonStartTime[0], reasonStartTime[1] - 1, reasonStartTime[2], reasonStartTime[3], reasonStartTime[4], reasonStartTime[5]);
        CELL6.innerHTML=time;
        var reasonEndTime=data['time'].split(/[- :]/);
        var reasonEndTimeUTC=new Date(reasonEndTime[0], reasonEndTime[1] - 1, reasonEndTime[2], reasonEndTime[3], reasonEndTime[4], reasonEndTime[5]);
        var reaSonEndTime=reasonEndTimeUTC.getTime();
        var reaSonStartTime=reasonStartTimeUTC.getTime();
        var differenceInReasonTimings=reaSonEndTime - reaSonStartTime;
        reasonTimingsHours=Math.floor((differenceInReasonTimings % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        reasonTimingsMinutes=Math.floor((differenceInReasonTimings % (1000 * 60 * 60)) / (1000 * 60));
        reasonTimingsSeconds=Math.floor((differenceInReasonTimings % (1000 * 60)) / 1000);
        reasonTimingsTime=reasonTimingsHours + "h " + reasonTimingsMinutes + "m " + reasonTimingsSeconds + "s ";
        CELL7.innerHTML=reasonTimingsTime;
        if (flag) {
            flag = false;
            } else {
                diffInReasonTimings+=differenceInReasonTimings;
                };
        reasonTimingsHours=Math.floor((diffInReasonTimings % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        reasonTimingsMinutes=Math.floor((diffInReasonTimings % (1000 * 60 * 60)) / (1000 * 60));
        reasonTimingsSeconds=Math.floor((diffInReasonTimings % (1000 * 60)) / 1000);            
        breakHours=reasonTimingsHours+'h '+reasonTimingsMinutes+'m '+reasonTimingsSeconds+'s';
        return;
    }
}
function startTime_() {
            today = new Date();
            tTime=today.getTime();
            officeInStartTime=OFFICESTARTTIME.split(/[- :]/);
            officeInStartTimeUTC=new Date(officeInStartTime[0], officeInStartTime[1] - 1, officeInStartTime[2], officeInStartTime[3], officeInStartTime[4], officeInStartTime[5]);
            offIceInStartTime=officeInStartTimeUTC.getTime();
            differenceInOfficeInTimings=tTime - offIceInStartTime;
            officeInTimingsHours=Math.floor((differenceInOfficeInTimings % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            officeInTimingsMinutes=Math.floor((differenceInOfficeInTimings % (1000 * 60 * 60)) / (1000 * 60));
            officeInTimingsSeconds=Math.floor((differenceInOfficeInTimings % (1000 * 60)) / 1000);
            h=officeInTimingsHours;
            m=officeInTimingsMinutes;
            s=officeInTimingsSeconds
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('officeHoursSpan').innerHTML=h + ":" + m + ":" + s;
            t = setTimeout(startTime_, 500);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            } // add zero in front of numbers < 10
            return i;
        }
function getWeekDay(date){
            var weekday = new Array(7);
            weekday[0] =  "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";
            return weekday[date.getDay()];
        }