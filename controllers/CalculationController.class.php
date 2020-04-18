<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS . "/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class CalculationController implements IController
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
     * @param $heads        Pole názvů sloupečků.
     * @param $incidents    Pole s daty o incidentech.
     * @return string       Výpis tabulky v šabloně.
     */
    function creteTable(array $heads, array $incidents): string
    {
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

    /**
     * Metoda sloužící pro výběr a výpis tabulky.
     *
     * @param $option   Parametr určující jakou tabulku chceme vypsat.
     * @return string   Výpis tabulky v šabloně.
     */
    function option(int $option): string
    {
        $heads = array("ID", "Name", "SLA Time", "Impact", "Urgency", "Project Phase", "Number of Affective Machines", "Reproductive", "Expected Priority");
        switch ($option) {
            case 1:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating(1);
                break;

            case 2:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating(2);
                break;

            case 3:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating(3);
                break;

            case 4:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating(4);
                break;

            case 5:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating(5);
                break;

            case 6:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating(6);
                break;

            case 7:
                array_push($heads, "Rating", "Priority");
                $incidents = $this->db->incidentsToTableRating(7);
                break;

            default:
                array_push($heads, "Rating 1", "Priority 1", "Rating 2", "Priority 2", "Rating 3", "Priority 3", "Rating 4", "Priority 4", "Rating 5", "Priority 5", "Rating 6", "Priority 6", "Rating 7", "Priority 7");
                $incidents = $this->db->incidentsToTableAll();
        }
        return $this->creteTable($heads, $incidents);
    }

    /**
     * Vratí obsah stránky s metadami.
     *
     * @param string $pageTitle Název stránky.
     * @return string               Výpis v šabloně.
     */
    public function show(string $pageTitle): string
    {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        if (isset($_POST['refresh'])) {
            if ($_POST['refresh'] == true) {
                //TODO
            }
        }

        if (isset($_POST['calculation-method'])) {
            $tplData['table'] = $this->option($_POST['calculation-method']);
        }

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS . "/CalculationTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
}

?>