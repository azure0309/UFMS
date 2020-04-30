<?php require "../req_login.php"; ?>

<!DOCTYPE html>
<html>

    <head>
    <meta charset="utf-8" /> 
    <title>Local Trunk Traffic</title>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script type="text/javascript" src="javascript/vendor/bootstrap.min.js"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <script type="text/javascript" src="javascript/sip_index_page/index_in.js"></script>
        <script type="text/javascript" src="javascript/sip_index_page/index.js"></script>
        <script type="text/javascript" src="javascript/sip_index_page/index_table.js"></script>
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
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Local Call <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Live</li>
                                <li class="active"><a href="sip_index.php">Local Call Rate & Local call Alerts</a></li>
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
                        <h4 class="modal-title">Local Alert</h4>
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
                                    <td>SIP_OUT Error number LENGTH</td>
                                    <td>Тухайн дуудлагын залгаж байгаа дугаарын урт 19 - с их байвал</td>
                                    <td>Core сүлжээ жижүүр инженер/Security Team</td>
                                </tr>
                                <tr>
                                    <td>SIP Error number PREFIX</td>
                                    <td>Олон улс руу 1668,008 - с өөр гарцаар, Харин Монгол дотрох дуудлаганд Монголд байж боломгүй дугаарлалттай байгаа эсэх</td>
                                    <td>Олон улсын жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>SIP_OUT Error number COUNTRY CODE</td>
                                    <td>Гарцын дугаар зөв боловч залгаж байгаа дугаарын улсын дугаар буруу байвал</td>
                                    <td>Олон улсын жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>SIP Blacklisted USER AGENT</td>
                                    <td>Хар жагсаалтанд байх User Agent - с дуудлага ирсэн байвал</td>
                                    <td>OMC(IP г шууд блок хийх)</td>
                                </tr>
                                <tr>
                                    <td>SIP_IN Blacklisted IP</td>
                                    <td>Хар жагсаалтанд байх IP хаягаас дуудлага ирсэн байвал</td>
                                    <td>OMC(IP г шууд блок хийх)</td>
                                </tr>
                                <tr>
                                    <td>SIP_OUT Blacklisted Prefix</td>
                                    <td>Хар жагсаалтанд байх улсын дугаараар эхэлсэн дугаарлуу залгасан байвал</td>.
                                    <td>Олон улсын жижүүр инженер</td>
                                </tr>
                                <tr>
                                    <td>SIP_IN DoS to ONE NUMBER</td>
                                    <td>1 Дугаарлуу минутанд 7 - с дээш удаа дуудлага орж ирвэл</td>
                                    <td>Security Team</td>
                                </tr>
                                <tr>
                                    <td>SIP_IN 300 invite from ONE SOURCE</td>
                                    <td>Сүүлийн 1 цагт 1 IP хаягаас 300 - с их дуудлага орж ирсэн эсвэл дуудлага орж ирэх оролдлого хийсэн байвал</td>
                                    <td>Security Team</td>
                                </tr>
                                <tr>
                                    <td>SIP_IN Caller with DIFFERENT IPs</td>
                                    <td>1 хэрэглэгч 1 минутанд өөр өөр IP хаягаас хандсан байвал</td>
                                    <td>Core сүлжээ жижүүр инженер/Security Team</td>
                                </tr>
                                <tr>
                                    <td>SIP_OUT Error 403 COUNT>500 || Unique(MSISDN) > 7</td>
                                    <td>Нэг IP хаягаас Систем рүү нэвтрэх гэж сүүлийн 2 цагт 500 - с дээш удаа амжилтгүй оролдлого хийсэн бол</td>
                                    <td>OMC</td>
                                </tr>
                                <tr>
                                    <td>SIP_OUT Error 403 Unique(MSISDN) > 20</td>
                                    <td>Сүүлийн 2 цагт системд бүртгэлтэй 20 - с дээш хэрэглэгчид Нэг IP хаяг руу 403 алдааны мэдээлэл явуулсан бол</td>
                                    <td>OMC</td>
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
                <div class="col-md-6">
                    <div id="container_in" style="min-width: 250px; height: 400px; margin: 0 auto"></div>
                </div>
                <div class="col-md-6">            
                    <div id="container_out" style="min-width: 250px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            <br/>
            <br/>
            <div class="row" id="table-data">
                <div class="col-md-12 table-responsive">
                    <table id="responsive-table" class="table table-bordered table-condensed">
                        <thead>
                            <tr class="first-row">
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
        </div>
    </body>
</html>
