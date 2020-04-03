<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
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
     * @return array
     */
    function getData() {
        $urgency = $this->db->numberOfUrgency();
        $impact = $this->db->numberOfImpact();
        $numberOfAffectiveMachine = $this->db->numberOfNumberOfAffectiveMachine();
        $projectPhase = $this->db->numberOfProjectPhase();
        $reproductive = $this->db->numberOfReproductive();
        $expectedPriority = $this->db->numberOfExpectedPriority();
        $priority1 = $this->db->numberOfPriority1();
        $priority2 = $this->db->numberOfPriority2();
        $priority3 = $this->db->numberOfPriority3();

        //$dataset = array($urgency[0], $impact[0], $numberOfAffectiveMachine[0], $projectPhase[0], $reproductive[0], $expectedPriority[0], $priority1[0], $priority2[0], $priority3[0]);
        $dataset = array("urgency"=>$urgency[0], "impact"=>$impact[0], "number_of_affective_machine"=>$numberOfAffectiveMachine[0], "project_phase"=>$projectPhase[0],
            "reproductive" =>$reproductive[0], "expected_priority"=>$expectedPriority[0], "priority_1"=>$priority1[0], "priority_2"=>$priority2[0], "priority_3"=>$priority3[0]);

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

    public function show(string $pageTitle):string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;
        $tplData['data'] = $this->getData();

        /*$pole = array();
        $impacts = $this->db->numberOfImpact();
        foreach ($impacts[0] as $impact) {
            array_push($pole, $impact);
        }
        $tplData['impact_data'] = json_encode($pole);
        $tplData['impact_labels'] = json_encode(array("Critical", "Non-critical"));*/

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