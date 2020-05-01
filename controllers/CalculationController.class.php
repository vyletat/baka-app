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

    /** @var MyFileHandler $file Sprava souboru. */
    private $xml;

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

        // inicializace prace se souborem
        require_once(DIRECTORY_MODELS . "/ExportXLS.php");
        $this->xml = new ExportXLS();
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

    //-------------------------------------------- START OF CALCULATION ------------------------------------------------

    /**
     *
     *
     * @param int $method
     * @param int $sla_time
     * @param int $urgency
     * @param int $reproductive
     * @param int $project_phase
     * @param int $number_of_affective_machines
     * @param int $impact
     * @return int|mixed
     */
    function calculateIncident(int $method, $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_affective_machines, int $impact)
    {
        $options = $this->file->getMethodParams($method);
        //return $options;
        $values = array();
        foreach ($options['criteria'] as $criterion_name => $criterion) {
            if ($criterion['contains'] == true) {
                switch ($criterion_name) {
                    case "sla_time":
                        $val_sla_time = $this->calculateSlaTime($sla_time, $criterion['weight']);
                        array_push($values, $val_sla_time);
                        break;

                    case "urgency":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $urgency; $i++) {
                            $val_urgency = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_urgency);
                        break;

                    case "reproducibility":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $reproductive; $i++) {
                            $val_reproductive = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_reproductive);
                        break;

                    case "project_phase":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $project_phase; $i++) {
                            $val_project_phase = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_project_phase);
                        break;

                    case "number_of_affective_machines":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $number_of_affective_machines; $i++) {
                            $val_number_of_affective_machines = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_number_of_affective_machines);
                        break;

                    case "impact":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $impact; $i++) {
                            $val_impact = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_impact);
                        break;

                    default:

                }
            }
        }
        //metoda
        $result = 0.0;
        switch ($options['other']['method']) {
            case "multiply":
                foreach ($values as $value) {
                    $result *= $value;
                }
                break;

            case "sum":
                foreach ($values as $value) {
                    $result += $value;
                }
                break;
        }

        //normalize
        if ($options['priority']['normalize'] == true) {
            $normalizeResult = ($result - $options['priority']['min']) / ($options['priority']['max'] - $options['priority']['min']);
            $result = floatval($normalizeResult);
        }
        return floatval($result);
    }

    /**
     *
     *
     * @param $sla_time
     * @param $weight
     * @return float|int
     */
    function calculateSlaTime($sla_time, $weight)
    {
        $max = 4230.0;
        $value = 0.0;
        if ($sla_time > $max) {
            $value = 0.0;
        } else {
            $value = ($max - $sla_time) / $max;
        }
        return ($value * $weight);
    }

    /**
     *
     *
     * @param int $method
     * @param $rating
     * @return int
     */
    function calculatePriority(int $method, $rating)
    {
        $options = $this->file->getMethodParams($method);
        switch ($options['priority']['order']) {
            case "asc":
                if ($rating < $options['priority']['scale']['very_high']) {
                    return 1;
                } else {
                    if ($rating < $options['priority']['scale']['high']) {
                        return 2;
                    } else {
                        if ($rating < $options['priority']['scale']['medium']) {
                            return 3;
                        } else {
                            return 4;
                        }
                    }
                }

            //max
            default:
                if ($rating > $options['priority']['scale']['high']) {
                    return 1;
                } else {
                    if ($rating > $options['priority']['scale']['medium']) {
                        return 2;
                    } else {
                        if ($rating > $options['priority']['scale']['low']) {
                            return 3;
                        } else {
                            return 4;
                        }
                    }
                }
        }
    }

    /**
     * Funkce aktulizuje u všech incidentů v databázi vypočítaný rating a priority.
     */
    function updateAllMethodsAndPriority()
    {
        $allIncidents = $this->db->getIncident();
        foreach ($allIncidents as $incident) {
            foreach (ALL_METHODS as $method) {
                $rating = $this->calculateIncident($method, $incident['sla_time'], $incident['urgency'], $incident['reproductive'], $incident['project_phase'], $incident['number_of_effective_machines'], $incident['impact']);
                $priority = $this->calculatePriority($method, $rating);
                $this->db->updateRatingAndPriority($incident['id'], $method, $rating, $priority);
            }
        }
    }

    //---------------------------------------------- END OF CALCULATION ------------------------------------------------

    /**
     * Metoda pro vygenerování a stažení XLS souboru.
     *
     * @param $array    Pole s parametry.
     */
    function downloadXls($array)
    {
        // https://stackoverflow.com/questions/10424847/export-an-array-of-arrays-to-excel-in-php
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
     * @param string $pageTitle     Název stránky.
     * @return string               Výpis v šabloně.
     */
    public function show(string $pageTitle): string
    {

        if (isset($_POST['download'])) {
            if ($_POST['download'] == "xls") {
                $headerArray = array('id', 'name', 'sla_time', 'urgency', 'reproductive', 'project_phase', 'number_of_effective_machines', 'impact', 'expected_priority', 'priority_1', 'priority_2', 'priority_3', 'priority_4', 'priority_5', 'priority_6', 'priority_7', 'priority_1_rating', 'priority_2_rating', 'priority_3_rating', 'priority_4_rating', 'priority_5_rating', 'priority_6_rating', 'priority_7_rating');
                $arrayIncidents = $this->db->getIncident();
                $array = array();
                array_push($array, $headerArray);
                //$headerArray array(`id`, `name`, `sla_time`, `urgency`, `reproductive`, `project_phase`, `number_of_effective_machines`, `impact`, `expected_priority`, `priority_1`, `priority_2`, `priority_3`, `priority_4`, `priority_5`, `priority_6`, `priority_7`, `priority_1_rating`, `priority_2_rating`, `priority_3_rating`, `priority_4_rating`, `priority_5_rating`, `priority_6_rating`, `priority_7_rating`));
                //array_push($array, ($this->db->getIncident()));
                /*$this->xml->setParams("Incidents.xls", $headerArray, $this->db->getIncident());
                $this->xml->sendFile();*/
                foreach ($arrayIncidents as $row) {
                    array_push($array, $row);
                }
                $this->downloadXls($array);
            }
        }

        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        if (isset($_POST['refresh'])) {
            if ($_POST['refresh'] == true) {
                $this->updateAllMethodsAndPriority();
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