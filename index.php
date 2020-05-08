<?php
//////////////////////////////////////////////////////////////
///////////// Vstupni bod cele webove aplikace ///////////////
///////////// - stranka s funkci rozcestniku   ///////////////
//////////////////////////////////////////////////////////////

/**
 * Webová aplikace pro prioritizaci incidentů.
 * GitHub:
 * @link https://github.com/vyletat/baka-app
 *
 * Tato webová alikace je vyvíjena k bakalářské práci na téma "Prioritizace zákazníků při poskytování SW podpory".
 *
 * @author Tomáš Vyleta
 * @copyright Copyright (c) 2020, Tomáš Vyleta
 * @license MIT
 * @version 1.0
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
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