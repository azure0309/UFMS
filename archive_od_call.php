<?php require "../req_login.php"; ?>

<!DOCTYPE html>
<html>

    <head>
    <title>International Alert Archive</title>
    <meta charset="utf-8" />
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
    <link rel="stylesheet" type="text/css" href="css/datatable.css"/>
    <link rel="stylesheet" type="text/css" href="https://www.datatables.net/release-datatables/extensions/TableTools/css/dataTables.tableTools.css">
    <script type="text/javascript" src="https://cdn.datatables.net/s/dt/dt-1.10.10/datatables.min.js"></script>
    <script type="text/javascript" src="javascript/vendor/tabletools.js"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <script type="text/javascript" src="javascript/archive_od_alert/od_alert.js"></script>
        <script type="text/javascript" src="javascript/archive_od_alert/auto_complete.js"></script>
        <nav class="navbar navbar-default navbar-collapse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand"><img id = "logo-unitel" src="images/logo.png"></a>
                </div>
                <div id="navigation-bar">
                    <ul id="active-list" class="nav navbar-nav">
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">International Call <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Live</li>
                                <li><a href="index.php">International Call Rate & International call Alerts</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">History</li>
                                <li><a href="archive_od_chart.php">International Call Rate</a></li>
                                <li class="active"><a href="archive_od_call.php">International call Alerts</a></li>
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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Call Statistics <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="statistic.php">International Call</a></li>
                                <li><a href="sip_statistic.php">Local Call</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#myModal">Help</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- START MODAL -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">International Alert</h4>
                    </div>
                    <div class="modal-body">
                        <!-- <p>Some text in the modal.</p> -->
                        <table class="table table-condensed table-bordered table-hover">
                            <thead class="first-row">
                                <th>Alert Name</th>
                                <th>Description</th>
                                <th>Contact</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>OD_OUT Error number FORMAT</td>
                                    <td>008, +008, 1668 – с өөр гарцаар гарвал</td>
                                    <td>Core сүлжээ жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>OD_OUT Error number COUNTRY CODE</td>
                                    <td>Гарцын дугаар зөв байгаад улсын дугаар буруу байвал</td>
                                    <td>Олон улсын жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>OD_IN Error number LENGTH</td>
                                    <td>Дугаарын урт 12, 15, 16 – с их байвал</td>
                                    <td>МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                                <tr>
                                    <td>OD_IN Error number FORMAT</td>
                                    <td>Монголд байж болохгүй дугаарлуу залгасан байвал</td>
                                    <td>Олон улсын жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>OD_OUT New unregistered TRUNK</td>
                                    <td>Бүртгэлгүй "TRUNK" - р дуудлага гарсан байвал</td>
                                    <td>Core сүлжээ жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>OD_IN New unregistered TRUNK</td>
                                    <td>Бүртгэлгүй "TRUNK" - р дуудлага орсон байвал</td>
                                    <td>Core сүлжээ жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>OD_OUT CALL WITH 1 HOUR DURATION</td>
                                    <td>Нэг цагаас илүү үргэлжилж байгаа яриа байвал</td>
                                    <td>Core сүлжээ жижүүр инженер/МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                                <tr>
                                    <td>OD_OUT Call to HOT DESTINATION</td>
                                    <td>Сүүлийн нэг цагт өндөр өртөгтэй улс руу 5 - с дээш дуудлага гарсан байвал</td>
                                    <td>Core сүлжээ жижүүр инженер/МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                                <tr>
                                    <td>OD_OUT MANY TO ONE</td>
                                    <td>Сүүлийн 1 цагт 1 дугаарлуу 100 - с их амжилттай дуудлага эсвэл 1 дугаарлуу 10 өөр хэрэглэгчээс амжилттай дуудлага гарсан бол</td>
                                    <td>МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                                <tr>
                                    <td>OD_IN ONE TO MANY</td>
                                    <td>Сүүлийн 1 цагт 1 дугаарлуу 30 - с их өөр хэрэглэгчдээс амжилттай дуулага эсвэл 1 дугаарлуу 200 - с их амжилттай дуудлага орж ирсэн бол</td>
                                    <td>МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                                <tr>
                                    <td>OD 6000 CALL ATTEMPT</td>
                                    <td>Сүүлийн 1 цагт 6000 дуудлага хийх оролдлого бүртгэгдсэн байвал</td>
                                    <td>МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                                <tr>
                                    <td>OD 2200 SUCCESSFUL CALLS</td>
                                    <td>Сүүлийн 1 цагт 2200 амжилттай дуудлага бүртгэгдсэн байвал</td>
                                    <td>МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                                <tr>
                                    <td>OD_OUT Call with 2 HOUR DURATION</td>
                                    <td>2 цагаас илүү үргэлжилж байгаа яриа байвал</td>
                                    <td>МАБ шинжээч Б.Лхагвадорж</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sample" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODAL -->
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
            <!-- <div class="row">
                <p>IP хаягаар хайх</p>
                <div class="col-md-6">
                    <input type="text" id="src-ip" class="form-control" placeholder="Source IP"></input>
                     <select id="src-ip" class="form-control"><option></option></select> -->
                <!-- </div> -->
                <!-- <div class="col-md-6"> -->
                    <!-- <input type="text" id="dst-ip" class="form-control" placeholder="Destination IP"></input> -->
                    <!-- <select id="dst-ip" class="form-control"><option></option></select> -->
                <!-- </div> -->
            <!-- </div> -->
            <!-- <br>
            <div class="row">
                <p>Дугаараар хайх</p>
                <div class="col-md-6">
                    <input type="text" id="call-from" class="form-control" placeholder="From Number"></input>
                </div>
                <div class="col-md-6">
                    <input type="text" id="call-to" class="form-control" placeholder="To Number"></input>
                </div>
            </div> -->
            <br/>
            <div class="row">
                <p>Анхааруулгын төрөл сонгох</p>
                <div class="col-md-12">
                    <select class="form-control" id="type-controller">
                        <option></option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="container">
                    <button id="search" class="btn btn-sample form-control"><span class="glyphicon glyphicon-search"></span> Search</button>
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
                <div class="col-md-12">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="first-row">
                                <th style="display:none;"></th>
                                <th>Type</th>
                                <th>Level</th>
                                <th>Source</th>
                                <th>Callfrom</th>
                                <th>Destination</th>
                                <th>Callto</th>
                                <th>Content</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>
            </div>
            <div class="row" id="response"></div>
        </div>
    </body>
</html>
