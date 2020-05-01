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
        <li class="breadcrumb-item active" aria-current="page">Incidents calculation</li>
    </ol>
</nav>
<div class="container">
    <h1>Calculation methods</h1>
    <div class="row">
        <div class="col-sm-1">
            <button class="btn btn-success" style="height: 100%"
                    onclick="window.location.href = '?page=add'"><i
                        class="fas fa-arrow-left"></i></button>
        </div>
        <div class="col-sm-5">
            <form method="post" action="">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="all-radio" value="0"
                           checked>
                    <label class="form-check-label" for="all-radio">All methods</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="first-radio" value="1">
                    <label class="form-check-label" for="first-radio">Diebold Nixdorf default method</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="second-radio" value="2">
                    <label class="form-check-label" for="second-radio">Method rozsirena</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="third-radio" value="3">
                    <label class="form-check-label" for="third-radio">Method bodovaci</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="forth-radio" value="4">
                    <label class="form-check-label" for="forth-radio">Method rank sum</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="fifth-radio" value="5">
                    <label class="form-check-label" for="fifth-radio">Method rank reciprocal</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="sixth-radio" value="6">
                    <label class="form-check-label" for="sixth-radio">Method rank exponent</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="calculation-method" id="seventh-radio" value="7">
                    <label class="form-check-label" for="seventh-radio">Method rank order centroid</label>
                </div>
                <button type="submit" class="btn btn-primary col-sm-3" id="submit-method"><i class="far fa-eye"></i>
                    Choose
                </button>
            </form>
        </div>
        <div class="col-sm-5 align-self-center">
            <div class="clo-sm-6">
                <form action="" method="post">
                    <input type="hidden" name="page" value="methods"/>
                    <input type="hidden" value="true" name="refresh">
                    <button type="submit" class="btn btn-warning button-calculation"><i class="fas fa-redo-alt"></i> Recalculate incidents
                    </button>
                </form>
            </div>
            <div class="clo-sm-6">
                <form action="" method="post">
                    <input type="hidden" name="page" value="methods"/>
                    <input type="hidden" value="xls" name="download">
                    <button type="submit" class="btn btn-info button-calculation"><i class="fas fa-file-excel"></i> Download excel sheet
                    </button>
                </form>
            </div>
        </div>
        <div class="col-sm-1">
            <button class="btn btn-danger" style="height: 100%"
                    onclick="window.location.href = '?page=charts'"><i
                        class="fas fa-arrow-right"></i></button>
        </div>
    </div>


    <h1 id="h1-result-table">Table with results</h1>
    <!-- Vypsani tabulky s daty -->
    <?php
    if (array_key_exists('table', $tplData)) {
        echo $tplData['table'];
    } else {
    ?>
        <p>Choose one option bellow for the table of results.</p>
    <?php
    }
    ?>

    <!-- Script pro nacteni scrollX pro tabulku -->
    <script>
        $(document).ready(function () {
            $('#table-methods').DataTable({
                "scrollX": true
            });
        });
    </script>
</div>
</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include("./views/elem/FooterTemplate.tml.php");
?>
</html>