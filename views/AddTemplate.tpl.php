<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $tplData['title']; ?></title>

    <!-- Nacteni sablony s hlavickou a odkazy stranky -->
    <?php
    include ("./views/elem/HeadTemplate.tpl.php");
    ?>
</head>
<body>

<!-- Navbar for orirentation in the app -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="http://localhost/baka-app?page=home"><i class="fas fa-home"></i> Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-plus"></i> Add Incidents</li>
    </ol>
</nav>

<div class="container">

    <?php
    echo "rating1:";
        var_dump($tplData['values1']);
    echo "<br> prio1:";
    var_dump($tplData['priority1']);
    echo "<br> rating2:";
    var_dump($tplData['values2']);
    echo "<br> prio2:";
    var_dump($tplData['priority2']);
    echo "<br> time:";
    var_dump($tplData['time']);
    ?>

    <div class="row">
        <div class="col-sm-11">
            <!-- Form for generate one specific incident -->
            <fieldset>
                <legend>Add specific incident</legend>
                <form  method="get" action="">
                    <!-- Hidden input for MVC page add -->
                    <input type="hidden" name="page" value="add" />
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Name of incident</label>
                                <input type="text" class="form-control" id="name" placeholder="Type a name..." name="name">
                            </div>

                            <div class="form-group">
                                <label for="reproductive">Reproductive</label>
                                <select class="form-control" id="reproductive" name="reproductive" required>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="project-phase">Project phase</label>
                                <select class="form-control" id="project-phase" name="project-phase" required>
                                    <option value="1">Production</option>
                                    <option value="2">Pilot</option>
                                    <option value="3">UAT</option>
                                    <option value="4">Certification</option>
                                    <option value="5">SIT</option>
                                    <option value="6">Internal QA</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="number-of-affective-machines">Number of affective machines</label>
                                <select class="form-control" id="number-of-affective-machines" name="number-of-affective-machines" required>
                                    <option value="1">more than 1000</option>
                                    <option value="2">101-1000</option>
                                    <option value="3">11-100</option>
                                    <option value="4">2-10</option>
                                    <option value="5">1</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="urgency">Urgenci</label>
                                <select class="form-control" id="urgency" name="urgency" required>
                                    <option value="1">Highest</option>
                                    <option value="2">High</option>
                                    <option value="3">Medium</option>
                                    <option value="4">Low</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="impact">Impact</label>
                                <select class="form-control" id="impact" name="impact" required>
                                    <option value="1">Critical</option>
                                    <option value="2">Non-critical</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sla-time">SLA time</label>
                                <input type="number" class="form-control" id="sla-time" name="sla-time" min="1" max="525600" required>
                                <small class="form-text text-muted">Max 525 600</small>
                            </div>

                            <div class="form-group">
                                <label for="expected-priority">Expected Priority</label>
                                <select class="form-control" id="expected-priority" name="expected-priority" required>
                                    <option value="1">Very High</option>
                                    <option value="2">High</option>
                                    <option value="3">Medium</option>
                                    <option value="4">Low</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-success col-sm-3" id="add-incident-button"><i class="fas fa-plus"></i> Add</button>
                </form>
            </fieldset>

            <!-- Zobrazeni alertu o stavu formulare -->
            <?php
            if (isset($tplData['add_status'])) {
                if ($tplData['add_status'] == true) {
                    echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                $tplData[add_alert]
                 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
                 </button>
                </div>";
                }
                if ($tplData['add_status'] == false) {
                    echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                $tplData[add_alert]
                 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
                 </button>
                </div>";
                }
            }
            ?>

            <!-- Form for generating many random incidents data -->
            <fieldset>
                <legend>Generate random incidents</legend>
                <form action="" method="get">
                    <!-- Hidden input for MVC page add -->
                    <input type="hidden" name="page" value="add" />
                    <div class="col-sm-6 row">
                        <div class="form-group">
                            <label for="generator-number">Number of incidents you can generate</label>
                            <input type="number" min="1" max="100" class="form-control" id="generator-number" value="1" name="generate-number">
                            <small class="form-text text-muted">Max 100</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success col-sm-3" id="generate-incident-button"><i class="fas fa-database"></i> Generate</button>
                </form>
            </fieldset>

            <!-- Zobrazeni alertu o stavu formulare -->
            <?php
            if (isset($tplData['add_generate_status'])) {
                if ($tplData['add_generate_status'] == true) {
                    echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                $tplData[add_generate_alert]
                 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
                 </button>
                </div>";
                }
                if ($tplData['add_generate_status'] == false) {
                    echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                $tplData[add_generate_alert]
                 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
                 </button>
                </div>";
                }
            }
            ?>
        </div>
        <div class="col-sm-1">
            <button class="btn btn-primary" style="height: 100%" onclick="window.location.href = 'http://localhost/baka-app?page=table'"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>
</div>
</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include ("./views/elem/FooterTemplate.tml.php");
?>
</html>
