var globali_in = 0;
var global_data_length_in = 0;
//var time_limit = 240000;
var nice_string = "";
var counter_in = 0;
var counter2_in = 0;
var x_date = "";
var y_in = 0;
var time_limit = 300000;
var time;
var category_data_in = [];

function two_in_one(){
    var jsonData = [];
    counter = 0;

    $.ajax({
        url: 'controller/index_page/dummyChart.php',
        type: "GET",
        dataType: "json",
        async: false,
        success: function(data) {
            global_data_length_in = data.length;
            if(global_data_length_in == 0){
                //do Nothing
            }
            else{
                for(var i = 0; i<global_data_length_in; i++){
                    jsonData.push(data[i]);
                    // console.log(data[i]["TRUNK_OUT"])
                }
                global_last_in = jsonData[data.length-1]["TRUNK_ID"];
                console.log(global_last_in);
            }
        },
        cache: false
    });
    var data = [],
    time = (new Date()).getTime(),
    i;
    if(global_data_length_in < 24){
        for (i = -24; i < (0 - global_data_length_in); i += 1) {
            data_in_attempt.push({
                // x: time + i * time_limit,
                y: null
            });
            data_in.push({
                // x: time + i * time_limit,
                y: null
            });
            category_data_in.push(
                null
            );
        }
        for (i = (0 - global_data_length_in); i < 0; i += 1) {
            console.log("MOVE MF!");
            data_in_attempt.push({
                // x: time + i * time_limit,
                y: Number(jsonData[i+global_data_length_in]["TRUNK_IN_ATTEMPT"])
            });
            data_in.push({
                // x: time + i * time_limit,
                y: Number(jsonData[i+global_data_length_in]["TRUNK_IN"])
            });
            category_data_in.push(
                String(jsonData[i+global_data_length_in]["TRUNK_DATE"])
            );
        }
    }
    else{    
        for (i = -24; i < 0; i += 1) {
            data_in_attempt.push({
                // x: time + i * time_limit, //jsonData[i+30]["TRUNK_TIME"],
                y: Number(jsonData[i+24]["TRUNK_IN_ATTEMPT"])
            });
            data_in.push({
                // x: time + i * time_limit, //jsonData[i+30]["TRUNK_TIME"],
                y: Number(jsonData[i+24]["TRUNK_IN"])
            });
            category_data_in.push(
                String(jsonData[i+24]["TRUNK_DATE"])
            );
        }
    }
}

function requestDataIn(){
    
    var series = this.series[0];
    var series2 = this.series[1];
    setInterval(function () {
        $.ajax({
            url: 'controller/index_page/in_updater.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                if(data.length == 0){
                    //do Nothing
                }
                else{
                    if(data[data.length - 1]["TRUNK_ID"] > global_last_in){
                        counter_in = 0;
                        counter2_in = 0;

                        counter_in = data[data.length - 1]["TRUNK_IN"];
                        global_last_in = data[data.length - 1]["TRUNK_ID"];
                        counter2_in = data[data.length - 1]["TRUNK_IN_ATTEMPT"];

                        
                        // var x = (new Date()).getTime(); // current time
                        var x = data[data.length - 1]["TRUNK_DATE"];
                        var m = global_last_in;
                        y_in = Number(counter_in);

                        series.addPoint([x,y_in], true, true);
                        y_in = Number(counter2_in);
                        series2.addPoint([x,y_in], true,true);
                    }
                }
            },
            cache: false
        });
        
    }, 5000);
}

$(function () {
    $(document).ready(function () {
        two_in_one();
        $('#container_in').highcharts({
            chart: {
                type: 'area',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: requestDataIn,
                    }
                }
            ,
            title: {
                text: 'In TRUNK Traffic'
            },
            xAxis: {
                // type: 'datetime',
                // tickPixelInterval: 1,
                categories: category_data_in,
                allowDecimals: false
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Traffic'
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
            // legend: {
            //     enabled: false
            // },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Successful In TRUNK Calls',
                color: '#7c0d0d',
                data: data_in
            },{
                name: 'In TRUNK Call Attempts',
                color: '#6FCC22',
                marker:{
                    symbol: 'square',
                },
                type: 'line',
                data : data_in_attempt
            }]
        });
    });
});

