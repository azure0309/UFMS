var geoNames = [];
var trunkNames = [];
function clearTable(){
	$("#myTable").DataTable().destroy();
    $('#table-body tr').remove();
    if($('#table-data').hasClass("hidden") === false){
    	$("#table-data").addClass("hidden");
    }
}

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
    var splitAddress = ipaddress.split(".");
    var ipNumber = Number(splitAddress[0])*16777216 + Number(splitAddress[1])*65536 + Number(splitAddress[2])*256 + Number(splitAddress[3]);
    for(var i = 0; i<geoNames.length; i++){
        if(geoNames[i]["begin_ip_num"] <= ipNumber && geoNames[i]["end_ip_num"] >= ipNumber){
            // console.log(geoNames[i].country_code);
            return geoNames[i].country_code;
        }
    }
}
function getTrunk(ipaddress){
    for(var i = 0; i<trunkNames.length; i++){
        if(trunkNames[i].ip == ipaddress){
        	// console.log(trunkNames[i].name);
            return trunkNames[i].name;
        }
    }
}

$(document).ready(function(){
	getTrunkNames();

	var datetimepicker1 = $("#datetimepicker1");
	var datetimepicker2 = $("#datetimepicker2");
	var src_ip = $("#src-ip");
	var dst_ip = $("#dst-ip");
	var call_from = $("#call-from");
	var call_to = $("#call-to");
	var ring = $("#ring");
	var answer = $("#answer");
	var bye = $("#bye");
	var min_dur = $("#min-dur");
	var max_dur = $("#max-dur");

	function masterSearch(){
		clearTable();
		var data = [];
		var ring_null = "";
		var answer_null = "";
		var bye_null = "";
		if(ring.is(':checked') !== true){ring_null = "(RING IS NULL OR RING IS NOT NULL)";}
		else{ring_null = "RING IS NOT NULL";}
		if(answer.is(':checked') !== true){answer_null = "(ANSWER IS NULL OR ANSWER IS NOT NULL)";}
		else{answer_null = "ANSWER IS NOT NULL";}
		if(bye.is(':checked') !== true){bye_null = "(BYE IS NULL OR BYE IS NOT NULL)";}
		else{bye_null = "BYE IS NOT NULL";}
		data = {from_date:datetimepicker1.val(), to_date:datetimepicker2.val(), src_ip:src_ip.val(), 
				dst_ip:dst_ip.val(), call_from:call_from.val(), call_to:call_to.val(), ring:ring_null,
				answer:answer_null, bye:bye_null, min_dur:min_dur.val(), max_dur:max_dur.val()};
		JSON.stringify(data);
		//console.log(data);
		$.ajax({
			type: 'POST',
			url: 'controller/statistics_page/master_post.php',
			dataType: 'json',
			data: data,
			success: function(data){
				for (var i = 0; i < data.length; i++) {
	                var row = $("<tr class='not-fraud' />")
	                row.append("<td style='display:none;'>" + data[i]["CALL_ID_SIP"] + "</td>");
	                row.append("<td style='display:none;'>" + data[i]["CALL_ID"] + "</td>");
	                row.append("<td><a title='" + getTrunk(data[i]["SRC"]) + "'><div class='flag flag-" + getCountryCode(data[i]["SRC"]) + "'></div></a> " + data[i]["SRC"] + "</td>");
	                row.append("<td><a title='" + getTrunk(data[i]["DST"]) + "'><div class='flag flag-" + getCountryCode(data[i]["DST"]) + "'></div></a> " + data[i]["DST"] + "</td>");
	                row.append("<td>\"" + String(data[i]["CALLFROM"]) + "\"</td>");
	                row.append("<td>\"" + String(data[i]["CALLTO"]) + "\"</td>");
	                row.append("<td>" + data[i]["RING"] + "</td>");
	                row.append("<td>" + data[i]["ANSWER"] + "</td>");
	                row.append("<td>" + data[i]["BYE"] + "</td>");
	                row.append("<td>" + data[i]["INVITETIME"] + "</td>");
	                row.append("<td>" + data[i]["ANSWERTIME"] + "</td>");
	                row.append("<td>" + data[i]["BYETIME"] + "</td>");
	                row.append("<td>" + data[i]["DURATION"] + "</td>");
	                row.append("<td>" + data[i]["STATUS"] + "</td>");
	                $("#table-body").append(row);
	            }

	            var table = $("#myTable").DataTable({
	            	tableTools: {
			            "sSwfPath": "./swf/copy_csv_xls_pdf.swf",
			            "aButtons": [{
		                    "sExtends": "csv",
		                    "bBomInc": true,
		                    "sCharSet": "utf8"
		                }]
			        },
			        "order": [[ 1, "desc" ]],
                    "ordering": false,
			        bProcessing: true,
			        bBomInc:true,
	            	dom: 'T<"clear">lfrtipB',
	            	retrieve: true
	            });
	            $("#table-data").removeClass("hidden");
			}
		});
	}


	$("#masterbutton").click(function(event){
		masterSearch();
	});
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	       masterSearch();
	    }
	});

});

