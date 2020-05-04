<!doctype html>
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
        <li class="breadcrumb-item"><a href="?page=home"><i class="fas fa-home"></i> Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-question"></i> Help</li>
    </ol>
</nav>

<!-- Script pro nacteni AOS pro animovane prvky -->
<script>
    AOS.init();
</script>

<div class="container">

    <div>
        <h2>Prioritization</h2>
        <p></p>
    </div>

    <div class="accordion" id="accordionElements" data-aos="zoom-in-up">

        <div class="card">
            <div class="card-header" id="headingImpact">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseImpact"
                            aria-expanded="true" aria-controls="collapseImpact">
                        Impact
                    </button>
                </h2>
            </div>
            <div id="collapseImpact" class="collapse show" aria-labelledby="headingImpact"
                 data-parent="#accordionElements">
                <div class="card-body">
                    An attribute that expresses the impact of an incident on the customer's business. It is divided into
                    two levels.
                    <ol>
                        <li><strong>Critical</strong></li>
                        <li><strong>Non-critical</strong></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingUrgency">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseUrgency" aria-expanded="false" aria-controls="collapseUrgency">
                        Urgency
                    </button>
                </h2>
            </div>
            <div id="collapseUrgency" class="collapse" aria-labelledby="headingUrgency"
                 data-parent="#accordionElements">
                <div class="card-body">
                    An attribute indicating the urgency of the problem from the customer's point of view. DN
                    distinguishes four types.
                    <ol>
                        <li><strong>Low</strong></li>
                        <li><strong>Medium</strong></li>
                        <li><strong>High</strong></li>
                        <li><strong>Highest</strong></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingProjectPhase">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseProjectPhase" aria-expanded="false"
                            aria-controls="collapseProjectPhase">
                        Project Phase
                    </button>
                </h2>
            </div>
            <div id="collapseProjectPhase" class="collapse" aria-labelledby="headingProjectPhase"
                 data-parent="#accordionElements">
                <div class="card-body">
                    An attribute expressing the design phase in which the product is located. The support department
                    distinguishes between six phases of the project.
                    <ol>
                        <li><strong>Production</strong> - The product is already in production and the incident has the
                            greatest impact because the customer's business is affected.
                        </li>
                        <li><strong>Pilot</strong> - The product is in the test phase of deployment, it is tested on the
                            customer's side.
                        </li>
                        <li><strong>UAT</strong> (User Acceptance Testing) - Acceptance testing is the phase when
                            testing is performed on the customer's side.
                        </li>
                        <li><strong>Certification</strong> - Certification is the phase in which the product is handed
                            over to the company to verify the individual certifications that are used within the
                            product.
                        </li>
                        <li><strong>SIT</strong> (System Integration Testing) - System testing is the phase during which
                            the application as a whole is tested. The steps that may occur in practice are simulated.
                        </li>
                        <li><strong>Internal QA</strong> (Internal Quality Assurance) - Quality assurance is the phase
                            in which a way is provided to prevent defects or errors in a product.
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingAffectedNumberOfMachines">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseAffectedNumberOfMachines" aria-expanded="false"
                            aria-controls="collapseAffectedNumberOfMachines">
                        Affected Number of Machines
                    </button>
                </h2>
            </div>
            <div id="collapseAffectedNumberOfMachines" class="collapse"
                 aria-labelledby="headingAffectedNumberOfMachines" data-parent="#accordionElements">
                <div class="card-body">
                    Attribute indicating the number of affected machines. The more machines there are affected, the more
                    important the incident will be and will be addressed as a matter of priority. Every machine is
                    usually out of operation until the incident is resolved and the customer cannot use it for his
                    business. The support department defined five intervals.
                    <ol>
                        <li><strong>1</strong></li>
                        <li><strong>1 -10</strong></li>
                        <li><strong>10 - 100</strong></li>
                        <li><strong>100 - 1000</strong></li>
                        <li><strong>more than 1000</strong></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingReproducibility">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseReproducibility" aria-expanded="false"
                            aria-controls="collapseReproducibility">
                        Reproducibility
                    </button>
                </h2>
            </div>
            <div id="collapseReproducibility" class="collapse" aria-labelledby="headingReproducibility"
                 data-parent="#accordionElements">
                <div class="card-body">
                    This attribute expresses whether the incident is reproducible, ie whether certain steps and
                    instructions can lead to the same conditions. It takes only two values ​​in the ticket:
                    <ol>
                        <li><strong>yes</strong></li>
                        - the event is reproducible and the steps to establish the given problem should be described in
                        some file.
                        <li><strong>no</strong></li>
                        - the event cannot be reproduced by certain steps. It can be based on various causes, such as
                        unpredictable hardware events (solar flares, outages, nuclear war, etc.), too many incidents
                        leading to the cause, or the event is accidental.
                    </ol>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingSlaTime">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseSlaTime" aria-expanded="false" aria-controls="collapseSlaTime">
                        SLA time
                    </button>
                </h2>
            </div>
            <div id="collapseSlaTime" class="collapse" aria-labelledby="headingSlaTime"
                 data-parent="#accordionElements">
                <div class="card-body">
                    This attribute specifies the value remaining in the FAQ support team defined in the SLA. It is a
                    dynamic attribute given in minutes.
                </div>
            </div>
        </div>

    </div>

    <h2 id="h2-calculation">Calculation Methods</h2>
    <div class="accordion" id="accordionMethods" data-aos="zoom-in-up">

        <div class="card">
            <div class="card-header" id="headingMethodOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseMethodOne"
                            aria-expanded="true" aria-controls="collapseMethodOne">
                        Method Diebold Nixdorf default
                    </button>
                </h2>
            </div>
            <div id="collapseMethodOne" class="collapse show" aria-labelledby="headingMethodOne"
                 data-parent="#accordionMethods">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr class="tableizer-firstrow">
                                    <th>Pořadí</th>
                                    <th>Atribut</th>
                                    <th>Pořadí</th>
                                    <th>Hodnoty</th>
                                    <th>Váha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>2.</td>
                                    <td>Urgency</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>8</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Highest</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>High</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>Medium</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Low</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>NoAM</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>> 1000</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>101 - 1000</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>11 - 100</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>2 - 10</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>1</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>Impact</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>9</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Critical</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Non-critical</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Project Phase</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Production</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Pilot</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>UAT</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Certification</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>SIT</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>internal QA</td>
                                    <td>6</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingMethodTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseMethodTwo" aria-expanded="false" aria-controls="collapseMethodTwo">
                        Method RS
                    </button>
                </h2>
            </div>
            <div id="collapseMethodTwo" class="collapse" aria-labelledby="headingMethodTwo"
                 data-parent="#accordionMethods">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr class="tableizer-firstrow">
                                    <th>Pořadí</th>
                                    <th>Atribut</th>
                                    <th>Pořadí</th>
                                    <th>Hodnoty</th>
                                    <th>Váha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>SLA time</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,189189189</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Urgency</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,18018018</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Highest</td>
                                    <td>0,294117647</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>High</td>
                                    <td>0,264705882</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>Medium</td>
                                    <td>0,235294118</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Low</td>
                                    <td>0,205882353</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>NoAM</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,162162162</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>> 1000</td>
                                    <td>0,230769231</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>101 - 1000</td>
                                    <td>0,215384615</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>11 - 100</td>
                                    <td>0,2</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>2 - 10</td>
                                    <td>0,184615385</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>1</td>
                                    <td>0,169230769</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Impact</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,171171171</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Critical</td>
                                    <td>0,6</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Non-critical</td>
                                    <td>0,4</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Project Phase</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,153153153</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Production</td>
                                    <td>0,189189189</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Pilot</td>
                                    <td>0,18018018</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>UAT</td>
                                    <td>0,171171171</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Certification</td>
                                    <td>0,162162162</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>SIT</td>
                                    <td>0,153153153</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>6.</td>
                                    <td>Internal QA</td>
                                    <td>0,144144144</td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Reproducibility</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,144144144</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Yes</td>
                                    <td>0,6</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>No</td>
                                    <td>0,4</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingMethodThree">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseMethodThree" aria-expanded="false"
                            aria-controls="collapseMethodThree">
                        Method RR
                    </button>
                </h2>
            </div>
            <div id="collapseMethodThree" class="collapse" aria-labelledby="headingMethodThree"
                 data-parent="#accordionMethods">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr class="tableizer-firstrow">
                                    <th>Pořadí</th>
                                    <th>Atribut</th>
                                    <th>Pořadí</th>
                                    <th>Hodnoty</th>
                                    <th>Váha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>SLA time</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,408163265</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Urgency</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,204081633</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Highest</td>
                                    <td>0,48</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>High</td>
                                    <td>0,24</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>Medium</td>
                                    <td>0,16</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Low</td>
                                    <td>0,12</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>NoAM</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,102040816</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>> 1000</td>
                                    <td>0,437956204</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>101 - 1000</td>
                                    <td>0,218978102</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>11 - 100</td>
                                    <td>0,145985401</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>2 - 10</td>
                                    <td>0,109489051</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>1</td>
                                    <td>0,087591241</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Impact</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,136054422</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Critical</td>
                                    <td>0,666666667</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Non-critical</td>
                                    <td>0,333333333</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Project Phase</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,081632653</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Production</td>
                                    <td>0,408163265</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Pilot</td>
                                    <td>0,204081633</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>UAT</td>
                                    <td>0,136054422</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Certification</td>
                                    <td>0,102040816</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>SIT</td>
                                    <td>0,081632653</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>6.</td>
                                    <td>Internal QA</td>
                                    <td>0,068027211</td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Reproducibility</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,068027211</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Yes</td>
                                    <td>0,666666667</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>No</td>
                                    <td>0,333333333</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingMethodFour">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseMethodFour" aria-expanded="false" aria-controls="collapseMethodFour">
                        Method RE
                    </button>
                </h2>
            </div>
            <div id="collapseMethodFour" class="collapse" aria-labelledby="headingMethodFour"
                 data-parent="#accordionMethods">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr class="tableizer-firstrow">
                                    <th>Pořadí</th>
                                    <th>Atribut</th>
                                    <th>Pořadí</th>
                                    <th>Hodnoty</th>
                                    <th>Váha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>SLA time</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,289279137</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Urgency</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,226657773</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Highest</td>
                                    <td>0,479331237</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>High</td>
                                    <td>0,283040302</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>Medium</td>
                                    <td>0,15706726</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Low</td>
                                    <td>0,080561201</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>NoAM</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,133839148</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>> 1000</td>
                                    <td>0,36536958</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>101 - 1000</td>
                                    <td>0,258771396</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>11 - 100</td>
                                    <td>0,178645817</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>2 - 10</td>
                                    <td>0,119724304</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>1</td>
                                    <td>0,077488904</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Impact</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,175383464</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Critical</td>
                                    <td>0,883636364</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Non-critical</td>
                                    <td>0,116363636</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Project Phase</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,100569258</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Production</td>
                                    <td>0,289279137</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Pilot</td>
                                    <td>0,226657773</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>UAT</td>
                                    <td>0,175383464</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Certification</td>
                                    <td>0,133839148</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>SIT</td>
                                    <td>0,100569258</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>6.</td>
                                    <td>Internal QA</td>
                                    <td>0,074271219</td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Reproducibility</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,074271219</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Yes</td>
                                    <td>0,883636364</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>No</td>
                                    <td>0,116363636</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingMethodFive">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseMethodFive" aria-expanded="false" aria-controls="collapseMethodFive">
                        Method ROC
                    </button>
                </h2>
            </div>
            <div id="collapseMethodFive" class="collapse" aria-labelledby="headingMethodFive"
                 data-parent="#accordionMethods">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr class="tableizer-firstrow">
                                    <th>Pořadí</th>
                                    <th>Atribut</th>
                                    <th>Pořadí</th>
                                    <th>Hodnoty</th>
                                    <th>Váha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>SLA time</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,408333333</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Urgency</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,241666667</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Highest</td>
                                    <td>0,520833333</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>High</td>
                                    <td>0,270833333</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>Medium</td>
                                    <td>0,145833333</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Low</td>
                                    <td>0,0625</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>NoAM</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,102777778</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>> 1000</td>
                                    <td>0,456666667</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>101 - 1000</td>
                                    <td>0,256666667</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>11 - 100</td>
                                    <td>0,156666667</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>2 - 10</td>
                                    <td>0,09</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>1</td>
                                    <td>0,04</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Impact</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,158333333</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Critical</td>
                                    <td>0,75</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Non-critical</td>
                                    <td>0,25</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Project Phase</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,061111111</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Production</td>
                                    <td>0,408333333</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>Pilot</td>
                                    <td>0,241666667</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>3.</td>
                                    <td>UAT</td>
                                    <td>0,158333333</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>4.</td>
                                    <td>Certification</td>
                                    <td>0,102777778</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>5.</td>
                                    <td>SIT</td>
                                    <td>0,061111111</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>6.</td>
                                    <td>Internal QA</td>
                                    <td>0,027777778</td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Reproducibility</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>0,027777778</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>1.</td>
                                    <td>Yes</td>
                                    <td>0,75</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>2.</td>
                                    <td>No</td>
                                    <td>0,25</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include("./views/elem/FooterTemplate.tml.php");
?>
</html>
