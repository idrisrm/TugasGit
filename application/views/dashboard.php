<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('_partials/head.php') ?>

<?php 

$konek = mysqli_connect("localhost", "root", "", "hidrophonik");

$id = mysqli_query($konek, "SELECT MAX(id) FROM ph");
$dataid = mysqli_fetch_array($id);

$idakhir = $dataid['MAX(id)'];
$idawal = $idakhir - 4;

$datawaktuph = mysqli_query($konek, "SELECT waktu FROM ph WHERE id >= '$idawal' and id <= '$idakhir' ORDER BY id ASC ");
$datanilaiph = mysqli_query($konek, "SELECT nilai FROM ph WHERE id >= '$idawal' and id <= '$idakhir' ORDER BY id ASC");

?>

<body class="nav-fixed">
    <?php $this->load->view('_partials/header.php') ?>
    <div id="layoutSidenav">
        <?php $this->load->view('_partials/sidebar.php') ?>
        <div id="layoutSidenav_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                    <div class="container">
                        <div class="page-header-content pt-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mt-4">
                                    <h1 class="page-header-title">
                                        <div class="page-header-icon">
                                            <i data-feather="activity"></i>
                                        </div>
                                        Dashboard
                                    </h1>
                                    <div class="page-header-subtitle">Dashboard Grafik Nilai pH dan PPM</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container mt-n10">
                    <div class="row">
                        <div class="col-xxl-3 col-lg-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-3">
                                            <div class="text-white-75 small">Nilai PH</div>
                                            <div class="text-lg font-weight-bold"> <span id="PH"></span> </div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="activity"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= base_url('DataPenghutang/PengajuanHutang') ?>">Lihat Detail</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-3">
                                            <div class="text-white-75 small">Nilai PPM</div>
                                            <div id="PPM" class="text-lg font-weight-bold"></div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="activity"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= base_url('RevisiTransaksi/index') ?>">Lihat Detail</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                            <div class="card card-header-actions h-100">
                                <div class="card-header">
                                    Grafik Nilai pH 
                                    <div class="no-caret">
                                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modalFilterDinas">
                                            <i data-feather="filter"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="PHG" width="100%" height="30"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                            <div class="card card-header-actions h-100">
                                <div class="card-header">
                                    Grafik Nilai PPM 
                                    <div class="no-caret">
                                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modalFilterDinas">
                                            <i data-feather="filter"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="PPMG" width="100%" height="30"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <?php $this->load->view('_partials/footer.php') ?>
            </footer>
        </div>
    </div>
    <?php $this->load->view('_partials/js.php') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            setInterval(function() {
                $("#PH").load(`<?= base_url('dashboard/PH') ?>`);
            }, 1000);

        });

        $(document).ready(function() {

            setInterval(function() {
                $("#PPM").load(`<?= base_url('dashboard/PPM') ?>`);
            }, 1000);

        });
    </script>


    <script type="text/javascript"> 
    
        var ctx2 = document.getElementById("PHG");
        var cData2 = JSON.parse(`<?php echo $PH; ?>`);
        console.log(cData2);
        var myBarChart = new Chart(ctx2, {
            type: "line",
            data: {
                labels: [
                    <?php 
                        while($data = mysqli_fetch_array($datawaktuph))
                        {
                            echo '"' . $data['waktu'] . '",';
                        }
                        ?>
                ],
                datasets: [{
                    label: "",
                    backgroundColor: "rgba(6, 121, 79, 0.3)",
                    hoverBackgroundColor: "rgba(6, 121, 79, 0.9)",
                    borderColor: "rgba(6, 121, 79, 1)",
                    data: [
                        
                        <?php 
                        while($data = mysqli_fetch_array($datanilaiph))
                        {
                            echo $data['nilai'] . ',';
                        }
                        ?>
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month"
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        },
                        maxBarThickness: 25
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 14,
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + number_format(tooltipItem.yLabel);
                        }
                    }
                },
                plugins: {
                    datalabels: false
                }
            }
        });

        var option = {
            showLines : true,
            animation : {duration : 0}
        }

        var myLinesChart = Chart.Line(canvas, {
            data : data, 
            options : option
        });

    </script>

    <script>
        var ctx2 = document.getElementById("PPMG");
        var cData2 = JSON.parse(`<?php echo $PPM; ?>`);
        console.log(cData2);
        var myBarChart = new Chart(ctx2, {
            type: "line",
            data: {
                labels: cData2.waktu,
                datasets: [{
                    label: "",
                    backgroundColor: "rgba(6, 121, 79, 0.3)",
                    hoverBackgroundColor: "rgba(6, 121, 79, 0.9)",
                    borderColor: "rgba(6, 121, 79, 1)",
                    data: cData2.nilai
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month"
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 12
                        },
                        maxBarThickness: 25
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 1400,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + number_format(tooltipItem.yLabel);
                        }
                    }
                },
                plugins: {
                    datalabels: false
                }
            }
        });
    </script>

    
</body>

</html>