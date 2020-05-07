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
            $incident = array("name" => $this->generateDateAndNumber($i + 1), "sla-time" => rand(1, 7200), "urgency" => rand(1, 4), "reproductive" => rand(1, 2), "project-phase" => rand(1, 6), "number-of-affective-machines" => rand(1, 5), "impact" => rand(1, 2), "expected-priority" => rand(1, 4));
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
    function specificIncident(): array
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
    function generateIncident(): array
    {
        if (isset($_GET['generate-number'])) {
            $incidents = $this->generateRandomIncident($_GET['generate-number']);
            foreach ($incidents as $incident) {
                $ok = $this->db->addIncident($incident['name'], intval($incident['sla-time']), intval($incident['urgency']), intval($incident['reproductive']), intval($incident['project-phase']), intval($incident['number-of-affective-machines']), intval($incident['impact']), intval($incident['expected-priority']));
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

        //pro add s generovanim
        if (isset($_GET['generate-number'])) {
            $incidents = $this->generateRandomIncident($_GET['generate-number']);
            foreach ($incidents as $incident) {
                $ok = $this->db->addIncident($incident['name'], intval($incident['sla-time']), intval($incident['urgency']), intval($incident['reproductive']), intval($incident['project-phase']), intval($incident['number-of-affective-machines']), intval($incident['impact']), intval($incident['expected-priority']));
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