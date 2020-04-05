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
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="http://localhost/baka-app?page=home"><i class="fas fa-home"></i> Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Incidents calculation</li>
    </ol>
</nav>
<div class="container">
    <h1>Calculation methods</h1>
    <form method="post" action="">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="calculation-method" id="all-radio" value="4" checked>
            <label class="form-check-label" for="all-radio">All methods</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="calculation-method" id="first-radio" value="1">
            <label class="form-check-label" for="first-radio">First method</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="calculation-method" id="second-radio" value="2">
            <label class="form-check-label" for="second-radio">Second method</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="calculation-method" id="third-radio" value="3">
            <label class="form-check-label" for="third-radio">Third method</label>
        </div>
        <button type="submit" class="btn btn-primary col-sm-3" id="submit-method"><i class="far fa-eye"></i> Choose</button>
    </form>

    <h1 id="h1-result-table">Table with results</h1>
    <!-- Vypsani tabulky s daty -->
    <?php
    if(array_key_exists('table', $tplData)) {
        echo $tplData['table'];
    }
    ?>

    <!-- Script pro nacteni scrollX pro tabulku -->
    <script>
        $(document).ready( function () {
            $('#table-methods').DataTable({
                "scrollX": true
            });
        } );
    </script>
</div>
</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include ("./views/elem/FooterTemplate.tml.php");
?>
</html>