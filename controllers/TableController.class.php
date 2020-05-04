<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS . "/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stránky s tabulkou.
 */
class TableController implements IController
{

    /** @var DatabaseModel $db Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct()
    {
        // inicializace prace s DB
        require_once(DIRECTORY_MODELS . "/MyDatabase.class.php");
        $this->db = new MyDatabase();
    }

    /**
     * Metoda pro vytvoření tabulky s hodnotami o incidentech.
     *
     * @param $incidents    Pole s daty o incidentech.
     * @return string       Výpis tabulky v šabloně.
     */
    function createTable(array $incidents): string
    {
        $heads = array("ID", "Name", "SLA Time", "Impact", "Urgency", "Project Phase", "Number of Affective Machines", "Reproductive", "Expected Priority");
        $table = "<table id='table-incidents' class=\"table table-striped\"><thead class=\"thead-dark\"><tr>";
        foreach ($heads as $head) {
            $table .= "<th>$head</th>";
        }
        $table .= "</tr></thead>";
        foreach ($incidents as $incident) {
            $table .= "<tr>";
            foreach ($incident as $element) {
                $table .= "<td>$element</td>";
            }
            $table .= "</tr>";
        }
        $table .= "</table>";
        return $table;
    }

    /**
     * Funkce pro odstraneni vsech zvolených incidentů.
     *
     * @param $arrayId  Pole s ID incidentu ke smazani.
     * @return bool     True, pokud je delete v databázi ok, jinak false.
     */
    function deleteIncidents($arrayId)
    {
        foreach ($arrayId as $id) {
            $ok = $this->db->deleteIncident($id);
            if ($ok == false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Funkce pro rozdělení a získání všech ID ze zadaného řetězce pro smazání incidentů z databáze.
     *
     * @param string $deteleString Řetězec s příkazy.
     * @return array                    Pole s ID pro smazání.
     */
    function splitDelete(string $deteleString): array
    {
        $idDelete = array();
        $deleteArray = explode(",", $deteleString);
        foreach ($deleteArray as $string) {
            if (strpos($string, '-')) {
                $between = explode('-', $string);
                for ($i = $between[0]; $i <= $between[1]; $i++) {
                    array_push($idDelete, $i);
                }
                continue;
            }
            array_push($idDelete, $string);
        }
        return $idDelete;
    }

    //TODO osetreni vstupu

    /**
     * Metoda pro ošetření textových vstupních dat.
     *
     * @param string $data Neošetřená data.
     * @return string       Řetězec očetřených dat.
     *
     * @link https://www.w3schools.com/php/php_form_validation.asp
     */
    function testInput(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Vratí obsah stránky s tabulkou.
     *
     * @param string $pageTitle Název stránky.
     * @return string               Výpis v šabloně.
     */
    public function show(string $pageTitle): string
    {
        // vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        //Odstraneni incidentu s alertem
        if (isset($_POST['delete'])) {
            $tplData['delete'] = $_POST['delete'];
            $tplData['split'] = $this->splitDelete($_POST['delete']);
            $ok = $this->deleteIncidents($this->splitDelete($_POST['delete']));
            $tplData['split2'] = $ok;
            if ($ok) {
                $tplData['delete_status'] = true;
                $tplData['delete_alert'] = "<i class=\"far fa-laugh\"></i> Incident(s) was successfully DELETE.";
            } else {
                $tplData['delete_status'] = false;
                $tplData['delete_alert'] = "<i class=\"far fa-frown\"></i> Incident(s) was NOT successfully DELETE.";
            }
        }

        $incidents = $this->db->incidentsToTable();
        $tplData['table'] = $this->createTable($incidents);

        // vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS . "/TableTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
}

?>