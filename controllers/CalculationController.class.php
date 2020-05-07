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

    /** @var MyFileHandler $file Sprava souboru. */
    private $file;

    /** @var @MyCalculation $cal Sprava kalkulaci. */
    private $cal;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct()
    {
        // inicializace prace s DB
        require_once(DIRECTORY_MODELS . "/MyDatabase.class.php");
        $this->db = new MyDatabase();

        // inicializace prace se souborem
        require_once(DIRECTORY_MODELS . "/MyFileHandler.class.php");
        $this->file = new MyFileHandler();

        //inicializace kalkulaci
        require_once(DIRECTORY_MODELS . "/MyCalculation.class.php");
        $this->cal = new MyCalculation();
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

            default:
                array_push($heads, "Rating 1", "Priority 1", "Rating 2", "Priority 2", "Rating 3", "Priority 3", "Rating 4", "Priority 4", "Rating 5", "Priority 5");
                $incidents = $this->db->incidentsToTableAll();
        }
        return $this->creteTable($heads, $incidents);
    }

    /**
     * Metoda pro vygenerování a stažení XLS souboru.
     *
     * @param array $array    Pole s parametry.
     *
     * @link https://stackoverflow.com/questions/10424847/export-an-array-of-arrays-to-excel-in-php
     */
    function downloadXls($array)
    {
        header("Content-Disposition: attachment; filename=\"INCIDENTS.xls\"");
        header("Content-Type: application/vnd.ms-excel;");
        header("Pragma: no-cache");
        header("Expires: 0");
        $out = fopen("php://output", 'w');
        foreach ($array as $data) {
            fputcsv($out, $data, "\t");
        }
        fclose($out);
    }

    /**
     * Vratí obsah stránky s metadami.
     *
     * @param string $pageTitle Název stránky.
     * @return string               Výpis v šabloně.
     */
    public function show(string $pageTitle): string
    {

        if (isset($_POST['download'])) {
            if ($_POST['download'] == "xls") {
                $headerArray = array('id', 'name', 'sla_time', 'urgency', 'reproductive', 'project_phase', 'number_of_effective_machines', 'impact', 'expected_priority', 'priority_1', 'priority_2', 'priority_3', 'priority_4', 'priority_5', 'priority_1_rating', 'priority_2_rating', 'priority_3_rating', 'priority_4_rating', 'priority_5_rating');
                $arrayIncidents = $this->db->getIncidents();
                $array = array();
                array_push($array, $headerArray);
                foreach ($arrayIncidents as $row) {
                    array_push($array, $row);
                }
                $this->downloadXls($array);
            }
        }

        // vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        if (isset($_POST['refresh'])) {
            if ($_POST['refresh'] == true) {
                $this->cal->updateAllMethodsAndPriority();
            }
        }

        if (isset($_POST['calculation-method'])) {
            $tplData['table'] = $this->option($_POST['calculation-method']);
        }

        // vypsani prislusne sablony
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