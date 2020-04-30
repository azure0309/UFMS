<html>
	<head>
	<title>Report</title>
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
    <script type="text/javascript" src="javascript/vendor/jquery.datetimepicker.full.js"></script>
    <link type="text/css" rel="stylesheet" href="css/jquery.datetimepicker.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<script type="text/javascript" src="javascript/report_page/report.js"></script>
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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Call Statistics <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="statistic.php">International Call</a></li>
                                <li><a href="sip_statistic.php">Local Call</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
	        <div class="row">
	            <p>Өдрөөр хайх(Report)</p>
	            <form id="target">
	                <div class="col-md-5">
	                    <div class="input-group input-daterange input-group-md">
	                        <a id="fromdatepicker1" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></a>
	                    	<input id="datetimepicker1" type="text" class="form-control" placeholder="From Date">
	                	</div>
	                </div>
	                <div class="col-md-5">
	                    <div class="input-group input-daterange input-group-md">
	                        <input id="datetimepicker2" type="text" class="form-control" placeholder="To Date">
	                    	<a id="todatepicker1" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></a>
	                	</div>
	                </div>
	                <div class="col-md-2">
	                	<button id="not-static" type="button" class="btn btn-sample btn-large form-control"><span class="glyphicon glyphicon-search"></span> Search</button>
	            	</div>
	        	</form>
	        </div>
	    </div>
	</body>
</html>