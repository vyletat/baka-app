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
        <li class="breadcrumb-item"><a href="?page=home"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-table"></i> Incidents Table</li>
    </ol>
</nav>

<div class="container">

    <h1>Incidents table</h1>
    <div class="row">
        <div class="col-sm-1">
            <button class="btn btn-success" style="height: 50%"
                    onclick="window.location.href = '?page=add'"><i
                        class="fas fa-arrow-left"></i></button>
        </div>
        <div class="col-sm-10">
            <!-- Vypsani tabulky s daty -->
            <?php
            if (array_key_exists('table', $tplData)) {
                echo $tplData['table'];
            }
            ?>
        </div>
        <div class="col-sm-1">
            <button class="btn btn-warning" style="height: 50%"
                    onclick="window.location.href = '?page=methods'"><i
                        class="fas fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- Script pro nacteni scrollX pro tabulku -->
    <script>
        $(document).ready(function () {
            $('#table-incidents').DataTable();
        });
    </script>

    <!--TODO-->
    <fieldset id="fieldset-delete">
        <legend>Delete incident</legend>
        <form action="" method="post">
            <input type="hidden" name="page" value="table"/>
            <div class="form-group">
                <label for="delete">ID´s of incidents you want delete</label>
                <input type="text" class="form-control" id="delete" placeholder="" name="delete">
                <small class="form-text text-muted">ID slip with ","; range with "-"</small>
                <button class="btn btn-danger" type="submit"><i class="fas fa-minus-circle"></i> Delete</button>
            </div>
        </form>
    </fieldset>

    <!-- Zobrazeni alertu o stavu formulare -->
    <?php
    if (isset($tplData['delete_status'])) {
        if ($tplData['delete_status'] == true) {
            echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                $tplData[delete_alert]
                 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
                 </button>
                </div>";
        }
        if ($tplData['delete_status'] == false) {
            echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                $tplData[delete_alert]
                 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
                 </button>
                </div>";
        }
    }
    ?>
</div>
</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include("./views/elem/FooterTemplate.tml.php");
?>
</html>