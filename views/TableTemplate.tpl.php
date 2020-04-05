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
        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-table"></i> Incidents Table</li>
    </ol>
</nav>

    <div class="container">
        <h1>Incidents table</h1>
        <!-- Vypsani tabulky s daty -->
        <?php
        if(array_key_exists('table', $tplData)) {
            echo $tplData['table'];
        }
        ?>

        <!-- Script pro nacteni scrollX pro tabulku -->
        <script>
            $(document).ready( function () {
                $('#table-incidents').DataTable();
            } );
        </script>

        <!--TODO-->
        <fieldset>
            <legend>Delete incident</legend>
            <form action="" method="post">
                <input type="hidden" name="page" value="table" />
                <div class="form-group">
                    <label for="delete">ID´s of incidents you want delete</label>
                    <input type="text" class="form-control" id="delete" placeholder="" name="delete">
                    <small class="form-text text-muted">ID slip with ","; range with "-"</small>
                </div>
            </form>
        </fieldset>
    </div>

</body>

<!-- Nacteni sablony se zápatím stránky. -->
<?php
include ("./views/elem/FooterTemplate.tml.php");
?>
</html>