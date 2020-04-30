

function clear_Arrays(){
    jsonData = [];
    in_data = [];
    out_data = [];
    x_data = [];
    in_attempt_data = [];
    out_attempt_data = [];
}


function drawChart(){

    $('#container_archive_in').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'In TRUNK Calls'
        },
        xAxis: {
            allowDecimals: false,
            categories: x_data,
            // labels: {
            //     formatter: function () {
            //         return this.value; // clean, unformatted number for year
            //     }
            // }
        },
        yAxis: {
            title: {
                text: 'Calls'
            },
            // labels: {
            //     formatter: function () {
            //         return this.value;
            //     }
            // }
        },
        legend: {
                align: 'left',
                verticalAlign: 'top',
                y: 20,
                floating: true,
                borderWidth: 0
            },
        tooltip: {
            //pointFormat: '{series.name} produced <b>{point.y}</b>'
            shared: true,
            crosshairs: true
        },
        plotOptions: {
            area: {
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            },
            series:{
                point: {
                    events: {
                        click: function (e) {
                            var trunkDisplay = '';
                            $.ajax({
                                url: 'controller/archive_page/get_trunk.php',
                                type: "POST",
                                data: {first: this.first, last: this.last, from: 'IN'},
                                dataType: "json",
                                async: false,
                                success: function(data) {
                                    for(var i = 0; i < data.length; i++){
                                        if(!data[i]["SUCCESS"] == 0 && !data[i]["ATTEMPT"] == 0){
                                            trunkDisplay = trunkDisplay + 'NAME:' + data[i]["NAME"] + ' \tIN:' + data[i]["SUCCESS"] + ' \tIN_ATTEMP:' + data[i]["ATTEMPT"] + '<br/>';
                                        }
                                    }
                                },
                                cache: false
                            });
                            hs.htmlExpand(null, {
                                pageOrigin: {
                                    x: e.pageX || e.clientX,
                                    y: e.pageY || e.clientY
                                },
                                headingText: this.series.name,
                                maincontentText: trunkDisplay,
                                width: 400
                            });
                        }
                    }
                },
                marker:{
                    lineWidth: 1,
                    lineColor: '#FFFFFF'
                }
            }
        },
        series: [{
            name: 'In TRUNK Call Attempts',
            color: '#6FCC22',
            marker:{
                symbol: 'square',
            },
            type: 'spline',
            data: in_attempt_data
        },{
            name: 'Successful In Trunk Calls',
            color: '#7c0d0d',
            data: in_data
        }]
    });

    $('#container_archive_out').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'Out TRUNK Calls'
        },
        xAxis: {
            allowDecimals: false,
            categories: x_data,
            // labels: {
            //     formatter: function () {
            //         return this.value; // clean, unformatted number for year
            //     }
            // }
        },
        yAxis: {
            title: {
                text: 'Traffic'
            },
            // labels: {
            //     formatter: function () {
            //         return this.value;
            //     }
            // }
            showFirstLabel: false
        },
        legend: {
            align: 'left',
            verticalAlign: 'top',
            y: 20,
            floating: true,
            borderWidth: 0
        },
        tooltip: {
            //pointFormat: '{series.name} produced <b>{point.y}</b>',
            shared: true,
            crosshairs: true
        },
        plotOptions: {
            area: {
                marker: {
                    lineWidth: 1,
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            },
            series:{
                cursor: 'pointer',
                point: {
                    events: {
                        click: function (e) {
                            var trunkDisplay = '';
                            $.ajax({
                                url: 'controller/archive_page/get_trunk.php',
                                type: "POST",
                                data: {first: this.first, last: this.last, from: 'OUT'},
                                dataType: "json",
                                async: false,
                                success: function(data) {
                                    for(var i = 0; i < data.length; i++){
                                        if(!data[i]["SUCCESS"] == 0 && !data[i]["ATTEMPT"] == 0){
                                            trunkDisplay = trunkDisplay + 'NAME:' + data[i]["NAME"] + ' OUT:' + data[i]["SUCCESS"] + ' OUT_ATTEMP:' + data[i]["ATTEMPT"] + '<br/>';
                                        }
                                    }
                                },
                                cache: false
                            });
                            hs.htmlExpand(null, {
                                pageOrigin: {
                                    x: e.pageX || e.clientX,
                                    y: e.pageY || e.clientY
                                },
                                headingText: this.series.name,
                                maincontentText: trunkDisplay,
                                width: 400
                            });
                        }
                    }
                },
                marker:{
                    lineWidth: 1,
                    lineColor: '#FFFFFF'
                }
            }
        },
        series: [{
            name: 'Out TRUNK Call Attempts',
            color: '#6FCC22',
            marker:{
                symbol: 'square',
            },
            type: 'spline',
            data: out_attempt_data
        },{
            name: 'Successful Out TRUNK Calls',
            color: '#035c64',
            marker:{
                symbol: 'square',
            },
            data: out_data
        }]
    });
    
    clear_Arrays();
}