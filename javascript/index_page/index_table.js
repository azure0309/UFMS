var audio = new Audio('audio/alert.mp3');
var geoNames = [];
var trunkNames = [];

var argArray = ["ARG1", "ARG2", "ARG3", "ARG4"];
var ipArray = ["empty", "empty", "empty", "empty"];
var countryNameArray = ["empty", "empty", "empty", "empty"];
var countryCodeArray = ["empty", "empty", "empty", "empty"];


function strToDate(dtStr) {
    let dateParts = dtStr.split("-");
    let timeParts = dateParts[2].split(" ")[1].split(":");
    dateParts[2] = dateParts[2].split(" ")[0];
    // month is 0-based, that's why we need dataParts[1] - 1
    // return dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0], timeParts[0], timeParts[1], timeParts[2]);
    return dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0], timeParts[0], timeParts[1], timeParts[2]);
}

function RemoveSpecialChar(str) {
    str = str.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
    // Returning the result
    return str;
}

$(document).on('click','.actionbutton', function(){

    var targetRow = [];
    $(this).closest('tr').find('td').each(function() {
        textval = $(this).text(); // this will be the text of each <td>
        textval = $(this).text(); // this will be the text of each <td>
        targetRow.push(textval);
    });

    console.log(targetRow)

    let type = targetRow[1];
    // let call_to = targetRow[6].substring(1);
    let call_to = targetRow[6];
    let call_from = targetRow[4];
    let result;


    var beanId = $(this).data('beanId');
    var clickedButton = $(this);
    $('#table-body > tr').each(function(){
        if($(this).find('td:eq(0)').text() == beanId){
            // alert("Equals");
            if(clickedButton.text() == 'BLOCK'){
                // console.log("I am not sorry for you");
                console.log("ROOT BLOCK BUTTON CLICKED!")
                if($(this).find("td:eq(2)").text() == "MAJOR"){
                    $(this).removeClass("warning-fraud");
                    $(this).addClass("not-fraud");
                    $.ajax({
                        url: 'controller/index_page/status_changer.php',
                        type: "POST",
                        data: {id:$(this).find("td:eq(0)").text(), toggle:'action'},
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            alert("changed");
                        },
                        cache: false
                    });
                }
                else if($(this).find("td:eq(2)").text() == "MINOR"){
                    $(this).removeClass("danger-minor");
                    $(this).addClass("danger-cleared-minor");
                    $.ajax({
                        url: 'controller/index_page/status_changer.php',
                        type: "POST",
                        data: {id:$(this).find("td:eq(0)").text(), toggle:'action'},
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            alert("changed");
                        },
                        cache: false
                    });
                }
                else if($(this).find("td:eq(2)").text() == "CRITICAL"){
                    $(this).removeClass("danger-fraud");
                    $(this).addClass("danger-cleared-fraud");
                    $.ajax({
                        url: 'controller/index_page/status_changer.php',
                        type: "POST",
                        data: {id:$(this).find("td:eq(0)").text(), toggle:'action'},
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            alert("changed");
                        },
                        cache: false
                    });
                }
            }
            else if(clickedButton.text() == 'BLOCKED'){
                // console.log("I am so sorry");
                console.log("ROOT BLOCKED BUTTON CLICKED!")
                // if($(this).find("td:eq(2)").text() == "MINOR"){
                //     $(this).removeClass("danger-cleared-minor");
                //     $(this).addClass("danger-minor");
                //     $.ajax({
                //         url: 'controller/index_page/status_changer.php',
                //         type: "POST",
                //         data: {id:$(this).find("td:eq(0)").text(), toggle:'reverse'},
                //         dataType: "json",
                //         async: false,
                //         success: function(data) {
                //             alert("changed");
                //         },
                //         cache: false
                //     });
                // }
                // else if($(this).find("td:eq(2)").text() == "MAJOR"){
                //     $(this).removeClass("not-fraud");
                //     $(this).addClass("warning-fraud");
                //     $.ajax({
                //         url: 'controller/index_page/status_changer.php',
                //         type: "POST",
                //         data: {id:$(this).find("td:eq(0)").text(), toggle:'reverse'},
                //         dataType: "json",
                //         async: false,
                //         success: function(data) {
                //             alert("changed");
                //         },
                //         cache: false
                //     });
                // }
                // else if($(this).find("td:eq(2)").text() == "CRITICAL"){
                //     $(this).removeClass("danger-cleared-fraud");
                //     $(this).addClass("danger-fraud");
                //     $.ajax({
                //         url: 'controller/index_page/status_changer.php',
                //         type: "POST",
                //         data: {id:$(this).find("td:eq(0)").text(), toggle:'reverse'},
                //         dataType: "json",
                //         async: false,
                //         success: function(data) {
                //             alert("changed");
                //         },
                //         cache: false
                //     });
                // }

            }
        }
    });
    if(clickedButton.text() == 'BLOCK'){
        // clickedButton.removeClass("btn btn-info");
        // clickedButton.addClass("btn btn-warning");
        // clickedButton.text('BLOCKED');
        console.log("BLOCK BUTTON CLICKED!");
        console.log("ROW: " + targetRow);
        console.log("TYPE: " + targetRow[1]);
        // console.log("CALL_FROM: " + targetRow[4]);
        // console.log("CALL_TO: " + call_to);

        if(
            type === 'OD_OUT ONE TO MANY: 1 hour' ||
            type === 'OD_OUT MANY TO ONE: 24 hours' ||
            type === 'OD_OUT MANY TO ONE: 1 hour' ||
            type === 'OD_OUT ONE TO MANY: 24 hours' ||
            type === 'OD_OUT MANY TO ONE: 6 hours' ||
            type === 'OD_OUT ONE TO MANY: 6 hour' ||
            type === 'OD_OUT MANY TO ONE: 3 hours' ||
            type === 'OD_OUT ONE TO MANY: 24 hour' ||
            type === 'OD_OUT ONE TO MANY: 3 hour'
        )
        {
            if(call_to != null && call_from === '------'){
                clickedButton.removeClass("btn btn-info");
                clickedButton.addClass("btn btn-warning");
                clickedButton.text('Loading...');
                $.ajax({
                    type: "GET",
                    url: "https://ufms.uni/Test/controller/index_page/block_action.php",
                    data: {'user_num':call_to },
                    success: function (msg) {
                        // console.log("call to block response:" + msg)
                        // console.log("call to block response: end" + msg)
                        // console.log(msg);

                        // var PFX = msg.substring(
                        //     msg.lastIndexOf("CSCNAME=\"ALL\", ") + 1,
                        //     msg.lastIndexOf(", CPFX")
                        // );
                        // var CPFX = msg.substring(
                        //     msg.lastIndexOf("CPFX=") + 1,
                        //     msg.lastIndexOf(", PCDN")
                        // );

                        // let dtStr = "12/03/2010 09:55:35"
                        let dtStr = "11-10-2020 08:40:00"


                        console.log('CREATED DATE: ' + strToDate(dtStr));  // Fri Mar 12 2010 09:55:35


                        var PFX = msg.split(', PFX=')[1].split(',')[0];
                        var CPFX = msg.split(', CPFX=')[1].split(',')[0];
                        var PCDN = msg.split('PCDN="')[1].split('",')[0];
                        var PT = msg.split('PT=')[1].split(',')[0];

                        console.log(targetRow[8])
                        console.log(PFX)
                        console.log(CPFX)
                        console.log(PCDN)
                        console.log(PT)

                        $.ajax({
                            // url: 'controller/index_page/block_insert.php',
                            url: 'https://ufms.uni/Test/controller/index_page/block_insert.php',
                            type: "POST",
                            data: {id:'1', toggle:'action', c_type: type, callfrom: call_from, callto: call_to, pfx: PFX, cpfx: CPFX, pcdn: PCDN, pt: PT, created_date : targetRow[8]},
                            dataType: "json",
                            async: false,
                            success: function(data) {
                                alert("changed");
                                console.log("insert changed")
                            },
                            cache: false
                        });




                        let count = 0;
                        let position = msg.indexOf('RETCODE = 0');
                        while (position !== -1) {
                            count++;
                            position = msg.indexOf('RETCODE = 0', position + 1);
                        }
                        console.log("COUNT: " + count);
                        if(count === 3) {
                            console.log("TRUE!!!");
                            clickedButton.removeClass("btn btn-warning");
                            clickedButton.addClass("btn btn-info");
                            clickedButton.text('BLOCKED');
                        }
                    }
                });
            }else if(call_from != null && call_to === '------') {
                call_from = RemoveSpecialChar(call_from);
                console.log('CALLFROM = ' + call_from)
                clickedButton.removeClass("btn btn-info");
                clickedButton.addClass("btn btn-warning");
                clickedButton.text('Loading...');
                $.ajax({
                    type: "GET",
                    url: "https://ufms.uni/Test/controller/index_page/block_callfrom.php",
                    data: {'user_num':call_from },
                    success: function (msg) {
                        // console.log('---------------- RESPONSE ------------' + msg)
                        console.log(msg);
                        let count = 0;
                        let position = msg.indexOf('RETCODE = 0');
                        while (position !== -1) {
                            count++;
                            position = msg.indexOf('RETCODE = 0', position + 1);
                        }
                        console.log("COUNT: " + count);
                        if(count === 3) {
                            console.log("TRUE!!!");
                            clickedButton.removeClass("btn btn-warning");
                            clickedButton.addClass("btn btn-info");
                            clickedButton.text('BLOCKED');
                        }
                    }
                });
            }
        }else  {
            alert("BLOCK хийгдээгүй!")
        }


    }
    else if(clickedButton.text() == 'BLOCKED'){
        // clickedButton.removeClass("btn btn-warning");
        // clickedButton.addClass("btn btn-info");
        // clickedButton.text('BLOCK');
        console.log("BLOCKED BUTTON CLICKED!")
        if(type === 'OD_OUT MANY TO ONE' && call_to != null && call_from === '------'){
            $.get("https://ufms.uni/Test/controller/index_page/block_action.php",{'user_num':call_to },function(data){
                result = data;
                console.log(result);
                // RETCODE = 313303 Same record exists in Call Rights Check table[ADD CALLPRICHK]
                const n = result.includes("RETCODE = 313303");
                if(n) {
                    console.log("BLOCK хийгдсэн байна!");
                    alert("BLOCK хийгдсэн байна!")
                }else {
                    console.log("BLOCK хийх шаардлагатай!");
                }
            });
        }
    }
});
$(document).ready(function(){
    getTrunkNames();
    getData();
});

function getTrunkNames(){

    $.ajax({
        url: 'json/export.json',
        type: "GET",
        dataType: "json",
        async: false,
        success: function(data) {
            geoNames = data;
        },
        cache: false
    });
    $.ajax({
        url: 'json/trunk.json',
        type: "GET",
        dataType: "json",
        async: false,
        success: function(data) {
            trunkNames = data;
        },
        cache: false
    });
    // console.log(trunkNames);
}


function getCountryCode(ipaddress){
    var cc = '';
    var tn = '';
    var splitAddress = ipaddress.split(".");
    var ipNumber = Number(splitAddress[0])*16777216 + Number(splitAddress[1])*65536 + Number(splitAddress[2])*256 + Number(splitAddress[3]);
    for(var i = 0; i<geoNames.length; i++){
        if(geoNames[i]["begin_ip_num"] <= ipNumber && geoNames[i]["end_ip_num"] >= ipNumber){
            cc = geoNames[i]["country_code"];
        }
    }
    for (var j = 0; j<trunkNames.length; j++){
        // console.log(trunkNames[j].ip);
        if(trunkNames[j].ip == ipaddress){
            tn = trunkNames[j].name;
        }
    }
    return [tn, cc];
}

function clearTable(){
    $('#table-body tr').remove();
}

function ValidateIPaddress(ipaddress)
{
    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress))
    {
        return true;
    }else{
        return false;
    }
}

function getData(){
    //here will be my ajax request
    $.get("controller/index_page/liveChart.php", function(data, status){
        if(status == "success"){
            // console.log(data);
            clearTable();
            for (var i = 0; i < data.length; i++) {
                for(var j = 0; j< argArray.length; j++){
                    if(ValidateIPaddress(data[i][argArray[j]])){
                        var country = getCountryCode(data[i][argArray[j]]);
                        ipArray[j] = argArray[j];
                        countryNameArray[j] = country[0];
                        countryCodeArray[j] = country[1];
                    }
                }
                // console.log(data[i]["STATUS"]);
                if(data[i]["STATUS"] == 0){

                    if(data[i]["LVL"] == 1){ // LEVEL 1 baival LEVEL 2 toi adilhan haragdana
                        var row = $("<tr class='danger-minor' />")
                    }
                    else if(data[i]["LVL"] == 2){
                        var row = $("<tr class='warning-fraud' />")
                    }
                    else if(data[i]["LVL"] == 3){
                        var row = $("<tr class='danger-fraud' />")
                    }
                    row.append("<td style='display:none'>" + data[i]["ALERT_ID"] + "</td>");
                    row.append("<td>" + data[i]["TYPE"] + "</td>");
                    if(data[i]["LVL"] == 1)
                    {
                        row.append("<td>MINOR</td>");
                    }
                    else if(data[i]["LVL"] == 2)
                    {
                        row.append("<td>MAJOR</td>");
                    }
                    else if(data[i]["LVL"] == 3)
                    {
                        row.append("<td>CRITICAL</td>");
                    }


                    for(var p = 0; p < argArray.length; p++){
                        if(ipArray[p] == "empty"){
                            if(data[i][argArray[p]] === null){
                                row.append("<td>------</td>");
                            }else{
                                row.append("<td>" + data[i][argArray[p]] + "</td>");
                            }
                        }else{
                            row.append("<td><table><tr><td><a title='" + countryNameArray[p] + "'><div class='flag flag-" + countryCodeArray[p] + "'></div></a><td/><td> " + data[i][argArray[p]] + "<td/></tr></table></td>");
                        }
                    }
                    if(data[i]["CONTENT"] === null){
                        row.append("<td>---||---</td>");
                    }else{
                        row.append("<td>" + data[i]["CONTENT"] + "</td>");
                    }
                    row.append("<td>" + data[i]["CREATED"] + "</td>");
                    row.append("<td><button class='actionbutton form-control btn btn-info' data-bean-id='"+data[i]["ALERT_ID"]+"'>BLOCK</button></td>");
                    // row.append("<td><button class='btn btn-sample form-control' id='"+data[i]["ALERT_ID"]+"'>")
                    $("#table-body").append(row);
                    // audio.play();
                }else{
                    if(data[i]["LVL"]==1)
                    {
                        var row = $("<tr class='danger-cleared-minor' />")
                    }
                    if(data[i]["LVL"] == 2){
                        var row = $("<tr class='not-fraud' />")

                    }else if(data[i]["LVL"] == 3){
                        var row = $("<tr class='danger-cleared-fraud' />")
                        // alert("LVL 3");
                    }
                    row.append("<td style='display:none'>" + data[i]["ALERT_ID"] + "</td>");
                    row.append("<td>" + data[i]["TYPE"] + "</td>");
                    if(data[i]["LVL"] == 1)
                    {
                        row.append("<td>MINOR</td>");
                    }
                    else if(data[i]["LVL"] == 2)
                    {
                        row.append("<td>MAJOR</td>");
                    }
                    else if(data[i]["LVL"] == 3)
                    {
                        row.append("<td>CRITICAL</td>");
                    }
                    for(var p = 0; p < argArray.length; p++){
                        if(ipArray[p] == "empty"){
                            if(data[i][argArray[p]] === null){
                                row.append("<td>------</td>");
                            }else{
                                row.append("<td>" + data[i][argArray[p]] + "</td>");
                            }
                        }else{
                            row.append("<td><table><tr><td><a title='" + countryNameArray[p] + "'><div class='flag flag-" + countryCodeArray[p] + "'></div></a><td/><td> " + data[i][argArray[p]] + "<td/></tr></table></td>");
                        }
                    }
                    if(data[i]["CONTENT"] === null){
                        row.append("<td>---||---</td>");
                    }else{
                        row.append("<td>" + data[i]["CONTENT"] + "</td>");
                    }
                    row.append("<td>" + data[i]["CREATED"] + "</td>");
                    row.append("<td><button class='actionbutton form-control btn btn-warning' data-bean-id='"+data[i]["ALERT_ID"]+"'>BLOCKED</button></td>");
                    $("#table-body").append(row);
                }
                ipArray = ["empty", "empty", "empty", "empty"];
                countryNameArray = ["empty", "empty", "empty", "empty"];
                countryCodeArray = ["empty", "empty", "empty", "empty"];
            }
        }
        else{
            alert("There is an Error. Report error to Lkhagvadorj.ba@unitel.mn!")
        }
    });
    setTimeout(getData,10000);
}


