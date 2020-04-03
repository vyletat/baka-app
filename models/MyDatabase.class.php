<?php
//////////////////////////////////////////////////////////////
////////////// Vlastni trida pro praci s databazi ////////////////
//////////////////////////////////////////////////////////////

/**
 * Trida spravujici databazi.
 */
class MyDatabase {

    // PDO objekt pro praci s databazi
    private $pdo;
    // objekt pro spravu session
    //private $mySession;
    // objekt s klicem pro uzivatele ulozeneho v session
    //private $userSessionKey = "current_user";


    public function __construct(){
        // inicialilzuju pripojeni k databazi - informace beru ze settings
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
        // inicializuju objekt pro praci se session - pouzito pro spravu prihlaseni uzivatele
        // pozn.: v samostatne praci vytvorte pro spravu prihlaseni uzivatele samostatnou tridu.
        //require_once("MySessions.class.php");
        //$this->mySession = new MySession();
    }


    ///////////////////  Obecne funkce  ////////////////////////////////////////////

    /**
     *  Provede dotaz a bud vrati jeho vysledek, nebo vrati null a vypise chybu.
     *
     *  @param string $dotaz        SQL dotaz.
     *  @return PDOStatement        Vysledek dotazu.
     */
    private function executeQuery(string $dotaz){
        // vykonam dotaz
        $res = $this->pdo->query($dotaz);
        if (!$res) {
            $error = $this->pdo->errorInfo();
            echo $error[2];
            return null;
        } else {
            return $res;
        }
    }

    /**
     *  Prevede vysledny objekt dotazu na pole ziskanych dat.
     *
     *  @param PDOStatement $obj  Objekt s vysledky dotazu.
     *  @return array       Pole s vysledky dotazu.
     */
    private function resultObjectToArray(PDOStatement $obj){
        // projdu jednotlive radky tabulky
        /*while($row = $vystup->fetch(PDO::FETCH_ASSOC)){
            $pole[] = $row['login'].'<br>';
        }*/
        // ziskam vsechny radky tabulky jako pole
        return $obj->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Jednoduche cteni z prislusne DB tabulky.
     *
     * @param string $tableName         Nazev tabulky.
     * @param string $whereStatement    Pripadne omezeni na ziskani radek tabulky. Default "".
     * @param string $orderByStatement  Pripadne razeni ziskanych radek tabulky. Default "".
     * @return array                    Vraci pole ziskanych radek tabulky.
     */
    public function selectFromTable(string $tableName, string $whereStatement = "", $orderByStatement = ""):array {
        // slozim dotaz
        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * Jednoduchy zapis do prislusne tabulky.
     *
     * @param string $tableName         Nazev tabulky.
     * @param string $insertStatement   Text s nazvy sloupcu pro insert.
     * @param string $insertValues      Text s hodnotami pro prislusne sloupce.
     * @return bool                     Vlozeno v poradku?
     */
    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValues):bool {
        // slozim dotaz
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValues)";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Jednoducha uprava radku databazove tabulky.
     *
     * @param string $tableName                     Nazev tabulky.
     * @param string $updateStatementWithValues     Cela cast updatu s hodnotami.
     * @param string $whereStatement                Cela cast pro WHERE.
     * @return bool                                 Upraveno v poradku?
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement):bool {
        // slozim dotaz
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Dle zadane podminky maze radky v prislusne tabulce.
     *
     * @param string $tableName         Nazev tabulky.
     * @param string $whereStatement    Podminka mazani.
     */
    public function deleteFromTable(string $tableName, string $whereStatement){
        // slozim dotaz
        $q = "DELETE FROM $tableName WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    ///////////////////  KONEC: Obecne funkce  ////////////////////////////////////////////

    ///////////////////  Konkretni funkce  ////////////////////////////////////////////

    /**
     * Ziskani zaznamu vsech uzivatelu aplikace.
     *
     * @return array    Pole se vsemi uzivateli.
     */
    public function getAllUsers(){
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $users = $this->selectFromTable(TABLE_UZIVATEL, "", "id_uzivatel");
        return $users;
    }

    /**
     *
     *
     * @return array
     */
    public function getUrgency() {
        //ziskam celou tabulku urgency
        $uregency = $this->selectFromTable(TABLE_URGENCY,"","");
        return $uregency;
    }

    /**
     * @return array
     */
    public function getImpact() {
        //ziskam celou tabulku urgency
        $impact = $this->selectFromTable(TABLE_IMPACT,"","");
        return $impact;
    }

    /**
     * @return array
     */
    public function getIncident() {
        //ziskam celou tabulku urgency
        $incident = $this->selectFromTable(TABLE_INCIDENT,"","");
        return $incident;
    }

    /**
     * @return array
     */
    public function getNumberOfAffectiveMachines() {
        //ziskam celou tabulku urgency
        $number_of_affective_machines = $this->selectFromTable(TABLE_NUMBER_OF_AFFECTIVE_MACHINES,"","");
        return $number_of_affective_machines;
    }

    /**
     * @return array
     */
    public function getPriority() {
        //ziskam celou tabulku urgency
        $priority = $this->selectFromTable(TABLE_PRIORITY,"","");
        return $priority;
    }

    /**
     * @return array
     */
    public function getProjectPhase() {
        //ziskam celou tabulku urgency
        $project_phase = $this->selectFromTable(TABLE_PROJECT_PHASE,"","");
        return $project_phase;
    }

    /**
     * @return array
     */
    public function getReproductive() {
        //ziskam celou tabulku urgency
        $reproductive = $this->selectFromTable(TABLE_REPRODUCTIVE,"","");
        return $reproductive;
    }

    /**
     * @param string $name
     * @param int $sla_time
     * @param int $urgency
     * @param int $reproductive
     * @param int $project_phase
     * @param int $number_of_effective_machines
     * @param int $impact
     * @param int $expected_priority
     * @return bool
     */
    public function addIncident(string $name, int $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_effective_machines, int $impact, int $expected_priority) {
        // hlavicka pro vlozeni do tabulky uzivatelu
        $insertStatement = "name, sla_time, urgency, reproductive, project_phase, number_of_effective_machines, impact, expected_priority";
        // hodnoty pro vlozeni do tabulky uzivatelu
        $insertValues = "'$name', $sla_time, $urgency, $reproductive, $project_phase, $number_of_effective_machines, $impact, $expected_priority";
        // provedu dotaz a vratim jeho vysledek
        return $this->insertIntoTable(TABLE_INCIDENT, $insertStatement, $insertValues);
    }

    public function updateIncident(string $name, int $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_effective_machines, int $impact, int $expected_priority) {
        // hlavicka pro vlozeni do tabulky uzivatelu
        $insertStatement = "name, sla_time, urgency, reproductive, project_phase, number_of_effective_machines, impact, expected_priority";
        // hodnoty pro vlozeni do tabulky uzivatelu
        $insertValues = "'$name', '$sla_time', '$urgency', '$reproductive', '$project_phase', '$number_of_effective_machines', '$impact', '$expected_priority'";
        // provedu dotaz a vratim jeho vysledek
        return $this->insertIntoTable(TABLE_INCIDENT, $insertStatement, $insertValues);
    }

    /**
     * Uprava konkretniho uzivatele v databazi.
     *
     * @param int $idUzivatel   ID upravovaneho uzivatele.
     * @param string $login     Login.
     * @param string $heslo     Heslo.
     * @param string $jmeno     Jmeno.
     * @param string $email     E-mail.
     * @param int $idPravo      ID prava.
     * @return bool             Bylo upraveno?
     */
    public function updateUser(int $idUzivatel, string $login, string $heslo, string $jmeno, string $email, int $idPravo){
        // slozim cast s hodnotami
        $updateStatementWithValues = "login='$login', heslo='$heslo', jmeno='$jmeno', email='$email', id_pravo='$idPravo'";
        // podminka
        $whereStatement = "id_uzivatel=$idUzivatel";
        // provedu update
        return $this->updateInTable(TABLE_UZIVATEL, $updateStatementWithValues, $whereStatement);
    }

    /**
     * @return array
     */
    public function incidentsToTable() {
        $query = "SELECT
        incident.id,
        incident.name,
        incident.sla_time,
        impact.name AS 'impact',
        urgency.name AS 'urgency',
        project_phase.name AS 'project_phase',
        number_of_affective_machines.name AS 'number_of_affective_machines',
        reproductive.name AS 'reproductive',
        priority.name AS 'expected_priority'
        FROM
        incident
        INNER JOIN impact ON incident.impact = impact.id_IMPACT
        INNER JOIN number_of_affective_machines ON incident.number_of_effective_machines = number_of_affective_machines.id_NUMBER_OF_AFFECTIVE_MACHINES
        INNER JOIN priority ON incident.expected_priority = priority.idPRIORITY
        INNER JOIN project_phase ON incident.project_phase = project_phase.id_PROJECT_PHASE
        INNER JOIN reproductive ON incident.reproductive = reproductive.id_REPRODUCTIVE
        INNER JOIN urgency ON incident.urgency = urgency.id_URGENCY
        ORDER BY incident.id";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    public function incidentsToTableRating1() {
        $query = "SELECT
        incident.id,
        incident.name,
        incident.sla_time,
        impact.name AS 'impact',
        urgency.name AS 'urgency',
        project_phase.name AS 'project_phase',
        number_of_affective_machines.name AS 'number_of_affective_machines',
        reproductive.name AS 'reproductive',
        priority.name AS 'expected_priority',
        incident.priority_1_rating AS 'rating',
        incident.priority_1 AS 'priority'
        FROM
        incident
        INNER JOIN impact ON incident.impact = impact.id_IMPACT
        INNER JOIN number_of_affective_machines ON incident.number_of_effective_machines = number_of_affective_machines.id_NUMBER_OF_AFFECTIVE_MACHINES
        INNER JOIN priority ON incident.expected_priority = priority.idPRIORITY
        INNER JOIN project_phase ON incident.project_phase = project_phase.id_PROJECT_PHASE
        INNER JOIN reproductive ON incident.reproductive = reproductive.id_REPRODUCTIVE
        INNER JOIN urgency ON incident.urgency = urgency.id_URGENCY
        ORDER BY incident.id";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    public function incidentsToTableRating2() {
        $query = "SELECT
        incident.id,
        incident.name,
        incident.sla_time,
        impact.name AS 'impact',
        urgency.name AS 'urgency',
        project_phase.name AS 'project_phase',
        number_of_affective_machines.name AS 'number_of_affective_machines',
        reproductive.name AS 'reproductive',
        priority.name AS 'expected_priority',
        incident.priority_2_rating AS 'rating',
        incident.priority_2 AS 'priority'
        FROM
        incident
        INNER JOIN impact ON incident.impact = impact.id_IMPACT
        INNER JOIN number_of_affective_machines ON incident.number_of_effective_machines = number_of_affective_machines.id_NUMBER_OF_AFFECTIVE_MACHINES
        INNER JOIN priority ON incident.expected_priority = priority.idPRIORITY
        INNER JOIN project_phase ON incident.project_phase = project_phase.id_PROJECT_PHASE
        INNER JOIN reproductive ON incident.reproductive = reproductive.id_REPRODUCTIVE
        INNER JOIN urgency ON incident.urgency = urgency.id_URGENCY
        ORDER BY incident.id";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    public function incidentsToTableRating3() {
        $query = "SELECT
        incident.id,
        incident.name,
        incident.sla_time,
        impact.name AS 'impact',
        urgency.name AS 'urgency',
        project_phase.name AS 'project_phase',
        number_of_affective_machines.name AS 'number_of_affective_machines',
        reproductive.name AS 'reproductive',
        priority.name AS 'expected_priority',
        incident.priority_3_rating AS 'rating',
        incident.priority_3 AS 'priority'
        FROM
        incident
        INNER JOIN impact ON incident.impact = impact.id_IMPACT
        INNER JOIN number_of_affective_machines ON incident.number_of_effective_machines = number_of_affective_machines.id_NUMBER_OF_AFFECTIVE_MACHINES
        INNER JOIN priority ON incident.expected_priority = priority.idPRIORITY
        INNER JOIN project_phase ON incident.project_phase = project_phase.id_PROJECT_PHASE
        INNER JOIN reproductive ON incident.reproductive = reproductive.id_REPRODUCTIVE
        INNER JOIN urgency ON incident.urgency = urgency.id_URGENCY
        ORDER BY incident.id";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    public function incidentsToTableAll() {
        $query = "SELECT
        incident.id,
        incident.name,
        incident.sla_time,
        impact.name AS 'impact',
        urgency.name AS 'urgency',
        project_phase.name AS 'project_phase',
        number_of_affective_machines.name AS 'number_of_affective_machines',
        reproductive.name AS 'reproductive',
        priority.name AS 'expected_priority',
        incident.priority_1_rating AS 'rating_1',
        incident.priority_1 AS 'priority_1',
        incident.priority_2_rating AS 'rating_2',
        incident.priority_2 AS 'priority_2',
        incident.priority_3_rating AS 'rating_3',
        incident.priority_3 AS 'priority_3'
        FROM
        incident
        INNER JOIN impact ON incident.impact = impact.id_IMPACT
        INNER JOIN number_of_affective_machines ON incident.number_of_effective_machines = number_of_affective_machines.id_NUMBER_OF_AFFECTIVE_MACHINES
        INNER JOIN priority ON incident.expected_priority = priority.idPRIORITY
        INNER JOIN project_phase ON incident.project_phase = project_phase.id_PROJECT_PHASE
        INNER JOIN reproductive ON incident.reproductive = reproductive.id_REPRODUCTIVE
        INNER JOIN urgency ON incident.urgency = urgency.id_URGENCY
        ORDER BY incident.id";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfUrgency() {
        $query = "SELECT
SUM(CASE WHEN urgency=1 THEN 1 ELSE 0 END) AS 'highest',
SUM(CASE WHEN urgency=2 THEN 1 ELSE 0 END) AS 'high',
SUM(CASE WHEN urgency=3 THEN 1 ELSE 0 END) AS 'medium',
SUM(CASE WHEN urgency=4 THEN 1 ELSE 0 END) AS 'low'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfImpact() {
        $query = "SELECT
SUM(CASE WHEN impact=1 THEN 1 ELSE 0 END) AS 'critical',
SUM(CASE WHEN impact=2 THEN 1 ELSE 0 END) AS 'non-critical'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfNumberOfAffectiveMachine() {
        $query = "SELECT
SUM(CASE WHEN `number_of_effective_machines`=1 THEN 1 ELSE 0 END) AS 'more_than_1000',
SUM(CASE WHEN `number_of_effective_machines`=2 THEN 1 ELSE 0 END) AS '101-1000',
SUM(CASE WHEN `number_of_effective_machines`=3 THEN 1 ELSE 0 END) AS '11-100',
SUM(CASE WHEN `number_of_effective_machines`=4 THEN 1 ELSE 0 END) AS '2-100',
SUM(CASE WHEN `number_of_effective_machines`=5 THEN 1 ELSE 0 END) AS '1'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfProjectPhase() {
        $query = "SELECT
SUM(CASE WHEN project_phase=1 THEN 1 ELSE 0 END) AS 'production',
SUM(CASE WHEN project_phase=2 THEN 1 ELSE 0 END) AS 'pilot',
SUM(CASE WHEN project_phase=3 THEN 1 ELSE 0 END) AS 'uat',
SUM(CASE WHEN project_phase=4 THEN 1 ELSE 0 END) AS 'certification',
SUM(CASE WHEN project_phase=5 THEN 1 ELSE 0 END) AS 'sit',
SUM(CASE WHEN project_phase=6 THEN 1 ELSE 0 END) AS 'internal_qa'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfReproductive() {
        $query = "SELECT
SUM(CASE WHEN reproductive=1 THEN 1 ELSE 0 END) AS 'yes',
SUM(CASE WHEN reproductive=2 THEN 1 ELSE 0 END) AS 'no'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfExpectedPriority() {
        $query = "SELECT
SUM(CASE WHEN expected_priority=1 THEN 1 ELSE 0 END) AS 'very_high',
SUM(CASE WHEN expected_priority=2 THEN 1 ELSE 0 END) AS 'high',
SUM(CASE WHEN expected_priority=3 THEN 1 ELSE 0 END) AS 'medium',
SUM(CASE WHEN expected_priority=4 THEN 1 ELSE 0 END) AS 'low'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfPriority1() {
        $query = "SELECT
SUM(CASE WHEN priority_1=1 THEN 1 ELSE 0 END) AS 'very_high',
SUM(CASE WHEN priority_1=2 THEN 1 ELSE 0 END) AS 'high',
SUM(CASE WHEN priority_1=3 THEN 1 ELSE 0 END) AS 'medium',
SUM(CASE WHEN priority_1=4 THEN 1 ELSE 0 END) AS 'low'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfPriority2() {
        $query = "SELECT
SUM(CASE WHEN priority_2=1 THEN 1 ELSE 0 END) AS 'very_high',
SUM(CASE WHEN priority_2=2 THEN 1 ELSE 0 END) AS 'high',
SUM(CASE WHEN priority_2=3 THEN 1 ELSE 0 END) AS 'medium',
SUM(CASE WHEN priority_2=4 THEN 1 ELSE 0 END) AS 'low'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * @return array
     */
    function numberOfPriority3() {
        $query = "SELECT
SUM(CASE WHEN priority_3=1 THEN 1 ELSE 0 END) AS 'very_high',
SUM(CASE WHEN priority_3=2 THEN 1 ELSE 0 END) AS 'high',
SUM(CASE WHEN priority_3=3 THEN 1 ELSE 0 END) AS 'medium',
SUM(CASE WHEN priority_3	=4 THEN 1 ELSE 0 END) AS 'low'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    ///////////////////  KONEC: Konkretni funkce  ////////////////////////////////////////////

    ///////////////////  Sprava prihlaseni uzivatele  ////////////////////////////////////////

    /**
     * Overi, zda muse byt uzivatel prihlasen a pripadne ho prihlasi.
     *
     * @param string $login     Login uzivatele.
     * @param string $heslo     Heslo uzivatele.
     * @return bool             Byl prihlasen?
     */
    public function userLogin(string $login, string $heslo){
        // ziskam uzivatele z DB - primo overuju login i heslo
        $where = "login='$login' AND heslo='$heslo'";
        $user = $this->selectFromTable(TABLE_UZIVATEL, $where);
        // ziskal jsem uzivatele
        if(count($user)){
            // ziskal - ulozim ho do session
            $_SESSION[$this->userSessionKey] = $user[0]; // beru prvniho nalezeneho
            return true;
        } else {
            // neziskal jsem uzivatele
            return false;
        }
    }

    /**
     * Odhlasi soucasneho uzivatele.
     */
    public function userLogout(){
        unset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Test, zda je nyni uzivatel prihlasen.
     *
     * @return bool     Je prihlasen?
     */
    public function isUserLogged(){
        return isset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Pokud je uzivatel prihlasen, tak vrati jeho data.
     *
     * @return mixed|null   Data uzivatele nebo null.
     */
    public function getLoggedUserData(){
        if($this->isUserLogged()){
            return $_SESSION[$this->userSessionKey];
        } else {
            return null;
        }
    }

    ///////////////////  KONEC: Sprava prihlaseni uzivatele  ////////////////////////////////////////

}

?>