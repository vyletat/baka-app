<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////

/** Adresa serveru. */
define("DB_SERVER","localhost"); // https://students.kiv.zcu.cz
/** Nazev databaze. */
define("DB_NAME","baka-database");
/** Uzivatel databaze. */
define("DB_USER","root");
/** Heslo uzivatele databaze */
define("DB_PASS","");


//// Nazvy tabulek v DB ////

/** Tabulky s daty. */
define("TABLE_INCIDENT", "incident");
define("TABLE_URGENCY", "urgency");
define("TABLE_IMPACT", "impact");
define("TABLE_PROJECT_PHASE", "project_phase");
define("TABLE_NUMBER_OF_AFFECTIVE_MACHINES", "number_of_affective_machines");
define("TABLE_REPRODUCTIVE", "reproductive");
define("TABLE_PRIORITY", "priority");


//// Dostupne stranky webu ////

/** Adresar kontroleru. */
const DIRECTORY_CONTROLLERS = "./controllers";
/** Adresar modelu. */
const DIRECTORY_MODELS = "./models";
/** Adresar sablon */
const DIRECTORY_VIEWS = "./views";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    "home" => array(
        "file_name" => "HomeController.class.php",
        "class_name" => "HomeController",
        "title" => "Prioritization · Home",
        "name" => "Home"
    ),
    "add" => array(
        "file_name" => "AddController.class.php",
        "class_name" => "AddController",
        "title" => "Prioritization · Add",
        "name" => "Add incidents"
    ),
    "table" => array(
        "file_name" => "TableController.class.php",
        "class_name" => "TableController",
        "title" => "Prioritization · Table",
        "name" => "incidents Table"
    ),
    "methods" => array(
        "file_name" => "MethodsController.class.php",
        "class_name" => "MethodsController",
        "title" => "Prioritization · Methods",
        "name" => "Calculation methods"
    ),
    "charts" => array(
        "file_name" => "ChartsController.class.php",
        "class_name" => "ChartsController",
        "title" => "Prioritization · Charts",
        "name" => "Charts"
    ),
    "help" => array(
        "file_name" => "HelpController.class.php",
        "class_name" => "HelpController",
        "title" => "Prioritization · Help",
        "name" => "Help"
    ),
    "visualization" => array(
        "file_name" => "VisualizationController.class.php",
        "class_name" => "VisualizationController",
        "title" => "Prioritization · Visualization",
        "name" => "Help"
    )
    // TODO - doplnit spravu uzivatelu
);

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "home";

?>