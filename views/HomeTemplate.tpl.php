<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $tplData['title']; ?></title>

    <!-- CDN for Animate On Scroll Library -->
    <!-- https://michalsnik.github.io/aos/ -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Nacteni sablony s hlavickou a odkazy stranky -->
    <?php
    include("./views/elem/HeadTemplate.tpl.php");
    ?>

    <style>
        .btn {
            height: 200px !important;
            width: 200px !important;
            margin: 20px;
        }
    </style>
</head>
<body>

<!-- Script pro nacteni AOS pro animovane prvky -->
<script>
    AOS.init();
</script>

<!-- Navbar for orirentation in the app -->
<nav aria-label="breadcrumb fixed-top">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-home"></i> Home</li>
    </ol>
</nav>

<!-- Jumbotron for the description of the app -->
<div class="jumbotron">
    <h1 class="display-4">Application for SW support prioritization.</h1>
    <p class="lead">Web application for incident prioritization calculation for my qualification work.</p>
</div>

<div class="container">
    <!-- Description of the company -->
    <div class="media">
        <img src="./pic/DNLogo.jpg" class="align-self-center mr-3 rounded" alt="..." height="150">
        <div class="media-body">
            <h5 class="mt-0">DieBold Nixdorf s.r.o.</h5>
            <p>We’re a global company with a local presence. In our “always on” world, we’re shaping the future of
                transactions, so while our solutions are driven by universal themes, they come to life through unique
                regional collaborations with our customers.</p>
            <p class="mb-0">As the world leader in connected commerce, our organization has the breadth, scale and
                expertise to deliver the right solutions, at the right times, in the right place.</p>
        </div>
    </div>

    <!-- Buttons to access the main functions of the application -->
    <div>
        <div class="row justify-content-sm-center">
            <button data-aos="zoom-in" class="btn btn-success"
                    onclick="window.location.href = 'http://localhost/baka-app?page=add'"><i class="fas fa-plus"></i>
                Add incident
            </button>
            <button data-aos="zoom-in" class="btn btn-primary"
                    onclick="window.location.href = 'http://localhost/baka-app?page=table'"><i class="fas fa-table"></i>
                Incident table
            </button>
            <button data-aos="zoom-in" class="btn btn-warning"
                    onclick="window.location.href = 'http://localhost/baka-app?page=methods'"><i
                        class="fas fa-calculator"></i> Calculation methods
            </button>
        </div>
        <div class="row justify-content-sm-center">
            <button data-aos="zoom-in" class="btn btn-danger"
                    onclick="window.location.href = 'http://localhost/baka-app?page=charts'"><i
                        class="fas fa-chart-pie"></i> Charts
            </button>
            <button data-aos="zoom-in" class="btn btn-info"
                    onclick="window.location.href = 'http://localhost/baka-app?page=help'"><i
                        class="fas fa-question"></i> Help
            </button>
            <button data-aos="zoom-in" class="btn btn-dark"
                    onclick="window.location.href = 'http://localhost/baka-app?page=visualization'"><i
                        class="fas fa-book-open"></i> Visualization
            </button>
        </div>
    </div>
</div>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include("./views/elem/FooterTemplate.tml.php");
?>

</body>
</html>