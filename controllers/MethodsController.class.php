<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class MethodsController implements IController {


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
     * @param $heads
     * @param $incidents
     * @return string
     */
    function creteTable($heads, $incidents) {
        $table = "<table id='table-methods' class=\"table table-striped\"><thead class=\"thead-dark\"><tr>";
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

    function option($option) {
        $heads = array("ID", "Name", "SLA Time", "Impact", "Urgency", "Project Phase", "Number of Affective Machines", "Reproductive", "Expected Priority");
        switch ($option) {
            case 1:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating1();
                break;

            case 2:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating2();
                break;

            case 3:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating3();
                break;

            default:
                array_push($heads, "Rating 1", "Priority 1", "Rating 2", "Priority 2", "Rating 3", "Priority 3");
                $incidents = $this->db->incidentsToTableAll();
        }
        return $this->creteTable($heads, $incidents);
    }

    public function show(string $pageTitle):string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        if (isset($_POST['calculation-method'])) {
            $tplData['table'] = $this->option($_POST['calculation-method']);
        }

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/CalculationTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
}
?>