function getReport(from, to){
	var from_day = from;
	var to_day = to; 
    //alert("LOL");
    //console.log(from + " | " + to);
    $.ajax({
        url: 'controller/report_page/report_controller.php',
        type: "POST",
        data: {from_date: from_day, to_date: to_day},
        dataType: "json",
        async: false,
        success: function(data) {
            alert("Please Check your Email");
        },
        cache: false
    });
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

	        getReport(fromdate, todate);
	        
        //}
        //else{
        	//alert("You are funny, I like you <3");
        //}
    });
	$("#fromdatepicker1").click(function(event){
        $( "#datetimepicker1" ).trigger( "select" );
    });
    $("#todatepicker1").click(function(event){
        $( "#datetimepicker2" ).trigger( "select" );
    });
});