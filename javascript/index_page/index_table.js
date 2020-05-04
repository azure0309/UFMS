var audio = new Audio('audio/alert.mp3');
var geoNames = [];
var trunkNames = [];

var argArray = ["ARG1", "ARG2", "ARG3", "ARG4"];
var ipArray = ["empty", "empty", "empty", "empty"];
var countryNameArray = ["empty", "empty", "empty", "empty"];
var countryCodeArray = ["empty", "empty", "empty", "empty"];


$(document).on('click','.actionbutton', function(){

    var targetRow = [];
    $(this).closest('tr').find('td').each(function() {
        textval = $(this).text(); // this will be the text of each <td>
        textval = $(this).text(); // this will be the text of each <td>
        targetRow.push(textval);
    });


    var beanId = $(this).data('beanId');
    var clickedButton = $(this);
    $('#table-body > tr').each(function(){
        if($(this).find('td:eq(0)').text() == beanId){
            // alert("Equals");
            if(clickedButton.text() == 'Action'){
                console.log("I am not sorry for you");
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
                    console.log("Action->CRITICAL");
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
            else if(clickedButton.text() == 'Reverse'){

                console.log("I am so sorry");

                if($(this).find("td:eq(2)").text() == "MINOR"){
                    $(this).removeClass("danger-cleared-minor");
                    $(this).addClass("danger-minor");
                    $.ajax({
                        url: 'controller/index_page/status_changer.php',
                        type: "POST",
                        data: {id:$(this).find("td:eq(0)").text(), toggle:'reverse'},
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            alert("changed");
                        },
                        cache: false
                    });
                }
                else if($(this).find("td:eq(2)").text() == "MAJOR"){
                    $(this).removeClass("not-fraud");
                    $(this).addClass("warning-fraud");
                    $.ajax({
                        url: 'controller/index_page/status_changer.php',
                        type: "POST",
                        data: {id:$(this).find("td:eq(0)").text(), toggle:'reverse'},
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            alert("changed");
                        },
                        cache: false
                    });
                }
                else if($(this).find("td:eq(2)").text() == "CRITICAL"){
                    $(this).removeClass("danger-cleared-fraud");
                    $(this).addClass("danger-fraud");
                    $.ajax({
                        url: 'controller/index_page/status_changer.php',
                        type: "POST",
                        data: {id:$(this).find("td:eq(0)").text(), toggle:'reverse'},
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            alert("changed");
                        },
                        cache: false
                    });
                }
            }
        }
    });


    let call_to;
    if (clickedButton.text() === 'BLOCKED') {
        console.log("YEPP!!!" + targetRow)

        call_to = targetRow[6].substring(1);
        console.log("SUB: " + call_to);

        // $.get("https://ufms.uni/Test/controller/index_page/block_action.php",{'user_num':call_to },function(data){
        //     // data now contains "Hello from 2"
        //     alert("RESULT: " + data);
        // });


        // $.ajax({
        //     url: "https://ufms.uni/Test/index.php&f=hello",
        //     type: "GET",
        //     success: function(data){
        //         //Do something here with the "data"
        //         alert("success!!!");
        //     }
        // });



        // $.ajax({
        //     url: 'https://ufms.uni/Test/controller/index_page/block_action.php',
        //     type: "POST",
        //     data: { v_number : call_to},
        //     dataType: "text",
        //     async: false,
        //     success: function(data) {
        //         alert("changed");
        //     },
        //     //     error: function (xhr, ajaxOptions, thrownError) {
        //     //         alert(xhr.status);
        //     //         alert(ajaxOptions);
        //     //         alert(thrownError);
        //     //     }
        //     cache: false
        // });


        // $.ajax({
        //     // url: 'https://ufms.uni/Test/index.php',
        //     // url: 'https://ufms.uni/Test/index.php',
        //     url: 'https://ufms.uni/Test/controller/index_page/block_action.php',
        //     type: "GET",
        //     data: { v_number : call_to},
        //     // dataType: "text",
        //     success: function(data) {
        //         alert("changed");
        //         console.log("success"  + call_to)
        //         // $('#user_num').text('NUMBER : ' + data);
        //         document.getElementById("user_num").innerHTML = call_to;
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         alert(xhr.status);
        //         alert(ajaxOptions);
        //         alert(thrownError);
        //     }
        // });



        // clickedButton.removeClass("btn btn-info");
        // clickedButton.addClass("btn btn-warning");
        // clickedButton.text('Reverse');
    } else if (clickedButton.text() == 'Reverse') {
        clickedButton.removeClass("btn btn-warning");
        clickedButton.addClass("btn btn-info");
        clickedButton.text('BLOCK');
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
                    // row.append("<td><button class='actionbutton form-control btn btn-info' data-bean-id='"+data[i]["ALERT_ID"]+"'>Action</button></td>");
                    row.append("<td><button class='actionbutton form-control btn btn-info' data-bean-id='"+data[i]["ALERT_ID"]+"'>BLOCKED</button></td>");

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
                    row.append("<td><button class='actionbutton form-control btn btn-warning' data-bean-id='"+data[i]["ALERT_ID"]+"'>BLOCK</button></td>");
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


