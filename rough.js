//var BUTTONS = [{"id":"otherpurpose", "value":"Other Purpose Break", "color":"pink"}, {"id":"meeting", "value":"Meeting Break", "color":"brown"}, {"id":"washroom", "value":"Washroom Break", "color":"blue"}, {"id":"smooking", "value":"Smooking Break", "color":"red"}, {"id":"prayer", "value":"Prayer Break", "color":"green"}, {"id":"lunch", "value":"Lunch Break", "color":"yellow"}, {"id":"backtoseat", "value":"Back To Seat", "color":"orange"}, {"id":"officein", "value":"Office In", "color":"Light_Gray"}, {"id":"officeout", "value":"Office Out", "color":"Light_Gray"} ];
//var buttons = JSON.parse(BUTTONS);

//function timeDifference(date1,date2) {
//        var difference = date1.getTime() - date2.getTime();
//
//        var daysDifference = Math.floor(difference/1000/60/60/24);
//        difference -= daysDifference*1000*60*60*24
//
//       var hoursDifference = Math.floor(difference/1000/60/60);
//        difference -= hoursDifference*1000*60*60
//
//        var minutesDifference = Math.floor(difference/1000/60);
//        difference -= minutesDifference*1000*60
//
//        var secondsDifference = Math.floor(difference/1000);
//
//     alert('difference = ' + daysDifference + ' day/s ' + hoursDifference + ' hour/s ' + minutesDifference + ' minute/s ' + secondsDifference + ' second/s ');
//}

//        var diff = dif /1000;
//        var h = diff / 60 * 60 * 1000;
//        var m = diff / 60 * 1000;
//        var s = diff / 60 % 1000;
//        var tim = h + ":" + m + ":" + s;

//    timeDifference(new Date('2018-06-01 14:21:48'), new Date('2018-06-01 12:53:57'));

//checkOfficeOut = false;
//checkBackToSeat = false;
//     checkBackToSeat = false;
//     checkBackToSeat = true;
//            checkOfficeOut = false;
//            checkOfficeOut = true;

//    if(checkOfficeOut){
//        document.getElementById("officeout").disabled = true;
//        document.getElementById("officein").disabled = false;
//        document.getElementById("otherpurpose").disabled = true;
//        document.getElementById("meeting").disabled = true;
//        document.getElementById("washroom").disabled = true;
//        document.getElementById("smooking").disabled = true;
//        document.getElementById("prayer").disabled = true;
//        document.getElementById("lunch").disabled = true;
//        document.getElementById("backtoseat").disabled = true;
//        if(checkBackToSeat){
//            document.getElementById("backtoseat").disabled =true;
//            document.getElementById("officein").disabled =true;
//            document.getElementById("otherpurpose").disabled =false;
//            document.getElementById("meeting").disabled =false;
//            document.getElementById("washroom").disabled =false;
//            document.getElementById("smooking").disabled =false;
//            document.getElementById("prayer").disabled =false;
//            document.getElementById("lunch").disabled =false;
//            document.getElementById("officeout").disabled =false;
//            }else{
//            document.getElementById("backtoseat").disabled =false;
//            document.getElementById("officein").disabled =true;
//            document.getElementById("otherpurpose").disabled =true;
//            document.getElementById("meeting").disabled =true;
//            document.getElementById("washroom").disabled =true;
//            document.getElementById("smooking").disabled =true;
//            document.getElementById("prayer").disabled =true;
//            document.getElementById("lunch").disabled =true;
//            document.getElementById("officeout").disabled =true;
//            }
//        
//        }else{
//        document.getElementById("officeout").disabled = false;
//        document.getElementById("officein").disabled = true;
//        document.getElementById("otherpurpose").disabled = false;
//        document.getElementById("meeting").disabled = false;
//        document.getElementById("washroom").disabled = false;
//        document.getElementById("smooking").disabled = false;
//        document.getElementById("prayer").disabled = false;
//        document.getElementById("lunch").disabled = false;
//        document.getElementById("backtoseat").disabled = false;
//        }