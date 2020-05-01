<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stránky s grafy.
 */
class ChartsController implements IController {

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
     * Metoda pro získání všech dat pro grafy z databáze.
     *
     * @return array    Pole s výsledky pro grafy.
     */
    function getData():array {
        $urgency = $this->db->numberOfUrgency();
        $impact = $this->db->numberOfImpact();
        $numberOfAffectiveMachine = $this->db->numberOfNumberOfAffectiveMachine();
        $projectPhase = $this->db->numberOfProjectPhase();
        $reproductive = $this->db->numberOfReproductive();
        $expectedPriority = $this->db->numberOfExpectedPriority();
        $priority1 = $this->db->numberOfPriority(1);
        $priority2 = $this->db->numberOfPriority(2);
        $priority3 = $this->db->numberOfPriority(3);
        $priority4 = $this->db->numberOfPriority(4);
        $priority5 = $this->db->numberOfPriority(5);
        $priority6 = $this->db->numberOfPriority(6);
        $priority7 = $this->db->numberOfPriority(7);


        //$dataset = array($urgency[0], $impact[0], $numberOfAffectiveMachine[0], $projectPhase[0], $reproductive[0], $expectedPriority[0], $priority1[0], $priority2[0], $priority3[0]);
        $dataset = array("urgency"=>$urgency[0], "impact"=>$impact[0], "number_of_affective_machine"=>$numberOfAffectiveMachine[0], "project_phase"=>$projectPhase[0],
            "reproductive" =>$reproductive[0], "expected_priority"=>$expectedPriority[0], "priority_method_DN"=>$priority1[0], "priority_method_Roz"=>$priority2[0], "priority_method_Bod"=>$priority3[0], "priority_method_RS"=>$priority4[0], "priority_method_RR"=>$priority5[0], "priority_method_RE"=>$priority6[0], "priority_method_ROC"=>$priority7[0]);

        $values = array();
        foreach ($dataset as $element) {
            array_push($values, array_values($element));
        }

        $elements = array_keys($dataset);

        $keys = array();
        foreach ($dataset as $element) {
            array_push($keys, array_keys($element));
        }

        return (array($values, $keys, $elements));
    }

    /**
     * Vrátí počet incidentů v databázi.
     *
     * @return mixed    Počet incidentů.
     */
    function getCountOfIncedents() {
        $count = $this->db->getCountIncident();
        return $count[0]['COUNT(`id`)'];
    }

    /**
     * Vratí obsah stránky s grafy.
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
        $tplData['count'] = $this->getCountOfIncedents();
        $tplData['data'] = $this->getData();


        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/ChartsTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }
}
?>