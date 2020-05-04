<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS . "/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class HomeController implements IController
{

    /**
     * Vratí obsah úvodní stránky.
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

        // vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS . "/HomeTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>