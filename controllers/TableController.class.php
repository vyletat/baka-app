<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stránky s tabulkou.
 */
class TableController implements IController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
    }

    /**
     * Metoda pro vytvoření tabulky s hodnotami o incidentech.
     *
     * @param $incidents    Pole s daty o incidentech.
     * @return string       Výpis tabulky v šabloně.
     */
    function createTable(array $incidents):string {
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
     *
     *
     * @param string $deteleString
     * @return array
     */
    function splitDelete(string $deteleString):array {
        $idDelete = [];
        $deleteArray = explode(",", $deteleString);
        foreach ($deleteArray as $string) {
            if (strpos($string, '-')) {
                $between = explode(',', $string);
                for ($i = $between[0]; $i <= $between[1]; $i++) {
                    array_push($idDelete, $i);
                }
            }
            array_push($idDelete, $string);
        }
        return $idDelete;
    }

    /**
     * Vratí obsah stránky s tabulkou.
     *
     * @param string $pageTitle     Název stránky.
     * @return string               Výpis v šabloně.
     */
    public function show(string $pageTitle):string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        // data pohadek
        $tplData['urgency'] = $this->db->getUrgency();
        $tplData['impact'] = $this->db->getImpact();
        $incidents = $this->db->incidentsToTable();
        $tplData['table'] = $this->createTable($incidents);

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/TableTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
}
?>