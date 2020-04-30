var to = "to";
var from = "from";
var source = "src";
var destination = "dst";
var call = "call";
var ip_addr = "ip_addr";
var autoComplete_data = [];

$(document).ready(function(){

	var thisYear = new Date();
    thisYear.setYear(thisYear.getFullYear() - 1);
	$.datetimepicker.setLocale('en');

    $('#datetimepicker1').datetimepicker({
    	maxDate: new Date(),
        minDate: thisYear,
        format:'m-d-Y H:i'
    });
    $('#datetimepicker2').datetimepicker({
    	maxDate: new Date(),
        minDate: thisYear,
        format:'m-d-Y H:i'
    });
    $("#fromdatepicker1").click(function(event){
		$( "#datetimepicker1" ).trigger( "select" );
	});
	$("#todatepicker1").click(function(event){
		$( "#datetimepicker2" ).trigger( "select" );
	});
    
	//Autocomplete POST Request
	// $.post('controller/statistics_page/autoComplete.php', {from:source, iorc:ip_addr}, function(data,status){
	// 	if(status == "success"){
	// 		var jData = JSON.parse(data);
	// 		for(var i=0; i<jData.length; i++){
	// 			var row = $("<option></option>")
	// 			row.append("<option>" + jData[i]["SRC"] + "</option>");
	// 			$("#src-ip").append(row);
	// 		}
	// 	}
	// });
	// $.post('controller/statistics_page/autoComplete.php', {from:destination, iorc:ip_addr}, function(data,status){
	// 	if(status == "success"){
	// 		var jData = JSON.parse(data);
	// 		for(var i=0; i<jData.length; i++){
	// 			var row = $("<option></option>")
	// 			row.append("<option>" + jData[i]["DST"] + "</option>");
	// 			$("#dst-ip").append(row);
	// 		}
	// 	}
	// });

	// //END

	// $("#src-ip").select2({
	// 	placeholder:"Source IP",
	// 	allowClear: true
	// });
	// $("#dst-ip").select2({
	// 	placeholder:"Destination IP",
	// 	allowClear: true
	// });

});