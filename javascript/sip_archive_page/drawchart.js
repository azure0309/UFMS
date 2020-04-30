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
            text: 'In Calls'
        },
        xAxis: {
            allowDecimals: false,
            categories: x_data,
            labels: {
                formatter: function () {
                    return this.value; // clean, unformatted number for year
                }
            }
        },
        yAxis: {
            title: {
                text: 'Calls'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
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
                marker:{
                    lineWidth: 1,
                    lineColor: '#FFFFFF'
                }
            }
        },
        series: [{
            name: 'IN Call Attempts',
            color: '#6FCC22',
            marker:{
                symbol: 'square',
            },
            type: 'spline',
            data: in_attempt_data
        },{
            name: 'Successful IN Calls',
            color: '#7c0d0d',
            data: in_data
        }]
    });

    $('#container_archive_out').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'Out Calls'
        },
        xAxis: {
            allowDecimals: false,
            categories: x_data,
            labels: {
                formatter: function () {
                    return this.value; // clean, unformatted number for year
                }
            }
        },
        yAxis: {
            title: {
                text: 'Calls'
            },
            labels: {
                formatter: function () {
                    return this.value;
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
                marker:{
                    lineWidth: 1,
                    lineColor: '#FFFFFF'
                }
            }
        },
        series: [{
            name: 'Out Call Attempts',
            color: '#6FCC22',
            marker:{
                symbol: 'square',
            },
            type: 'spline',
            data: out_attempt_data
        },{
            name: 'Successful Out Calls',
            color: '#035c64',
            marker:{
                symbol: 'square',
            },
            data: out_data
        }]
    });
    
    clear_Arrays();
}