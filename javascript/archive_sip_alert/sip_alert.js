var geoNames = [];
var argArray = ["ARG1", "ARG2", "ARG3", "ARG4"];
var ipArray = ["empty", "empty", "empty", "empty"];
var countryNameArray = ["empty", "empty", "empty", "empty"];
var countryCodeArray = ["empty", "empty", "empty", "empty"];


$(document).on('click','.actionbutton', function(){
    var beanId = $(this).data('beanId');
    var clickedButton = $(this);
    $('#table-body > tr').each(function(){
        if($(this).find('td:eq(0)').text() == beanId){
            // alert("Equals");
            if(clickedButton.text() == 'Action'){
                console.log("I am not sorry for you");
                if($(this).find("td:eq(2)").text() == 2){
                    $(this).removeClass("warning-fraud");
                    $(this).addClass("not-fraud");
                    $.ajax({
                        url: 'controller/archive_sip_alert_page/status_changer.php',
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
                else if($(this).find("td:eq(2)").text() == 3){
                    $(this).removeClass("danger-fraud");
                    $(this).addClass("danger-cleared-fraud");
                    $.ajax({
                        url: 'controller/archive_sip_alert_page/status_changer.php',
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
                if($(this).find("td:eq(2)").text() == 2){
                    $(this).removeClass("not-fraud");
                    $(this).addClass("warning-fraud");
                    $.ajax({
                        url: 'controller/archive_sip_alert_page/status_changer.php',
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
                else if($(this).find("td:eq(2)").text() == 3){
                    $(this).removeClass("danger-cleared-fraud");
                    $(this).addClass("danger-fraud");
                    $.ajax({
                        url: 'controller/archive_sip_alert_page/status_changer.php',
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
    if(clickedButton.text() == 'Action'){
        clickedButton.removeClass("btn btn-info");
        clickedButton.addClass("btn btn-warning");
        clickedButton.text('Reverse');
    }
    else if(clickedButton.text() == 'Reverse'){
        clickedButton.removeClass("btn btn-warning");
        clickedButton.addClass("btn btn-info");
        clickedButton.text('Action');
    }
});
function clearTable(){
	$("#myTable").DataTable().destroy();
    $('#table-body tr').remove();
    if($('#table-data').hasClass("hidden") === false){
    	$("#table-data").addClass("hidden");
    }
}

function getCountryName(ipaddress){
    ipaddress = ipaddress.replace(/ /g,'');
    var cc = ''; 
    var cn = '';
    var splitAddress = ipaddress.split(".");
    var ipNumber = Number(splitAddress[0])*16777216 + Number(splitAddress[1])*65536 + Number(splitAddress[2])*256 + Number(splitAddress[3]);
    for(var i = 0; i<geoNames.length; i++){
        if(geoNames[i]["begin_ip_num"] <= ipNumber && geoNames[i]["end_ip_num"] >= ipNumber){
            cn = geoNames[i]["country_name"];
            cc = geoNames[i]["country_code"];
        }
    }
    if(!cn || !cc){
        return ["Not Found", "NF"];
    }else{
        return [cn, cc];
    }
}

function ValidateIPaddress(ipaddress)   
{  
    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress)){  
        return true;
    }else{
        return false;
    }
}

function getGeoNames(){
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
}


$(document).ready(function(event){
	getGeoNames();

    // $(document).on("click", "#table-body tr", function(e) {
    //     // alert($(this).find("td:eq(0)").text());
    //     if($(this).find("td:eq(2)").text() == 2){
    //         // alert("LEVEL 2");
    //         $(this).removeClass("warning-fraud");
    //         $(this).addClass("not-fraud");
    //         $.ajax({
    //             url: 'controller/archive_sip_alert_page/status_changer.php',
    //             type: "POST",
    //             data: {id:$(this).find("td:eq(0)").text()},
    //             dataType: "json",
    //             async: false,
    //             success: function(data) {
    //                 alert("changed");
    //             },
    //             cache: false
    //         }); 
    //     }
    //     else if($(this).find("td:eq(2)").text() == 3){
    //         // alert("LEVEL 3");
    //         $(this).removeClass("danger-fraud");
    //         $(this).addClass("danger-cleared-fraud");
    //         $.ajax({
    //             url: 'controller/archive_sip_alert_page/status_changer.php',
    //             type: "POST",
    //             data: {id:$(this).find("td:eq(0)").text()},
    //             dataType: "json",
    //             async: false,
    //             success: function(data) {
    //                 alert("changed");
    //             },
    //             cache: false
    //         }); 
    //     } 
    // });

	var datetimepicker1 = $("#datetimepicker1");
	var datetimepicker2 = $("#datetimepicker2");
	var type = $("#type-controller");
	

	function searchAlert(){

		clearTable();
		var data = [];
		data = {from_date:datetimepicker1.val(), to_date:datetimepicker2.val(), type:type.val()};
		JSON.stringify(data);

		$.ajax({
			type: 'POST',
			url: 'controller/archive_sip_alert_page/master_post.php',
			dataType: 'json',
			data: data,
			success: function(data){
				// alert(data);
				for (var i = 0; i < data.length; i++) {
					for(var j = 0; j< argArray.length; j++){
                        if(ValidateIPaddress(data[i][argArray[j]])){
                            var country = getCountryName(data[i][argArray[j]]);
                            ipArray[j] = argArray[j];
                            countryNameArray[j] = country[0];
                            countryCodeArray[j] = country[1];
                        }
                    }
                    if(data[i]["STATUS"] == 0){
                        if(data[i]["LVL"] == 2){
                            var row = $("<tr class='warning-fraud' />")
                        }
                        else if(data[i]["LVL"] == 3){
                            var row = $("<tr class='danger-fraud' />")
                        }
                        row.append("<td style='display:none;'>" + data[i]["ALERT_ID"] + "</td>");
                        row.append("<td>" + data[i]["TYPE"] + "</td>");
                        row.append("<td>" + data[i]["LVL"] + "</td>");
                        for(var p = 0; p < argArray.length; p++){
                            if(ipArray[p] == "empty"){
                                if(data[i][argArray[p]] === null){
                                    row.append("<td>---||---</td>");    
                                }else{
                                    row.append("<td>\"" + data[i][argArray[p]] + "\"</td>");
                                }
                            }else{
                                row.append("<td><a title='" + countryNameArray[p] + "'><div class='flag flag-" + countryCodeArray[p] + "'></div></a> " + data[i][argArray[p]] + "</td>");
                            }
                        }
                        if(data[i]["CONTENT"] === null){
                            row.append("<td>---||---</td>");
                        }else{
                            row.append("<td>" + data[i]["CONTENT"] + "</td>");
                        }
                        row.append("<td>" + data[i]["CREATED"] + "</td>");
                         row.append("<td><button class='actionbutton form-control btn btn-info' data-bean-id='"+data[i]["ALERT_ID"]+"'>Action</button></td>");
                        $("#table-body").append(row);
                        // audio.play();
                    }else{
                        if(data[i]["LVL"] == 2){
                            var row = $("<tr class='not-fraud' />")
                        }else if(data[i]["LVL"] == 3){
                            var row = $("<tr class='danger-cleared-fraud' />")
                            // alert("LVL 3");
                        }
                        row.append("<td style='display:none;'>" + data[i]["ALERT_ID"] + "</td>");
                        row.append("<td>" + data[i]["TYPE"] + "</td>");
                        row.append("<td>" + data[i]["LVL"] + "</td>");
                        for(var p = 0; p < argArray.length; p++){
                            if(ipArray[p] == "empty"){
                                if(data[i][argArray[p]] === null){
                                    row.append("<td>---||---</td>");    
                                }else{
                                    row.append("<td>\"" + data[i][argArray[p]] + "\"</td>");
                                }
                            }else{
                                row.append("<td><a title='" + countryNameArray[p] + "'><div class='flag flag-" + countryCodeArray[p] + "'></div></a> " + data[i][argArray[p]] + "</td>");
                            }
                        }
                        if(data[i]["CONTENT"] === null){
                            row.append("<td>---||---</td>");
                        }else{
                            row.append("<td>" + data[i]["CONTENT"] + "</td>");
                        }
                        row.append("<td>" + data[i]["CREATED"] + "</td>");
                        row.append("<td><button class='actionbutton form-control btn btn-warning' data-bean-id='"+data[i]["ALERT_ID"]+"'>Reverse</button></td>");
                        $("#table-body").append(row);
                    }
                    ipArray = ["empty", "empty", "empty", "empty"];
                    countryNameArray = ["empty", "empty", "empty", "empty"];
                    countryCodeArray = ["empty", "empty", "empty", "empty"];
	            }
	            // console.log($("#table-body"));

	            var table = $("#myTable").DataTable({
                    "order": [[ 8, "desc" ]],
                    "ordering": false,
	            	dom: 'T<"clear">lfrtip',
	            	retrieve: true,
	            	tableTools: {
			            "sSwfPath": "../swf/copy_csv_xls_pdf.swf",
                        "aButtons": [{
                            "sExtends": "csv",
                            "bBomInc": true,
                            "sCharSet": "utf8"
                        }]
			        }
	            });
	            $("#table-data").removeClass("hidden");
			}
		});

	}


	$("#search").click(function(event){
		searchAlert();
	});
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	       searchAlert();
	    }
	});
});