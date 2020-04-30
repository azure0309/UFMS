<?php require "../req_login.php"; ?>

<!DOCTYPE html>
<html>

    <head>
    <meta charset="utf-8" />    
    <title>International Call Statictics</title>

    <script type="text/javascript" src="javascript/vendor/jquery.js"></script>
    <script src="https://www.highcharts.com/samples/static/highslide-full.min.js"></script>
    <script src="https://www.highcharts.com/samples/static/highslide.config.js" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="https://www.highcharts.com/samples/static/highslide.css" />
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/sprite.css" media="screen,projection"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script type="text/javascript" src="javascript/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/vendor/jquery.datetimepicker.full.js"></script>
    <link type="text/css" rel="stylesheet" href="css/jquery.datetimepicker.css" media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/dt-1.10.10/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://www.datatables.net/release-datatables/extensions/TableTools/css/dataTables.tableTools.css">
    <script type="text/javascript" src="https://cdn.datatables.net/s/dt/dt-1.10.10/datatables.min.js"></script>
    <script type="text/javascript" src="javascript/vendor/tabletools.js"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <script type="text/javascript" src="javascript/statistics_page/auto_complete.js"></script>
        <script type="text/javascript" src="javascript/statistics_page/master.js"></script>
        <nav class="navbar navbar-default navbar-collapse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand"><img id = "logo-unitel" src="images/logo.png"></a>
                </div>
                <div id="navigation-bar">
                    <ul id="active-list" class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">International Call <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Live</li>
                                <li><a href="index.php">International Call Rate & International call Alerts</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">History</li>
                                <li><a href="archive_od_chart.php">International Call Rate</a></li>
                                <li><a href="archive_od_call.php">International call Alerts</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Local Call <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Live</li>
                                <li><a href="sip_index.php">Local Call Rate & Local call Alerts</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">History</li>
                                <li><a href="archive_sip_chart.php">Local Call Rate</a></li>
                                <li><a href="archive_sip_call.php">Local call Alerts</a></li>
                            </ul>
                        </li>
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Call Statistics <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="active"><a href="statistic.php">International Call</a></li>
                                <li><a href="sip_statistic.php">Local Call</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <p>Өдрөөр хайх</p>
                <div class="col-md-6">
                    <div class="input-group input-daterange input-group-md">
                        <a id="fromdatepicker1" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></a>
                        <input id="datetimepicker1" type="text" class="form-control" placeholder="From Date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-daterange input-group-md">
                        <input id="datetimepicker2" type="text" class="form-control" placeholder="To Date">
                        <a id="todatepicker1" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <p>IP хаягаар хайх</p>
                <div class="col-md-6">
                    <input type="text" id="src-ip" class="form-control" placeholder="Source IP"></input>
                    <!-- <select id="src-ip" class="form-control"><option></option></select> -->
                </div>
                <div class="col-md-6">
                    <input type="text" id="dst-ip" class="form-control" placeholder="Destination IP"></input>
                    <!-- <select id="dst-ip" class="form-control"><option></option></select> -->
                </div>
            </div>
            <br>
            <div class="row">
                <p>Дугаараар хайх</p>
                <div class="col-md-6">
                    <input type="text" id="call-from" class="form-control" placeholder="From Number"></input>
                </div>
                <div class="col-md-6">
                    <input type="text" id="call-to" class="form-control" placeholder="To Number"></input>
                </div>
            </div>
            <br/>
            <div class="row">
                <p>Нэмэлт боломжууд</p>
                <div class="col-md-4">
                    <label class="checkbox-inline"><input id="ring" type="checkbox" value="1">Ring</label>
                    <label class="checkbox-inline"><input id="answer" type="checkbox" value="2">Answer</label>
                    <label class="checkbox-inline"><input id="bye" type="checkbox" value="3">Bye</label>
                </div>
                <div class="col-md-4">
                    <input id="min-dur" placeholder="Min Duration" class="form-control"></input>
                </div>
                <div class="col-md-4">
                    <input id="max-dur" placeholder="Max Duration" class="form-control"></input>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="container">
                    <button id="masterbutton" class="btn btn-sample form-control"><span class="glyphicon glyphicon-search"></span> Search</button>
                </div>
            </div>
            <br>
            <div class="row" hidden>
                <div class="col-md-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row hidden" id="table-data">
                <!--<div class="col-md-12">-->
                    <table id="myTable" class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr class="first-row">
                                <th style="display:none;">SIP_PACKET_ID</th>
                                <th style="display:none;">CALL_ID</th>
                                <th>Source IP</th>
                                <th>Destination IP</th>
                                <th>Call From</th>
                                <th>Call To</th>
                                <th>Ring</th>
                                <th>Answer</th>
                                <th>Bye</th>
                                <th>Invite Time</th>
                                <th>Answer Time</th>
                                <th>Bye Time</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                <!--</div>-->
            </div>
            <div class="row" id="response"></div>
        </div>
    </body>
</html>