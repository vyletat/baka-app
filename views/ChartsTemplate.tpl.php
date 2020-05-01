<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $tplData['title']; ?></title>

    <!-- Nacteni sablony s hlavickou a odkazy stranky -->
    <?php
    include("./views/elem/HeadTemplate.tpl.php");
    ?>
</head>
<body>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?page=home"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Incidents Charts</li>
    </ol>
</nav>

<?php
/*if (isset($tplData['data'])) {
    print("<pre>".print_r($tplData['data'])."</pre>");
}*/
?>
<div class="container">
    <h1>Incident charts</h1>
    <div class="row">
        <p><i class="fas fa-angle-double-right"></i> Total count of incidents:&nbsp</p>
        <strong>
        <?php
            if (isset($tplData['count'])) {
                echo $tplData['count'];
            }
        ?>
        </strong>
    </div>


    <h2>Criteria</h2>
    <div class="row">
        <div class="col-sm-6 justify-content-center">
            <canvas id="chart-1" width="auto" height="auto"></canvas>
            <canvas id="chart-2" width="auto" height="auto"></canvas>
        </div>
        <div class="col-sm-6">
            <canvas id="chart-3" width="auto" height="auto"></canvas>
            <canvas id="chart-4" width="auto" height="auto"></canvas>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-6 ">
            <canvas id="chart-5" width="auto" height="auto"></canvas>
        </div>
    </div>

    <h2>Prioritization methods</h2>
    <div class="row justify-content-center">
        <div class="col-sm-6 ">
            <canvas id="chart-6" width="auto" height="auto"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <canvas id="chart-7" width="auto" height="auto"></canvas>
            <canvas id="chart-8" width="auto" height="auto"></canvas>
            <canvas id="chart-9" width="auto" height="auto"></canvas>
        </div>
        <div class="col-sm-6">
            <canvas id="chart-10" width="auto" height="auto"></canvas>
            <canvas id="chart-11" width="auto" height="auto"></canvas>
            <canvas id="chart-12" width="auto" height="auto"></canvas>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-6 ">
            <canvas id="chart-13" width="auto" height="auto"></canvas>
        </div>
    </div>
</div>

<script>
    //https://www.chartjs.org

    let pie_data = [<?php echo json_encode(($tplData['data'][0])); ?>];
    let pie_labels = [<?php echo json_encode(($tplData['data'][1])); ?>];
    let pie_elements = [<?php echo json_encode(($tplData['data'][2]))?>];
    let charts_id = ['chart-1', 'chart-2', 'chart-3', 'chart-4', 'chart-5', 'chart-6', 'chart-7', 'chart-8', 'chart-9', 'chart-10', 'chart-11', 'chart-12','chart-13'];

    for (i = 0; i < charts_id.length; i++) {
        var ctx = document.getElementById(charts_id[i]).getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pie_labels[0][i],
                datasets: [{
                    label: pie_elements[0][i],
                    data: pie_data[0][i],
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                title: {
                    display: true,
                    text: pie_elements[0][i]
                }
            }
        });
    }
</script>

</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include("./views/elem/FooterTemplate.tml.php");
?>
</html>