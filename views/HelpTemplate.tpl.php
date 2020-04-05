<!doctype html>
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

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="http://localhost/baka-app?page=home"><i class="fas fa-home"></i> Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-question"></i> Help</li>
    </ol>
</nav>

<div class="container">

    <div>
        <h2>Prioritization</h2>
        <p></p>
    </div>

    <div class="accordion" id="accordionElements">

        <div class="card">
            <div class="card-header" id="headingImpact">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseImpact" aria-expanded="true" aria-controls="collapseImpact">
                        Impact
                    </button>
                </h2>
            </div>
            <div id="collapseImpact" class="collapse show" aria-labelledby="headingImpact" data-parent="#accordionElements">
                <div class="card-body">
                    <p></p>
                    <ul>
                        <li>Coffee</li>
                        <li>Tea</li>
                        <li>Milk</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingUrgency">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseUrgency" aria-expanded="false" aria-controls="collapseUrgency">
                        Urgency
                    </button>
                </h2>
            </div>
            <div id="collapseUrgency" class="collapse" aria-labelledby="headingUrgency" data-parent="#accordionElements">
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingProjectPhase">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseProjectPhase" aria-expanded="false" aria-controls="collapseProjectPhase">
                        Project Phase
                    </button>
                </h2>
            </div>
            <div id="collapseProjectPhase" class="collapse" aria-labelledby="headingProjectPhase" data-parent="#accordionElements">
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingAffectedNumberOfMachines">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseAffectedNumberOfMachines" aria-expanded="false" aria-controls="collapseAffectedNumberOfMachines">
                        Affected Number of Machines
                    </button>
                </h2>
            </div>
            <div id="collapseAffectedNumberOfMachines" class="collapse" aria-labelledby="headingAffectedNumberOfMachines" data-parent="#accordionElements">
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingReproducibility">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseReproducibility" aria-expanded="false" aria-controls="collapseReproducibility">
                        Reproducibility
                    </button>
                </h2>
            </div>
            <div id="collapseReproducibility" class="collapse" aria-labelledby="headingReproducibility" data-parent="#accordionElements">
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingSlaTime">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSlaTime" aria-expanded="false" aria-controls="collapseSlaTime">
                        SLA time
                    </button>
                </h2>
            </div>
            <div id="collapseSlaTime" class="collapse" aria-labelledby="headingSlaTime" data-parent="#accordionElements">
                <div class="card-body">

                </div>
            </div>
        </div>

    </div>


    <h2>Calculation Methods</h2>
    <div class="accordion" id="accordionMethods">

        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Impact
                    </button>
                </h2>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionMethods">
                <div class="card-body">
                    <p></p>
                    <ul>
                        <li>Coffee</li>
                        <li>Tea</li>
                        <li>Milk</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Urgency
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionMethods">
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Project Phase
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionMethods">
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Affected Number of Machines
                    </button>
                </h2>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionMethods">
                <div class="card-body">

                </div>
            </div>
        </div>

    </div>
</div>
</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include ("./views/elem/FooterTemplate.tml.php");
?>
</html>
