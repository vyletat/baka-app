<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class AddController implements IController {

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
     * Funkce sluzici pro nahodne genervani stringu.
     *
     * @param int $length
     * @return string
     *
     * https://stackoverflow.com/questions/4356289/php-random-string-generator
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param int $number
     * @return string
     */
    function generateDateAndNumber(int $number) {
        return date('d-M-Y-H:i') . "#" . $number;
    }

    /**
     * Funkce slouzici pro generovani incidentu s nahodnymi hodnotami.
     *
     * @param int $number
     * @return array
     */
    public function generateRandomIncident(int $number = 1) {
        $incidents = array();
        for ($i = 0; $i < $number; $i++) {
            $incident = array("name"=>$this->generateDateAndNumber($i+1), "sla-time"=>rand(1, 250), "urgency"=>rand(1, 4), "reproductive"=>rand(1, 2), "project-phase"=>rand(1, 6), "number-of-affective-machines"=>rand(1, 5), "impact"=>rand(1, 2));
            array_push($incidents, $incident);
        }
        return $incidents;
    }

    //osetreni
    //1 - zjisteni, jestli jsou v URL
    //2 - osetreni vstupu

    function isSetAllParams() {
        $statement = false;
        //required params
        if (isset($_GET['reproductive']) && isset($_GET['sla-time']) && isset($_GET['urgency']) && isset($_GET['project-phase']) && isset($_GET['umber-of-affective-machines']) && isset($_GET['impact']) && isset($_GET['expected-priority'])) {
            $statement = true;
        }
        return $statement;
    }

    function paramsValidation() {
        if ($this->isSetAllParams()) {
            if (isset($_GET['name'])) {
                $name = $this->test_input($_GET['name']);
                $ok = $this->db->addIncident($_GET['name'], intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            } else {
                $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), intval($_GET['expected-priority']));
            }
            if($ok){
                $status = true;
                $alert = "<i class=\"far fa-laugh\"></i> Incident was successfully added.";
                return array('add_status'=>$status, 'add_alert'=>$alert);
            } else {
                $status = false;
                $alert = "<i class=\"far fa-frown\"></i> Incident was NOT successfully added.";
                //error
                return array('add_status'=>$status, 'add_alert'=>$alert);
            }
        }
        $status = false;
        $alert = "<i class=\"far fa-frown\"></i> Incident was NOT successfully added.";
        //error
        return array('add_status'=>$status, 'add_alert'=>$alert);

    }

    /**
     * @param $data
     * @return string
     *
     * https://www.w3schools.com/php/php_form_validation.asp
     */
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function addAllParams() {
        if (isset($_GET['name'])) {
            $ok = $this->db->addIncident($_GET['name'], intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), 1);
        }else {
            $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), 1);
        }
    }

    /**
     * Vrati obsah uvodni stranky.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        //pro add s konkretnimy hodnotami
        if (isset($_GET['reproductive'])) {
            if (isset($_GET['name'])) {
                $ok = $this->db->addIncident($_GET['name'], intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), 1);
            }else {
                $ok = $this->db->addIncident('', intval($_GET['sla-time']), intval($_GET['urgency']), intval($_GET['reproductive']), intval($_GET['project-phase']), intval($_GET['number-of-affective-machines']), intval($_GET['impact']), 1);
            }
            if($ok){
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
        require(DIRECTORY_VIEWS ."/AddTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>