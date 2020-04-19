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

</head>
<body>

<!-- Navbar for orirentation in the app -->
<nav aria-label="breadcrumb fixed-top">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="http://localhost/baka-app?page=home"><i class="fas fa-home"></i> Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-book-open"></i> Visualization</li>
    </ol>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <iframe width="933" height="700"
                src="https://app.powerbi.com/view?r=eyJrIjoiZmNmZTk0NDYtNDY0MC00NjQ2LWJjOWQtNzhiOTM0Zjk2Y2RlIiwidCI6IjliZDVjNzY4LTkwYjgtNGU0Zi04NDE2LTE0NzcyOWQ5MWM1MyIsImMiOjl9"
                frameborder="0" allowFullScreen="true"></iframe>
    </div>

</div>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include("./views/elem/FooterTemplate.tml.php");
?>

</body>
</html>