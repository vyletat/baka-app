<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS . "/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stránky s přidáním incidentů.
 */
class AddController implements IController
{

    /** @var MyDatabase $db Sprava databaze. */
    private $db;

    /** @var MyFileHandler $file Sprava souboru. */
    private $file;

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
    }

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
    function calculateIncident(int $method, int $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_affective_machines, int $impact)
    {
        $options = $this->file->getMethodParams($method);
        //return $options;
        $values = array();
        foreach ($options['criteria'] as $criterion_name => $criterion) {
            if ($criterion['contains'] == true) {
                switch ($criterion_name) {
                    case "sla_time":
                        $val_sla_time = $criterion['weight'] * $sla_time;
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
        $result = 0;
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
        if ($options['priority']['normalize']) {
            $normalizeResult = ($result - $options['priority']['min']) / ($options['priority']['max'] - $options['priority']['min']);
            $result = $normalizeResult;
        }
        return $result;
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
        switch ($options['priority']['method']) {
            case "min":
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

    //Funkce aktulizuje u všech incidentů v databázi vypočítaný rating a priority
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

    /**
     * Funkce sloužící pro náhodné generování stringu.
     *
     * @param int $length Délka řetězce, který chcete vygenerovat.
     * @return string       Vygenerovaný řetězec.
     *
     * https://stackoverflow.com/questions/4356289/php-random-string-generator
     */
    function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Metoda pro generování současného času s pořadovým číslem.
     *
     * @param int $number Pořadové číslo, které se vypíše vedle času.
     * @return string       Řetězec s datumem a pořadovým číslem.
     */
    function generateDateAndNumber(int $number = 1): string
    {
        return date('d-M-Y-H:i') . "#" . $number;
    }

    /**
     * Funkce sloužící pro generování incidentu s náhodnými hodnotami.
     *
     * @param int $number Počet incidentů, kolik se jich má vygenerovat.
     * @return array        Pole s vygenerovanými incidenty.
     */
    public function generateRandomIncident(int $number = 1): array
    {
        $incidents = array();
        for ($i = 0; $i < $number; $i++) {
            $incident = array("name" => $this->generateDateAndNumber($i + 1), "sla-time" => rand(1, 250), "urgency" => rand(1, 4), "reproductive" => rand(1, 2), "project-phase" => rand(1, 6), "number-of-affective-machines" => rand(1, 5), "impact" => rand(1, 2));
            array_push($incidents, $incident);
        }
        return $incidents;
    }

    //osetreni
    //1 - zjisteni, jestli jsou v URL
    //2 - osetreni vstupu
    /**
     *
     *
     * @return bool
     */
    function isSetAllParams(): bool
    {
        $statement = false;
        //required params
        if (isset($_GET['reproductive']) && isset($_GET['sla-time']) && isset($_GET['urgency']) && isset($_GET['project-phase']) && isset($_GET['umber-of-affective-machines']) && isset($_GET['impact']) && isset($_GET['expected-priority'])) {
            $statement = true;
        }
        return $statement;
    }

    /**
     *
     *
     * @return array
     */
    function paramsValidation(): array
    {
        if ($this->isSetAllParams()) {
            if (isset($_GET['name'])) {
                $name = $this->testInput($_GET['name']);
                $ok = $this->db->addIncident($_GET['name'], intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            } else {
                $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            }
            if ($ok) {
                $status = true;
                $alert = "<i class=\"far fa-laugh\"></i> Incident was successfully added.";
                return array('add_status' => $status, 'add_alert' => $alert);
            } else {
                $status = false;
                $alert = "<i class=\"far fa-frown\"></i> Incident was NOT successfully added.";
                //error
                return array('add_status' => $status, 'add_alert' => $alert);
            }
        }
        $status = false;
        $alert = "<i class=\"far fa-frown\"></i> Incident was NOT successfully added.";
        //error
        return array('add_status' => $status, 'add_alert' => $alert);

    }

    /**
     * Metoda pro ošetření textových vstupních dat.
     *
     * @param string $data Neošetřená data.
     * @return string       Řetězec očetřených dat.
     *
     * https://www.w3schools.com/php/php_form_validation.asp
     */
    function testInput(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     *
     */
    function addAllParams()
    {
        if (isset($_GET['name'])) {
            $ok = $this->db->addIncident($_GET['name'], intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
        } else {
            $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
        }
    }

    /**
     * Vratí obsah uvodní stránky.
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

        // $tplData['values'] = $this->calculateIncident(1, 2, 1, 1, 1, 1, 1);
        // $rating = $this->calculateIncident(1, 2, 2, 1, 1, 3, 2);
        //$tplData['priority'] = $this->calculatePriority(1, $rating);
        // $tplData['dataAll'] = $this->updateAllMethodsAndPriority();

        //pro add s konkretnimy hodnotami
        if (isset($_GET['reproductive'])) {
            if (isset($_GET['name'])) {
                $ok = $this->db->addIncident($_GET['name'], intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            } else {
                $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            }
            if ($ok) {
                $tplData['add_status'] = true;
                $tplData['add_alert'] = "<i class=\"far fa-laugh\"></i> Incident was successfully added.";
            } else {
                $tplData['add_status'] = false;
                $tplData['add_alert'] = "<i class=\"far fa-frown\"></i> Incident was NOT successfully added.";
            }
        }

        /*$add = $this->paramsValidation();
        $tplData['add_status'] = $add['add_status'];
        $tplData['add_alert'] = $add['add_alert'];*/

        //pro add s generovanim
        if (isset($_GET['generate-number'])) {
            $incidents = $this->generateRandomIncident($_GET['generate-number']);
            foreach ($incidents as $incident) {
                //TODO udelat metodu pro add bez expected
                $ok = $this->db->addIncident($incident['name'], intval($incident['sla-time']), intval($incident['urgency']), intval($incident['reproductive']), intval($incident['project-phase']), intval($incident['number-of-affective-machines']), intval($incident['impact']), 1);
                if ($ok) {
                    $tplData['add_generate_status'] = true;
                    $tplData['add_generate_alert'] = "<i class=\"far fa-laugh\"></i> <strong>" . $_GET['generate-number'] . "</strong> incedents was successfully added.";
                    continue;
                } else {
                    $tplData['add_generate_status'] = false;
                    $tplData['add_generate_alert'] = "<i class=\"far fa-frown\"></i> Incidents was NOT successfully added.";
                    break;
                }
            }
        }

        // vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS . "/AddTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>