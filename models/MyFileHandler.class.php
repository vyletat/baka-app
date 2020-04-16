<?php
//////////////////////////////////////////////////////////////////
////////////// Vlastni trida pro praci se soubory ////////////////
//////////////////////////////////////////////////////////////////

/**
 * Class MyFileHandler Třída zpracovávající soubory
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

    function loadFile(string $filePath)
    {
        if (file_exists($filePath) && is_file($filePath)) {
            $data = file_get_contents($filePath) or die("The file can't be open.");
            return $data;
        }
    }

    function decodeJSONFile($data)
    {
        // Get the contents of the JSON file
        // $strJsonFileContents = file_get_contents(DIRECTORY_CONFIG . "/" . self::METHOD_DN);
        // Convert to array
        return $options = json_decode($data, true);
        //return $options = json_decode($data);
    }

    //na zaklade vstupniho cisla bude vracet soubor s config
    function getMethodParams(int $number)
    {
        switch ($number) {
            case 1:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_DN);
                return $options = $this->decodeJSONFile($rawData);

            case 2:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_ROZ);
                return $options = $this->decodeJSONFile($rawData);

            case 3:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_BOD);
                return $options = $this->decodeJSONFile($rawData);

            case 4:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_RS);
                return $options = $this->decodeJSONFile($rawData);

            case 5:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_RR);
                return $options = $this->decodeJSONFile($rawData);

            case 6:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_RE);
                return $options = $this->decodeJSONFile($rawData);

            case 7:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::METHOD_ROC);
                return $options = $this->decodeJSONFile($rawData);

            default:
                $rawData = $this->loadFile(DIRECTORY_CONFIG . "/" . self::SABLONA);
                return $options = $this->decodeJSONFile($rawData);
        }
    }
}

?>