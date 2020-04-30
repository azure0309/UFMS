var globali = 0;
var global_last = 0;
var global_last_in = 0;
var global_data_length = 0;
var time_limit = 300000;
var nice_string = "";
var counter = 0;
var x_date = "";
var data_out = [];
var data_out_attempt = [];
var data_in = [];
var data_in_attempt = [];
var counter2 = 0;
var category_data = [];


function two_out_one(){
    var jsonData = [];
    counter = 0;

    $.ajax({
        url: 'controller/sip_index_page/dummyChart.php',
        type: "GET",
        dataType: "json",
        async: false,
        success: function(data) {
            global_data_length = data.length;
            if(global_data_length == 0){
                //do Nothing
            }
            else{
                for(var i = 0; i<global_data_length; i++){
                    jsonData.push(data[i]);
                    // console.log(data[i]["TRUNK_OUT"])
                }
                global_last = jsonData[data.length-1]["TRUNK_ID"];
                console.log(global_last);
            }
        },
        cache: false
    });
    var data = [],
    time = (new Date()).getTime(),
    i;
    if(global_data_length < 24){
        for (i = -24; i < (0 - global_data_length); i += 1) {
        // console.log("123123123");
            data_out_attempt.push({
                // x: time + i * time_limit,
                y: null
            });
            data_out.push({
                // x: time + i * time_limit,
                y: null
            });
            category_data.push(
                null
            );
        }
        for (i = (0 - global_data_length); i < 0; i += 1) {
            console.log("MOVE MF!");
            data_out_attempt.push({
                // x: time + i * time_limit,
                y: Number(jsonData[i+global_data_length]["TRUNK_OUT_ATTEMPT"])
            });
            data_out.push({
                // x: time + i * time_limit,
                y: Number(jsonData[i+global_data_length]["TRUNK_OUT"])
            });
            category_data.push(
                String(jsonData[i+global_data_length]["TRUNK_DATE"])
            );
        }
    }
    else{    
        for (i = -24; i < 0; i += 1) {
            data_out_attempt.push({
                // x: time + i * time_limit, //jsonData[i+30]["TRUNK_TIME"],
                y: Number(jsonData[i+24]["TRUNK_OUT_ATTEMPT"])
            });
            data_out.push({
                // x: time + i * time_limit, //jsonData[i+30]["TRUNK_TIME"],
                y: Number(jsonData[i+24]["TRUNK_OUT"])
            });
            category_data.push(
                String(jsonData[i+24]["TRUNK_DATE"])
            );
        }
    }
}

function requestDataOut(){
    var y = 0;
    var series = this.series[0];
    var series2 = this.series[1];

    setInterval(function () {
        $.ajax({
            url: 'controller/sip_index_page/out_updater.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                // console.log(data);
                if(data.length == 0){
                    //do Nothing
                    // console.log("NOTHING");
                    // console.log(series);
                }
                else{
                    if(data[data.length - 1]["TRUNK_ID"] > global_last){
                        //console.log("OUT:");
                        //console.log(data);
                        counter = 0;
                        counter2 = 0;
                        // for(var i = 0; i < data.length; i++){
                        //     if(data[i]["TRUNK_ID"] = global_last){
                        //         counter = data[i]["TRUNK_OUT"];
                        //         global_last = data[i]["TRUNK_ID"];
                        //         counter2 = data[i]["TRUNK_OUT_ATTEMPT"];
                        //     }
                        // }
                        counter = data[data.length - 1]["TRUNK_OUT"];
                        global_last = data[data.length - 1]["TRUNK_ID"];
                        counter2 = data[data.length - 1]["TRUNK_OUT_ATTEMPT"];

                        
                        // var x = (new Date()).getTime(); // current time
                        var x = String(data[data.length - 1]["TRUNK_DATE"]);
                        var m = global_last;
                        y = Number(counter);
                        //console.log("OUT Y:"+y+" | OUT X:"+x+" | ID:"+global_last);
                        series.addPoint([x,y], true, true);
                        y = Number(counter2);
                        series2.addPoint([x,y], true,true);
                    }
                }
            },
            cache: false
        });
        
    }, 5000);
}

$(function () {
    $(document).ready(function () {
        two_out_one();
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });

        $('#container_out').highcharts({
            chart: {
                type: 'area',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: requestDataOut,
                    }
                }
            ,
            title: {
                text: 'Out Calls'
            },
            xAxis: {
                // type: 'datetime',
                // tickPixelInterval: 100
                categories: category_data,
                allowDecimals: false
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Calls'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#66CC00'
                }]
            },
            plotOptions: {
                series:{
                    marker:{
                        lineWidth: 1,
                        lineColor: '#FFFFFF'
                    }
                }
            },
            legend: {
                align: 'left',
                verticalAlign: 'top',
                y: 20,
                floating: true,
                borderWidth: 0
            },
            tooltip: {
                //shared: true,
                // formatter: function () {
                //     return 'Out TRUNK Traffic:'+this.point.y;
                // }
                shared: true,
                crosshairs: true,
                
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Successful Out Calls',
                color: '#035c64',
                marker:{
                    symbol: 'square',
                },
                data: data_out
            },{
                name: 'Out Call Attempts',
                color: '#6FCC22',
                marker:{
                    symbol: 'square',
                },
                type: 'line',
                data : data_out_attempt
            }]
        });
/////////////////////////////////////////////////////////////////////////////////////////////////
    });
});

