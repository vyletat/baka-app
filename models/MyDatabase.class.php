<?php
//////////////////////////////////////////////////////////////////
////////////// Vlastni trida pro praci s databazi ////////////////
//////////////////////////////////////////////////////////////////

/**
 * Trida spravujici databazi.
 */
class MyDatabase
{

    // PDO objekt pro praci s databazi
    private $pdo;
    // objekt pro spravu session
    //private $mySession;
    // objekt s klicem pro uzivatele ulozeneho v session
    //private $userSessionKey = "current_user";

    /**
     * MyDatabase constructor.
     */
    public function __construct()
    {
        // inicialilzuju pripojeni k databazi - informace beru ze settings
        $this->pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
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
     * @param string $dotaz SQL dotaz.
     * @return PDOStatement        Vysledek dotazu.
     */
    private function executeQuery(string $dotaz)
    {
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
     * @param PDOStatement $obj Objekt s vysledky dotazu.
     * @return array       Pole s vysledky dotazu.
     */
    private function resultObjectToArray(PDOStatement $obj)
    {
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
     * @param string $tableName Nazev tabulky.
     * @param string $whereStatement Pripadne omezeni na ziskani radek tabulky. Default "".
     * @param string $orderByStatement Pripadne razeni ziskanych radek tabulky. Default "".
     * @return array                    Vraci pole ziskanych radek tabulky.
     */
    public function selectFromTable(string $tableName, string $whereStatement = "", $orderByStatement = ""): array
    {
        // slozim dotaz
        $q = "SELECT * FROM " . $tableName
            . (($whereStatement == "") ? "" : " WHERE $whereStatement")
            . (($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * Jednoduchy zapis do prislusne tabulky.
     *
     * @param string $tableName Nazev tabulky.
     * @param string $insertStatement Text s nazvy sloupcu pro insert.
     * @param string $insertValues Text s hodnotami pro prislusne sloupce.
     * @return bool                     Vlozeno v poradku?
     */
    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValues): bool
    {
        // slozim dotaz
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValues)";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if ($obj == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Jednoducha uprava radku databazove tabulky.
     *
     * @param string $tableName Nazev tabulky.
     * @param string $updateStatementWithValues Cela cast updatu s hodnotami.
     * @param string $whereStatement Cela cast pro WHERE.
     * @return bool                                 Upraveno v poradku?
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement): bool
    {
        // slozim dotaz
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if ($obj == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Dle zadane podminky maze radky v prislusne tabulce.
     *
     * @param string $tableName Nazev tabulky.
     * @param string $whereStatement Podminka mazani.
     */
    public function deleteFromTable(string $tableName, string $whereStatement)
    {
        // slozim dotaz
        $q = "DELETE FROM $tableName WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if ($obj == null) {
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
    public function getAllUsers()
    {
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $users = $this->selectFromTable(TABLE_UZIVATEL, "", "id_uzivatel");
        return $users;
    }

    /**
     * Metoda pro získání všech řádků i sloupců z tabulky urgency
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function getUrgency()
    {
        //ziskam celou tabulku urgency
        $uregency = $this->selectFromTable(TABLE_URGENCY, "", "");
        return $uregency;
    }

    /**
     * Metoda pro získání všech řádků i sloupců z tabulky impact
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function getImpact()
    {
        //ziskam celou tabulku urgency
        $impact = $this->selectFromTable(TABLE_IMPACT, "", "");
        return $impact;
    }

    /**
     * Metoda pro získání všech řádků i sloupců z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function getIncident()
    {
        //ziskam celou tabulku urgency
        $incident = $this->selectFromTable(TABLE_INCIDENT, "", "");
        return $incident;
    }

    /**
     * Metoda pro získání všech řádků i sloupců z tabulky number_of_affective_machines
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function getNumberOfAffectiveMachines()
    {
        //ziskam celou tabulku urgency
        $number_of_affective_machines = $this->selectFromTable(TABLE_NUMBER_OF_AFFECTIVE_MACHINES, "", "");
        return $number_of_affective_machines;
    }

    /**
     * Metoda pro získání všech řádků i sloupců z tabulky priority
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function getPriority()
    {
        //ziskam celou tabulku urgency
        $priority = $this->selectFromTable(TABLE_PRIORITY, "", "");
        return $priority;
    }

    /**
     * Metoda pro získání všech řádků i sloupců z tabulky project_phase
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function getProjectPhase()
    {
        //ziskam celou tabulku urgency
        $project_phase = $this->selectFromTable(TABLE_PROJECT_PHASE, "", "");
        return $project_phase;
    }

    /**
     * Metoda pro získání všech řádků i sloupců z tabulky reproductive
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function getReproductive()
    {
        //ziskam celou tabulku urgency
        $reproductive = $this->selectFromTable(TABLE_REPRODUCTIVE, "", "");
        return $reproductive;
    }

    /**
     * Metoda pro update hodnocení incidentu.
     *
     * @param int $id ID incidentu
     * @param int $number Číslo metody
     * @param int $rating Hodnocení
     */
    function updateRating(int $id, int $number, int $rating)
    {
        $values = " `priority_" . "$number" . "_rating`=$rating";
        $where = "`id`=$id";
        $this->updateInTable(TABLE_INCIDENT, $values, $where);
    }

    /**
     * Metoda pro update priority incidentu.
     *
     * @param int $id ID incidentu
     * @param int $number Číslo metody
     * @param int $priority Priorita
     */
    function updatePriority(int $id, int $number, int $priority)
    {
        $values = "`priority_" . "$number" . "`=$priority";
        $where = "`id`=$id";
        $this->updateInTable(TABLE_INCIDENT, $values, $where);
    }

    /**
     * Metoda pro update hodnocení a priority incidentu.
     *
     * @param int $id ID incidentu
     * @param int $number Číslo metody
     * @param int $rating Hodnocení
     * @param int $priority Priorita
     */
    function updateRatingAndPriority(int $id, int $number, $rating, int $priority)
    {
        $values = "`priority_" . "$number" . "`=$priority, `priority_" . "$number" . "_rating`=$rating";
        $where = "`id`=$id";
        $this->updateInTable(TABLE_INCIDENT, $values, $where);
    }

    /**
     * Medota pro vložení nového incidentu do databáze
     *
     * @param string $name Název incidentu
     * @param int $sla_time SLA čas incidentu
     * @param int $urgency Naléhavost incidentu
     * @param int $reproductive Reproduktibilita incidentu
     * @param int $project_phase Projektová fáze incidentu
     * @param int $number_of_effective_machines Počet ovlivněných strojů incidentu
     * @param int $impact Dopad incidentu
     * @param int $expected_priority Předpokládáná priorita incidentu
     * @return bool                                 Informace, jestli vložení proběhlo v pořádku
     */
    public function addIncident(string $name, int $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_effective_machines, int $impact, int $expected_priority)
    {
        // hlavicka pro vlozeni do tabulky uzivatelu
        $insertStatement = "name, sla_time, urgency, reproductive, project_phase, number_of_effective_machines, impact, expected_priority";
        // hodnoty pro vlozeni do tabulky uzivatelu
        $insertValues = "'$name', $sla_time, $urgency, $reproductive, $project_phase, $number_of_effective_machines, $impact, $expected_priority";
        // provedu dotaz a vratim jeho vysledek
        return $this->insertIntoTable(TABLE_INCIDENT, $insertStatement, $insertValues);
    }

    public function updateIncident(string $name, int $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_effective_machines, int $impact, int $expected_priority)
    {
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
     * @param int $idUzivatel ID upravovaneho uzivatele.
     * @param string $login Login.
     * @param string $heslo Heslo.
     * @param string $jmeno Jmeno.
     * @param string $email E-mail.
     * @param int $idPravo ID prava.
     * @return bool             Bylo upraveno?
     */
    public function updateUser(int $idUzivatel, string $login, string $heslo, string $jmeno, string $email, int $idPravo)
    {
        // slozim cast s hodnotami
        $updateStatementWithValues = "login='$login', heslo='$heslo', jmeno='$jmeno', email='$email', id_pravo='$idPravo'";
        // podminka
        $whereStatement = "id_uzivatel=$idUzivatel";
        // provedu update
        return $this->updateInTable(TABLE_UZIVATEL, $updateStatementWithValues, $whereStatement);
    }

    /**
     * Metoda pro získání incidentů do tabulky pro přehled bez honocení priority. (Číselné hodnoty jsou nahrazeny jejich významovými)
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function incidentsToTable()
    {
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
     * Metoda pro získání incidentů do tabulky pro přehled pro 3. metodu výpočtu priority. (Číselné hodnoty jsou nahrazeny jejich významovými)
     *
     * @param int $number Číslo metody.
     * @return array        Vrátí pole s výsledky dotazu.
     */
    public function incidentsToTableRating(int $number)
    {
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
        incident.priority_" . "$number" . "_rating AS 'rating',
        incident.priority_" . "$number" . " AS 'priority'
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
     * Metoda pro získání incidentů do tabulky pro přehled pro všechny metody výpočtu priorit. (Číselné hodnoty jsou nahrazeny jejich významovými)
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    public function incidentsToTableAll()
    {
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
        incident.priority_3 AS 'priority_3',
        incident.priority_4_rating AS 'rating_4',
        incident.priority_4 AS 'priority_4',
        incident.priority_5_rating AS 'rating_5',
        incident.priority_5 AS 'priority_5',
        incident.priority_6_rating AS 'rating_6',
        incident.priority_6 AS 'priority_6',
        incident.priority_7_rating AS 'rating_7',
        incident.priority_7 AS 'priority_7'
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
     * Metoda pro získání sumy jednotlivých atributů sloupečku urgency z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfUrgency()
    {
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
     * Metoda pro získání sumy jednotlivých atributů sloupečku impact z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfImpact()
    {
        $query = "SELECT
SUM(CASE WHEN impact=1 THEN 1 ELSE 0 END) AS 'critical',
SUM(CASE WHEN impact=2 THEN 1 ELSE 0 END) AS 'non-critical'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * Metoda pro získání sumy jednotlivých atributů sloupečku number_of_affective_machines z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfNumberOfAffectiveMachine()
    {
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
     * Metoda pro získání sumy jednotlivých atributů sloupečku project_phase z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfProjectPhase()
    {
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
     * Metoda pro získání sumy jednotlivých atributů sloupečku reproductive z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfReproductive()
    {
        $query = "SELECT
SUM(CASE WHEN reproductive=1 THEN 1 ELSE 0 END) AS 'yes',
SUM(CASE WHEN reproductive=2 THEN 1 ELSE 0 END) AS 'no'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * Metoda pro získání sumy jednotlivých atributů sloupečku expected_priority z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfExpectedPriority()
    {
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
     * Metoda pro získání sumy jednotlivých atributů sloupečku priority_1 (1. metody pro výpočet priority) z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfPriority(int $number)
    {
        $query = "SELECT
SUM(CASE WHEN priority_" . "$number" . "=1 THEN 1 ELSE 0 END) AS 'very_high',
SUM(CASE WHEN priority_" . "$number" . "=2 THEN 1 ELSE 0 END) AS 'high',
SUM(CASE WHEN priority_" . "$number" . "=3 THEN 1 ELSE 0 END) AS 'medium',
SUM(CASE WHEN priority_" . "$number" . "=4 THEN 1 ELSE 0 END) AS 'low'
FROM incident";
        $obj = $this->executeQuery($query);
        $res = $this->resultObjectToArray($obj);
        return $res;
    }

    /**
     * Metoda pro získání sumy jednotlivých atributů sloupečku priority_2 (2. metody pro výpočet priority) z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfPriority2()
    {
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
     * Metoda pro získání sumy jednotlivých atributů sloupečku priority_3 (3. metody pro výpočet priority) z tabulky incident
     *
     * @return array    Vrátí pole s výsledky dotazu.
     */
    function numberOfPriority3()
    {
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

    function deleteIncident($id)
    {
        $where = "`id`=$id";
        $this->deleteFromTable(TABLE_INCIDENT, $where);
    }

    ///////////////////  KONEC: Konkretni funkce  ////////////////////////////////////////////

}

?>