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

    //-------------------------------------------- START OF CALCULATION ------------------------------------------------

    /**
     * Hlavní metoda pro výpočet ohodnocení incidentu.
     *
     * @param int $method Metoda, podle které se bude počítat.
     * @param int $sla_time SLA čas
     * @param int $urgency Naléhavost
     * @param int $reproductive Reprodukovatelnost
     * @param int $project_phase Projektová fáze
     * @param int $number_of_affective_machines Počet ovlivněných strojů
     * @param int $impact Dopad
     * @return int|mixed                            normalizované ohodnocení
     */
    function calculateIncident(int $method, $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_affective_machines, int $impact)
    {
        // Získání parametrů metody, podle které se bude počítat.
        $options = $this->file->getMethodParams($method);
        $values = array();
        // Výpočet kritérií a jejich atributů.
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
                        break;
                }
            }
        }

        // Nastavení jestli se bude sčítat nebo násobit.
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

        // Normalizování výsledku.
        if ($options['priority']['normalize'] == true) {
            $normalizeResult = ($result - $options['priority']['min']) / ($options['priority']['max'] - $options['priority']['min']);
            $result = floatval($normalizeResult);
        }
        return floatval($result);
    }

    /**
     * Metoda pro výpočet SLA času.
     *
     * @param $sla_time     Hodnota v intervalu <0; 1>.
     * @param $weight       Váha SLA krotéria šas.
     * @return float|int    Vážená hodnota kritéria SLA času.
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
     * Metoda vrací podle nastavení metody a ohodnocení prioritu incidentu.
     *
     * @param int $method Metoda, podle které chcete určit prioritu.
     * @param $rating       Ohodnocení incidentu.
     * @return int          Číslo priority incedentu.
     */
    function calculatePriority(int $method, $rating)
    {
        // Získání parametrů metody, podle které se bude počítat.
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
        $allIncidents = $this->db->getIncidents();
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
     * Funkce sloužící pro náhodné generování stringu.
     * @param int $length Délka řetězce, který chcete vygenerovat.
     * @return string       Vygenerovaný řetězec.
     *
     * https://stackoverflow.com/questions/4356289/php-random-string-generator
     * @deprecated Tuto metodu nahradila metoda @method generateDateAndNumber
     *
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
            $incident = array("name" => $this->generateDateAndNumber($i + 1), "sla-time" => rand(1, 7200), "urgency" => rand(1, 4), "reproductive" => rand(1, 2), "project-phase" => rand(1, 6), "number-of-affective-machines" => rand(1, 5), "impact" => rand(1, 2));
            array_push($incidents, $incident);
        }
        return $incidents;
    }

    /**
     * Metoda pro ověření, jestli jsou zdány všechny požadované parametry incidentu.
     *
     * @return bool     Vrátí true/false podle výsledku.
     */
    function isSetAllParams(): bool
    {
        $statement = false;
        //required params
        if (isset($_GET['reproductive']) && isset($_GET['sla-time']) && isset($_GET['urgency']) && isset($_GET['project-phase']) && isset($_GET['number-of-affective-machines']) && isset($_GET['impact']) && isset($_GET['expected-priority'])) {
            $statement = true;
        }
        return $statement;
    }

    /**
     * Metoda pro vytvoření konkrétního incidentu s validací vstupních hodnot a vytvořením alertu.
     *
     * @deprecated Metoda neni pouzivana z důvodu naplnění dat do tpldata.
     *
     * @return array    Vrátí pole se statusem pro alerty.
     */
    function specificIncident()
    {
        if ($this->isSetAllParams()) {
            if (isset($_GET['name'])) {
                $name = $this->testInput($_GET['name']);
                $ok = $this->db->addIncident($name, intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            } else {
                $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            }
            if ($ok) {
                $status = true;
                $alert = "<i class=\"far fa-laugh\"></i> Incident was successfully added.";
            } else {
                $status = false;
                $alert = "<i class=\"far fa-frown\"></i> Incident was NOT successfully added.";
            }
            $this->updateAllMethodsAndPriority();
            return array('add_status' => $status, 'add_alert' => $alert);
        }
    }

    /**
     * Metoda pro přidani generovanych incidentua vytvořením alertu.
     *
     * @deprecated Metoda neni pouzivana z důvodu naplnění dat do tpldata.
     *
     * @return array    Vrátí pole se statusem pro alerty.
     */
    function generateIncident()
    {
        if (isset($_GET['generate-number'])) {
            $incidents = $this->generateRandomIncident($_GET['generate-number']);
            foreach ($incidents as $incident) {
                $ok = $this->db->addIncident($incident['name'], intval($incident['sla-time']), intval($incident['urgency']), intval($incident['reproductive']), intval($incident['project-phase']), intval($incident['number-of-affective-machines']), intval($incident['impact']), 1);
                if ($ok) {
                    $status = true;
                    $alert = "<i class=\"far fa-laugh\"></i> <strong>" . $_GET['generate-number'] . "</strong> incedents was successfully added.";
                    continue;
                } else {
                    $status = false;
                    $alert = "<i class=\"far fa-frown\"></i> Incidents was NOT successfully added.";
                    break;
                }
            }
            $this->updateAllMethodsAndPriority();
            return array('add_status' => $status, 'add_alert' => $alert);
        }

    }

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
     * Vratí obsah uvodní stránky.
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

        //pro add s konkretnimy hodnotami
        if ($this->isSetAllParams()) {
            if (isset($_GET['name'])) {
                $name = $this->testInput($_GET['name']);
                $ok = $this->db->addIncident($name, intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
                $lastId = $this->db->getLastId();
                $this->cal->calculateOneIncident(intval($lastId[0]['MAX(`id`)']));
            } else {
                $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
                $lastId = $this->db->getLastId();
                $this->cal->calculateOneIncident(intval($lastId[0]['MAX(`id`)']));
            }
            if ($ok) {
                $tplData['add_status'] = true;
                $tplData['add_alert'] = "<i class=\"far fa-laugh\"></i> Incident was successfully added.";
            } else {
                $tplData['add_status'] = false;
                $tplData['add_alert'] = "<i class=\"far fa-frown\"></i> Incident was NOT successfully added.";
            }
        }

        /*// Pridani konkretniho incidentu
        $specificAlert = $this->specificIncident();
        foreach ($specificAlert as $key => $value) {
            $tplData[$key] = $value;
        }

        // Pridani generovaneho incidentu
        $generateIncident = $this->generateIncident();
        foreach ($generateIncident as $key => $value) {
            $tplData[$key] = $value;
        }*/

        //pro add s generovanim
        if (isset($_GET['generate-number'])) {
            $incidents = $this->generateRandomIncident($_GET['generate-number']);
            foreach ($incidents as $incident) {
                $ok = $this->db->addIncident($incident['name'], intval($incident['sla-time']), intval($incident['urgency']), intval($incident['reproductive']), intval($incident['project-phase']), intval($incident['number-of-affective-machines']), intval($incident['impact']), 1);
                $lastId = $this->db->getLastId();
                $this->cal->calculateOneIncident(intval($lastId[0]['MAX(`id`)']));
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