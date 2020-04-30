var datetime1 = "";
var datetime2 = "";
var splitter = "";
var spacesplitter = "";
var splitter1 = "";
var spacesplitter1 = "";
var timesplitter = "";
var timesplitter1 = "";

var fromdate = new Date();
var todate = new Date();

var jsonData = [];
var i;
var in_data = [];
var out_data = [];
var x_data = [];
var in_attempt_data = [];
var out_attempt_data = [];

var minutes = "";
var hours = "";
var dates = "";
var months = "";
var years = "";

function testAlert(from, to){
	var from_day = from;
	var to_day = to; 
    // alert(from_day);
    // alert(to_day);
    //console.log(from + " | " + to);
    $.ajax({
        url: 'controller/sip_archive_page/test_post.php',
        type: "POST",
        data: {from_date: from_day, to_date: to_day},
        dataType: "json",
        async: false,
        success: function(data) {
            if(data.length == 0){
                //do Nothing
                // alert("Nothing");
            }
            else{
                // alert("have some DATA");
                for(var i = 0; i<data.length; i++){
                    jsonData.push(data[i]);
                }
            }
        },
        cache: false
    });
    for (i = 0; i < jsonData.length; i += 1) {
        in_data.push(
            Number(jsonData[i]["TRUNK_IN"])
        );
        out_data.push(
            Number(jsonData[i]["TRUNK_OUT"])
        );
        in_attempt_data.push(
            Number(jsonData[i]["TRUNK_IN_ATTEMPT"])
        );
        out_attempt_data.push(
            Number(jsonData[i]["TRUNK_OUT_ATTEMPT"])
        );
        x_data.push(
            String(jsonData[i]["TRUNK_DATE"])
        );
    }
}

function formatDate(value)
{
	
	minutes = value.getMinutes();
	hours = value.getHours();
	dates = value.getDate();
	months = value.getMonth() + 1;
	years = value.getFullYear();

	if(minutes.length < 2){ minutes = '0' + minutes }
	if(hours.length < 2){ hours = '0' + hours}
	if(dates.length < 2){ dates = '0' + dates}
	if(months.length < 2){ months = '0' + months }	
    
	return months + "-" + dates + "-" + years + " " + hours + ":" + minutes;
}

$(document).ready(function(){

    var thisYear = new Date();
    thisYear.setYear(thisYear.getFullYear() - 1);

    $.datetimepicker.setLocale('en');

    $('#datetimepicker1').datetimepicker({
    	maxDate: new Date(),
    	//maxTime: new Date(),
        minDate: thisYear
    });
    $('#datetimepicker2').datetimepicker({
    	maxDate: new Date(),
        minDate: thisYear
    	//maxTime: new Date()
    });
    $("#fromdatepicker1").click(function(event){
        $( "#datetimepicker1" ).trigger( "select" );
    });
    $("#todatepicker1").click(function(event){
        $( "#datetimepicker2" ).trigger( "select" );
    });
    
    $("#not-static").click(function(event){

        datetime1 = $('#datetimepicker1');
        datetime2 = $('#datetimepicker2');

        splitter = (datetime1.val()).split("/", 3);
        spacesplitter = splitter[2].split(" ");
        timesplitter = spacesplitter[1].split(":");
        splitter1 = (datetime2.val()).split("/", 3);
        spacesplitter1 = splitter1[2].split(" ");
        timesplitter1 = spacesplitter1[1].split(":");

        //if(splitter[0] <= splitter1[0] && splitter[1] <= splitter1[1] && spacesplitter[0] <= spacesplitter1[0] && timesplitter[0] <= timesplitter1[0] && timesplitter[1] <= timesplitter1[1]){
        	fromdate = splitter[1] + "-" + spacesplitter[0] + "-" + splitter[0] + " " + spacesplitter[1];
	        todate = splitter1[1] + "-" + spacesplitter1[0] + "-" + splitter1[0] + " " + spacesplitter1[1];

	        testAlert(fromdate, todate);
            drawChart();
        //}
        //else{
        	//alert("You are funny, I like you <3");
        //}
    });

    $('#graph-controller').change(function(event){
    	var currentdate = new Date(); 

    	todate = formatDate(currentdate);
		

    	if($(this).val() == 1){
    		fromdate = new Date();

    		fromdate.setDate(currentdate.getDate() - 1);
    		fromdate = formatDate(fromdate);

    		testAlert(fromdate, todate);
            // drawChart();
    	}
    	else if($(this).val() == 2){
    		fromdate = new Date();

    		fromdate.setDate(currentdate.getDate() - 7);
    		fromdate = formatDate(fromdate);

    		testAlert(fromdate, todate);
            // drawChart();
    	}
    	else if($(this).val() == 3){
    		fromdate = new Date();

    		fromdate.setDate(currentdate.getDate() - 30);
    		fromdate = formatDate(fromdate);

    		testAlert(fromdate, todate);
            // drawChart();
    	}
    	else if($(this).val() == 4){
    		fromdate = new Date();
    		
    		fromdate.setDate(currentdate.getDate() - 90);
    		fromdate = formatDate(fromdate);

    		testAlert(fromdate, todate);
            // drawChart();
    	}
    	else if($(this).val() == 5){
    		fromdate = new Date();
    		
    		fromdate.setDate(currentdate.getDate() - 365)
    		fromdate = formatDate(fromdate);

    		testAlert(fromdate, todate);
            
    	}
    	else{
    		// alert("THIS IS A JOKE SRSLY");
    	}
        drawChart();

    });


});