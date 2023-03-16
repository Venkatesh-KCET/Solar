<?php
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "solar";

    // Create connection
    $sqlConnect = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$sqlConnect) {
        die("Connection failed: " . mysqli_connect_error());
    }

	function SQL_Return($sql) {
		global $sqlConnect;
		$result = mysqli_query($sqlConnect, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row["val"];
	}

	$date = date("Y-m-d");

	$humidity_max = SQL_Return("SELECT max(`value`) as 'val' FROM `humidity` WHERE `date` = '{$date}';");
	$temperature_max = SQL_Return("SELECT max(`value`) as 'val' FROM `temperature` WHERE `date` = '{$date}';");
	$ammonia_max = SQL_Return("SELECT max(`value`) as 'val' FROM `ammonia` WHERE `date` = '{$date}';");

	$yesterday = date('Y-m-d',strtotime("-1 days"));

	$humidity_yesterday_max = SQL_Return("SELECT max(`value`) as 'val' FROM `humidity` WHERE `date` = '{$yesterday}';");
	$temperature_yesterday_max = SQL_Return("SELECT max(`value`) as 'val' FROM `temperature` WHERE `date` = '{$yesterday}';");
	$ammonia_yesterday_max = SQL_Return("SELECT max(`value`) as 'val' FROM `ammonia` WHERE `date` = '{$yesterday}';");

	$humidity_inc = $humidity_max - $humidity_yesterday_max;
	$humidity_inc_percentage = ($humidity_inc/$humidity_yesterday_max)*100;

	$temperature_inc = $temperature_max - $temperature_yesterday_max;
	$temperature_inc_percentage = ($temperature_inc/$temperature_yesterday_max)*100;

	$ammonia_inc = $ammonia_max - $ammonia_yesterday_max;
	$ammonia_inc_percentage = ($ammonia_inc/$ammonia_yesterday_max)*100;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="assets/css/vendor.min.css" rel="stylesheet" />
		<link href="assets/css/app.min.css" rel="stylesheet" />
        <style>
            .app-content {margin-left: auto;}
            .brand-logo h3 {margin-left: 15px;}
            .app-header .brand {width: 20rem;}
        </style>
    </head>
	<body>
		<div id="app" class="app">
			<div id="header" class="app-header">
				<div class="brand">
					<a href="#" class="brand-logo">
                        <h3>CSS Test</h3>
					</a>
				</div>
				<div class="menu">
					<form class="menu-search" method="POST" name="header_search_form">
						<div class="menu-search-icon"><i class="fa fa-search"></i></div>
						<div class="menu-search-input">
							<input type="text" class="form-control" placeholder="Search menu..." />
						</div>
					</form>
					<div class="menu-item dropdown">
						<a href="#" data-bs-toggle="dropdown" data-display="static" class="menu-link">
							<div class="menu-icon"><i class="fa fa-bell nav-icon"></i></div>
							<div class="menu-label">3</div>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-notification">
							<h6 class="dropdown-header text-dark mb-1">Notifications</h6>
							<a href="#" class="dropdown-notification-item">
								<div class="dropdown-notification-icon">
									<i class="fa fa-oil-can fa-lg fa-fw text-danger"></i>
								</div>
								<div class="dropdown-notification-info">
									<div class="title">Leakage Alert</div>
									<div class="time">just now</div>
								</div>
								<div class="dropdown-notification-arrow">
									<i class="fa fa-chevron-right"></i>
								</div>
							</a>
							<a href="#" class="dropdown-notification-item">
								<div class="dropdown-notification-icon">
									<i class="far temperature-arrow-up fa-lg fa-fw text-muted"></i>
								</div>
								<div class="dropdown-notification-info">
									<div class="title">Temperature Increasing</div>
									<div class="time">2 minutes ago</div>
								</div>
								<div class="dropdown-notification-arrow">
									<i class="fa fa-chevron-right"></i>
								</div>
							</a>
							<div class="p-2 text-center mb-n1">
								<a href="#" class="text-dark text-opacity-50 text-decoration-none">See all</a>
							</div>
						</div>
					</div>
					<div class="menu-item dropdown">
						<a href="#" data-bs-toggle="dropdown" data-display="static" class="menu-link">
							<div class="menu-img online">
								<img src="assets/img/man.png" alt="" class="ms-100 mh-100 rounded-circle" />
							</div>
							<div class="menu-text">admin@gmail.com</div>
						</a>
						<div class="dropdown-menu dropdown-menu-right me-lg-3">
							<a class="dropdown-item d-flex align-items-center" href="profile.html">Edit Profile <i class="fa fa-user-circle fa-fw ms-auto text-dark text-opacity-50"></i></a>
							<a class="dropdown-item d-flex align-items-center" href="settings.html">Setting <i class="fa fa-wrench fa-fw ms-auto text-dark text-opacity-50"></i></a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item d-flex align-items-center" href="page_login.html">Log Out <i class="fa fa-toggle-off fa-fw ms-auto text-dark text-opacity-50"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div id="content" class="app-content">
				<h1 class="page-header mb-3">
					Hi, Venkatesh. <small>here's what's happening today.</small>
				</h1>
				<div class="row">
					<div class="col-xl-6">
						<div class="row">
							<div class="col-sm-6">
								<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-orange" style="min-height: 175px;">
									<div class="card-body position-relative">
										<h5 class="text-white text-opacity-80 mb-3 fs-16px">Today's Max Humidity</h5>
										<h3 class="text-white mt-n1"><?php echo $humidity_max; ?>%</h3>
										<div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
											<div class="progrss-bar progress-bar-striped bg-white" style="width: <?php echo $humidity_max; ?>%"></div>
										</div>
										<div class="text-white text-opacity-80 mb-4">
											<?php 
												if($humidity_inc_percentage >= 0) {
													echo '<i class="fa fa-caret-up"></i> '.$humidity_inc_percentage.'% increase ';
												} else {
													echo '<i class="fa fa-caret-down"></i> '.$humidity_inc_percentage*(-1).'% decrease ';
												}
											?>
											<br />compare to last day
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-pink" style="min-height: 175px;">
									<div class="card-body position-relative">
										<h5 class="text-white text-opacity-80 mb-3 fs-16px">Today's Max Temperature</h5>
										<h3 class="text-white mt-n1"><?php echo $temperature_max; ?>°</h3>
										<div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
											<div class="progrss-bar progress-bar-striped bg-white" style="width: <?php echo $temperature_max; ?>%"></div>
										</div>
										<div class="text-white text-opacity-80 mb-4">
											<?php 
												if($temperature_inc_percentage >= 0) {
													echo '<i class="fa fa-caret-up"></i> '.$temperature_inc_percentage.'% increase ';
												} else {
													echo '<i class="fa fa-caret-down"></i> '.$temperature_inc_percentage*(-1).'% decrease ';
												}
											?>
											<br />compare to last day
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6">
						<div class="row">
							<div class="col-sm-6">
								<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-teal" style="min-height: 175px;">
									<div class="card-body position-relative">
										<h5 class="text-white text-opacity-80 mb-3 fs-16px">Ammonia level</h5>
										<h3 class="text-white mt-n1"><?php echo $ammonia_max; ?> mumol/l</h3>
										<div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
											<div class="progrss-bar progress-bar-striped bg-white" style="width: <?php echo $ammonia_max; ?>%"></div>
										</div>
										<div class="text-white text-opacity-80 mb-4">
											<?php 
												if($ammonia_inc_percentage >= 0) {
													echo '<i class="fa fa-caret-up"></i> '.$ammonia_inc_percentage.'% increase ';
												} else {
													echo '<i class="fa fa-caret-down"></i> '.$ammonia_inc_percentage*(-1).'% decrease ';
												}
											?>
											<br />compare to last day
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-indigo" style="min-height: 175px;">
									<div class="card-body position-relative">
										<h5 class="text-white text-opacity-80 mb-3 fs-16px">Leakage</h5>
										<h3 class="text-white mt-n1">Yes</h3>
										<div><a href="#" class="text-white d-flex align-items-center text-decoration-none">View report <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6 mb-3">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex mb-3">
									<div class="flex-grow-1">
										<h5 class="mb-1">Temperature Analytics</h5>
										<div class="fs-13px">Weekly Temperature chart</div>
									</div>
									<a href="#" data-bs-toggle="dropdown" class="text-muted"><i class="fa fa-redo"></i></a>
								</div>
								<div id="chart"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 mb-3">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex mb-3">
									<div class="flex-grow-1">
										<h5 class="mb-1">Temperature Analytics</h5>
										<div class="fs-13px">Weekly Temperature chart</div>
									</div>
									<a href="#" data-bs-toggle="dropdown" class="text-muted"><i class="fa fa-redo"></i></a>
								</div>
								<div id="Humidchart"></div>
							</div>
						</div>
					</div>
                </div>
				<div class="row">
					<div class="col-xl-6 mb-3">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex align-items-center mb-4">
									<div class="flex-grow-1">
										<h5 class="mb-1">Ammonia level</h5>
										<div class="fs-13px">Latest 5 Ammonia level Data's</div>
									</div>
									<a href="#" class="text-decoration-none">See All</a>
								</div>
								<div class="d-flex align-items-center mb-3">
									<div class="flex-grow-1">
										<div>
											<div class="text-danger fs-10px fw-600">Low</div>
											<div class="text-dark fw-600">12:00 PM</div>
											<div class="fs-13px">12/03/2023</div>
										</div>
									</div>
									<div class="ps-3 text-center">
										<div class="text-dark fw-600">300</div>
										<div class="fs-13px">psig</div>
									</div>
								</div>
								<div class="d-flex align-items-center mb-3">
									<div class="flex-grow-1">
										<div>
											<div class="text-dark fw-600">01:00 PM</div>
											<div class="fs-13px">12/03/2023</div>
										</div>
									</div>
									<div class="ps-3 text-center">
										<div class="text-dark fw-600">102</div>
										<div class="fs-13px">psig</div>
									</div>
								</div>
								<div class="d-flex align-items-center mb-3">
									<div class="flex-grow-1">
										<div>
											<div class="text-dark fw-600">02:00 PM</div>
											<div class="fs-13px">12/03/2023</div>
										</div>
									</div>
									<div class="ps-3 text-center">
										<div class="text-dark fw-600">75</div>
										<div class="fs-13px">psig</div>
									</div>
								</div>
								<div class="d-flex align-items-center mb-3">
									<div class="flex-grow-1">
										<div>
											<div class="text-dark fw-600">03:00 PM</div>
											<div class="fs-13px">12/03/2023</div>
										</div>
									</div>
									<div class="ps-3 text-center">
										<div class="text-dark fw-600">62</div>
										<div class="fs-13px">psig</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 mb-3">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex align-items-center mb-2">
									<div class="flex-grow-1">
										<h5 class="mb-1">Leakage</h5>
										<div class="fs-13px">Latest Leakage history</div>
									</div>
									<a href="#" class="text-decoration-none">See All</a>
								</div>
								<div class="table-responsive mb-n2">
									<table class="table table-borderless mb-0">
										<thead>
											<tr class="text-dark">
												<th class="ps-0">No</th>
												<th>Date and Time</th>
												<th class="text-center">Status</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="ps-0">1.</td>
												<td>
													<div class="d-flex align-items-center">
														<div class="ms-3 flex-grow-1">
															<div class="fw-600 text-dark">7:00 AM</div>
															<div class="fs-13px">13/10/1990</div>
														</div>
													</div>
												</td>
												<td class="text-center"><span class="badge bg-success bg-opacity-20 text-success" style="min-width: 60px;">No Leak</span></td>
											</tr>
											<tr>
												<td class="ps-0">2.</td>
												<td>
													<div class="d-flex align-items-center">
														<div class="ms-3 flex-grow-1">
															<div class="fw-600 text-dark">1:00 AM</div>
															<div class="fs-13px">27/07/2002</div>
														</div>
													</div>
												</td>
												<td class="text-center"><span class="badge bg-success bg-opacity-20 text-success" style="min-width: 60px;">No Leak</span></td>
											</tr>
											<tr>
												<td class="ps-0">3.</td>
												<td>
													<div class="d-flex align-items-center">
														<div class="ms-3 flex-grow-1">
															<div class="fw-600 text-dark">5:00 PM</div>
															<div class="fs-13px">13/02/2003</div>
														</div>
													</div>
												</td>
												<td class="text-center"><span class="badge bg-warning bg-opacity-20 text-warning" style="min-width: 60px;">Leakage</span></td>
											</tr>
											<tr>
												<td class="ps-0">4.</td>
												<td>
													<div class="d-flex align-items-center">
														<div class="ms-3 flex-grow-1">
															<div class="fw-600 text-dark">5:00 PM</div>
															<div class="fs-13px">13/02/2003</div>
														</div>
													</div>
												</td>
												<td class="text-center"><span class="badge text-dark text-opacity-50 bg-dark bg-opacity-10" style="min-width: 60px;">No Update</span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 mb-6">
						<div class="card">
							<ul class="nav nav-tabs pt-3 ps-4 pe-4">
								<li class="nav-item me-1"><a href="#pv1" class="nav-link active" data-bs-toggle="tab">PV1</a></li>
								<li class="nav-item me-1"><a href="#pv2" class="nav-link" data-bs-toggle="tab">PV2</a></li>
							</ul>
							<div class="tab-content p-4">
								<div class="tab-pane fade show active" id="pv1">
									<div class="row">
										<div class="col-xl-4 mb-6">
											<a href="#" class="card bg-gradient-custom-orange border-0 text-decoration-none">
												<div class="card-body d-flex align-items-center text-white">
													<div class="flex-fill">
														<div class="mb-1">Voltage</div>
														<h2>25 V</h2>
													</div>
												</div>
											  </a>
										</div>
										<div class="col-xl-4 mb-6">
											<a href="#" class="card bg-gradient-custom-indigo border-0 text-decoration-none">
												<div class="card-body d-flex align-items-center text-white">
													<div class="flex-fill">
														<div class="mb-1">Current</div>
														<h2>25 V</h2>
													</div>
												</div>
											  </a>
										</div>
										<div class="col-xl-4 mb-6">
											<a href="#" class="card bg-gradient-custom-teal border-0 text-decoration-none">
												<div class="card-body d-flex align-items-center text-white">
													<div class="flex-fill">
														<div class="mb-1">Power</div>
														<h2>25 V</h2>
													</div>
												</div>
											  </a>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="pv2">
									<div class="row">
										<div class="col-xl-4 mb-6">
											<a href="#" class="card bg-gradient-custom-orange border-0 text-decoration-none">
												<div class="card-body d-flex align-items-center text-white">
													<div class="flex-fill">
														<div class="mb-1">Voltage</div>
														<h2>25 V</h2>
													</div>
												</div>
											  </a>
										</div>
										<div class="col-xl-4 mb-6">
											<a href="#" class="card bg-gradient-custom-indigo border-0 text-decoration-none">
												<div class="card-body d-flex align-items-center text-white">
													<div class="flex-fill">
														<div class="mb-1">Current</div>
														<h2>25 V</h2>
													</div>
												</div>
											  </a>
										</div>
										<div class="col-xl-4 mb-6">
											<a href="#" class="card bg-gradient-custom-teal border-0 text-decoration-none">
												<div class="card-body d-flex align-items-center text-white">
													<div class="flex-fill">
														<div class="mb-1">Power</div>
														<h2>25 V</h2>
													</div>
												</div>
											  </a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-12 mt-20px mb-6">
						<div class="card">
							<div class="card-body">
							
								<div class="d-flex align-items-center mb-2 h3">
									<div class="flex-fill fw-600 fs-16px">Returning customer rate</div>
								</div>

								<div>
									<div class="chart mb-2" style="height: 190px">
										<canvas id="chart3" class="w-100" height="190"></canvas>
									</div>
									<div class="d-flex align-items-center">
										<i class="fa fa-square text-indigo me-2 ms-auto"></i>
										<span class="fs-12px me-4">PV 1</span>
										<i class="fa fa-square text-teal me-2"></i>
										<span class="fs-12px">PV 2</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
        <script src="assets/js/vendor.min.js" type="text/javascript"></script>
		<script src="assets/js/app.min.js" type="text/javascript"></script>
		<script src="assets/js/apexcharts.min.js" type="text/javascript"></script>
		<script src="assets/js/chart.umd.js" type="text/javascript"></script>
		<script src="assets/js/chart-data.js" type="text/javascript"></script>
		<script src="assets/js/moment.min.js" type="text/javascript"></script>
    </body>
</html>
<script>

function handleChart(udata, ulabel, uid) {
    $(uid).empty();
    Apex={
        grid:{borderColor:'rgba('+app.color.componentColorRgb+', .15)'},
        title:{style:{color:app.color.componentColor}},
        legend:{labels:{colors:app.color.componentColor}},
        xaxis:{
            axisBorder:{
                show:true,
                color:'rgba('+app.color.componentColorRgb+', .25)',
                height:1,width:'100%',
                offsetX:0,offsetY:-1
            },
            axisTicks:{
                show:true,
                borderType:'solid',
                color:'rgba('+app.color.componentColorRgb+', .25)',
                height:6,offsetX:0,offsetY:0
            },
            labels:{
                style:{
                    colors:app.color.componentColor,
                    fontSize:app.font.size,
                    fontFamily:app.font.family,
                    fontWeight:400,
                    cssClass:'apexcharts-xaxis-label',
                }
            }
        },
        yaxis:{
            labels:{
                style:{
                    colors:app.color.componentColor,
                    fontSize:app.font.size,
                    fontFamily:app.font.family,
                    fontWeight:400,
                    cssClass:'apexcharts-xaxis-label'
                }
            }
        }
    };
    var options={
        series:[{data:udata}],
        labels:ulabel,
        colors:[app.color.blue],
        chart:{height:256,type:'line',toolbar:{show:false}},
        dataLabels:{enabled:false},
        stroke:{curve:'straight'},
        grid:{padding:{right:30,left:20}},
        xaxis:{type:'datetime'}
    };
    var chart=new ApexCharts(document.querySelector(uid),options);
    chart.render();
};
$(document).ready(function(){
    handleChart([0, 10, 30, 50, 50, 60, 70, 100, 70, 30, 0, 2, 50, 70, 20],['1:00 12 Mar 2023','2:00 12 Mar 2023','3:00 12 Mar 2023','4:00 12 Mar 2023','5:00 12 Mar 2023','6:00 12 Mar 2023','7:00 12 Mar 2023','8:00 12 Mar 2023','9:00 12 Mar 2023','10:00 12 Mar 2023','11:00 12 Mar 2023','12:00 12 Mar 2023','13:00 12 Mar 2023','14:00 12 Mar 2023','15:00 12 Mar 2023'],'#chart');
    $(document).on('theme-change',function(){
        handleChart([0, 10, 30, 50, 50, 60, 70, 100, 70, 30, 0, 2, 50, 70, 20],['1:00 12 Mar 2023','2:00 12 Mar 2023','3:00 12 Mar 2023','4:00 12 Mar 2023','5:00 12 Mar 2023','6:00 12 Mar 2023','7:00 12 Mar 2023','8:00 12 Mar 2023','9:00 12 Mar 2023','10:00 12 Mar 2023','11:00 12 Mar 2023','12:00 12 Mar 2023','13:00 12 Mar 2023','14:00 12 Mar 2023','15:00 12 Mar 2023'],'#chart');
    });
    handleChart([0, 10, 30, 50, 50, 60, 70, 100, 70, 30, 0, 2, 50, 70, 20],['1:00 12 Mar 2023','2:00 12 Mar 2023','3:00 12 Mar 2023','4:00 12 Mar 2023','5:00 12 Mar 2023','6:00 12 Mar 2023','7:00 12 Mar 2023','8:00 12 Mar 2023','9:00 12 Mar 2023','10:00 12 Mar 2023','11:00 12 Mar 2023','12:00 12 Mar 2023','13:00 12 Mar 2023','14:00 12 Mar 2023','15:00 12 Mar 2023'],'#Humidchart');
    $(document).on('theme-change',function(){
        handleChart([0, 10, 30, 50, 50, 60, 70, 100, 70, 30, 0, 2, 50, 70, 20],['1:00 12 Mar 2023','2:00 12 Mar 2023','3:00 12 Mar 2023','4:00 12 Mar 2023','5:00 12 Mar 2023','6:00 12 Mar 2023','7:00 12 Mar 2023','8:00 12 Mar 2023','9:00 12 Mar 2023','10:00 12 Mar 2023','11:00 12 Mar 2023','12:00 12 Mar 2023','13:00 12 Mar 2023','14:00 12 Mar 2023','15:00 12 Mar 2023'],'#Humidchart');
    });

});
</script>