<?php
//////////////////////////////////////////////////////////////
///////////// Vstupni bod cele webove aplikace ///////////////
///////////// - stranka s funkci rozcestniku   ///////////////
//////////////////////////////////////////////////////////////

/**
 * Webová aplikace pro prioritizaci incidentů.
 * GitHub:
 * @link TODO
 *
 * Tato webová alikace je vyvíjena k bakalářské práci na téma "Prioritizace zákazníků při poskytování SW podpory".
 *
 * @author Tomáš Vyleta
 * @copyright Copyright (c) 2020, Tomáš Vyleta
 * @license TODO
 * @version 1.0
 *
 * Struktura webové aplikace je inspirována:
 * @link https://github.com/madostal/kiv-web/tree/master/cviceni/nykl
 */

// spustim aplikaci
$app = new ApplicationStart();
$app->appStart();

/**
 * Vstupni bod webove aplikace.
 */
class ApplicationStart
{

    /**
     * Inicializace webove aplikace.
     */
    public function __construct()
    {
        // nactu nastaveni
        require_once("settings.inc.php");
        // nactu rozhrani kontroleru
        require_once(DIRECTORY_CONTROLLERS . "/IController.interface.php");
    }

    /**
     * Spusteni webove aplikace.
     */
    public function appStart()
    {
        // test, zda je v URL pozadavku uvedena dostupna stranka, jinak volba defaultni stranky
        // mam spravnou hodnotu na vstupu nebo nastavim defaultni
        if (isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)) {
            $pageKey = $_GET["page"]; // nastavim pozadovane
        } else {
            $pageKey = DEFAULT_WEB_PAGE_KEY; // defaulti klic
        }
        // pripravim si data ovladace
        $pageInfo = WEB_PAGES[$pageKey];

        // nacteni odpovidajiciho kontroleru, jeho zavolani a vypsani vysledku
        // pripojim souboru ovladace
        require_once(DIRECTORY_CONTROLLERS . "/" . $pageInfo["file_name"]);

        // nactu ovladac a bez ohledu na prislusnou tridu ho typuju na dane rozhrani
        /** @var IController $controller Ovladac prislusne stranky. */
        $controller = new $pageInfo["class_name"];

        // zavolam prislusny ovladac a vypisu jeho obsah
        echo $controller->show($pageInfo["title"]);
    }
}

?>