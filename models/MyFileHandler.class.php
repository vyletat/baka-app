<?php
//////////////////////////////////////////////////////////////////
////////////// Vlastni trida pro praci se soubory ////////////////
//////////////////////////////////////////////////////////////////

/**
 * Class MyFileHandler Třída zpracovávající soubory.
 */
class MyFileHandler
{

    //Konstatnty s názvem souboru s daty
    const SABLONA = "sablona.json";
    const METHOD_DN = "method_DN.json";
    const METHOD_ROZ = "method_Roz.json";
    const METHOD_BOD = "method_Bod.json";
    const METHOD_RS = "method_RS.json";
    const METHOD_RR = "method_RR.json";
    const METHOD_RE = "method_RE.json";
    const METHOD_ROC = "method_ROC.json";

    public function __construct()
    {
    }

    /**
     * Načtení souboru.
     *
     * @param string $filePath Cesta k souboru.
     * @return false|string     Vrátí null nebo data souboru.
     */
    function loadFile(string $filePath)
    {
        if (file_exists($filePath) && is_file($filePath)) {
            $data = file_get_contents($filePath) or die("The file can't be open.");
            return $data;
        }
        return null;
    }

    /**
     * Dekóduje data z JSONu.
     *
     * @param $data     Data
     * @return mixed    Dekódovaná data v asociacnim poli
     */
    function decodeJSONFile($data)
    {
        // Convert to array
        return $options = json_decode($data, true);
    }

    /**
     * Metoda na zaklade vstupniho cisla vrací dekódovaný soubor s config.
     *
     * @param int $number Cislo metody
     * @return mixed        Dekódovaná data v asociacnim poli
     */
    function getMethodParams(int $number)
    {
        switch ($number) {
            case 1:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_DN);
                return $options = $this->decodeJSONFile($rawData);

            case 2:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_RS);
                return $options = $this->decodeJSONFile($rawData);

            case 3:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_RR);
                return $options = $this->decodeJSONFile($rawData);

            case 4:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_RE);
                return $options = $this->decodeJSONFile($rawData);

            case 5:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_ROC);
                return $options = $this->decodeJSONFile($rawData);

            default:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::SABLONA);
                return $options = $this->decodeJSONFile($rawData);
        }
    }
}

?>