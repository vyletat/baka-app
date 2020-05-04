<?php

/**
 * Třída pro kalkulace incidentů
 *
 * Na tuto tridu nejsou zatím incidenty napojeny.
 */
class MyCalculation
{

//-------------------------------------------- START OF CALCULATION ------------------------------------------------

    /**
     * Hlavní metoda pro výpočet ohodnocení incidentu.
     *
     * @param int $method Metoda, podle které se bude počítat.
     * @param int $sla_time SLA čas
     * @param int $urgency Naléhavost
     * @param int $reproductive Reprodukovatelnost
     * @param int $project_phase Projektová fáze
     * @param int $number_of_affective_machines Počet ovlivněných strojů
     * @param int $impact Dopad
     * @return int|mixed                            normalizované ohodnocení
     */
    function calculateIncident(int $method, $sla_time, int $urgency, int $reproductive, int $project_phase, int $number_of_affective_machines, int $impact)
    {
        // Získání parametrů metody, podle které se bude počítat.
        $options = $this->file->getMethodParams($method);
        $values = array();
        // Výpočet kritérií a jejich atributů.
        foreach ($options['criteria'] as $criterion_name => $criterion) {
            if ($criterion['contains'] == true) {
                switch ($criterion_name) {
                    case "sla_time":
                        $val_sla_time = $this->calculateSlaTime($sla_time, $criterion['weight']);
                        array_push($values, $val_sla_time);
                        break;

                    case "urgency":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $urgency; $i++) {
                            $val_urgency = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_urgency);
                        break;

                    case "reproducibility":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $reproductive; $i++) {
                            $val_reproductive = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_reproductive);
                        break;

                    case "project_phase":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $project_phase; $i++) {
                            $val_project_phase = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_project_phase);
                        break;

                    case "number_of_affective_machines":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $number_of_affective_machines; $i++) {
                            $val_number_of_affective_machines = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_number_of_affective_machines);
                        break;

                    case "impact":
                        //převede asociativní pole na normální pole kvůli jeho procházení integerem
                        $array = array_values($criterion['attributes']);
                        //zastaví se na poloze atributu, který potřebujeme
                        for ($i = 0; $i < $impact; $i++) {
                            $val_impact = $criterion['weight'] * $array[$i];
                        }
                        array_push($values, $val_impact);
                        break;

                    default:

                }
            }
        }

        // Nastavení jestli se bude sčítat nebo násobit.
        $result = 0.0;
        switch ($options['other']['method']) {
            case "multiply":
                foreach ($values as $value) {
                    $result *= $value;
                }
                break;

            case "sum":
                foreach ($values as $value) {
                    $result += $value;
                }
                break;
        }

        // Normalizování výsledku.
        if ($options['priority']['normalize'] == true) {
            $normalizeResult = ($result - $options['priority']['min']) / ($options['priority']['max'] - $options['priority']['min']);
            $result = floatval($normalizeResult);
        }
        return floatval($result);
    }

    /**
     * Metoda pro výpočet SLA času.
     *
     * @param $sla_time     Hodnota v intervalu <0; 1>.
     * @param $weight       Váha SLA krotéria šas.
     * @return float|int    Vážená hodnota kritéria SLA času.
     */
    function calculateSlaTime($sla_time, $weight)
    {
        $max = 4230.0;
        $value = 0.0;
        if ($sla_time > $max) {
            $value = 0.0;
        } else {
            $value = ($max - $sla_time) / $max;
        }
        return ($value * $weight);
    }

    /**
     * Metoda vrací podle nastavení metody a ohodnocení prioritu incidentu.
     *
     * @param int $method Metoda, podle které chcete určit prioritu.
     * @param $rating       Ohodnocení incidentu.
     * @return int          Číslo priority incedentu.
     */
    function calculatePriority(int $method, $rating)
    {
        $options = $this->file->getMethodParams($method);
        switch ($options['priority']['order']) {
            case "asc":
                if ($rating < $options['priority']['scale']['very_high']) {
                    return 1;
                } else {
                    if ($rating < $options['priority']['scale']['high']) {
                        return 2;
                    } else {
                        if ($rating < $options['priority']['scale']['medium']) {
                            return 3;
                        } else {
                            return 4;
                        }
                    }
                }

            //max
            default:
                if ($rating > $options['priority']['scale']['high']) {
                    return 1;
                } else {
                    if ($rating > $options['priority']['scale']['medium']) {
                        return 2;
                    } else {
                        if ($rating > $options['priority']['scale']['low']) {
                            return 3;
                        } else {
                            return 4;
                        }
                    }
                }
        }
    }

    /**
     * Funkce aktulizuje u všech incidentů v databázi vypočítaný rating a priority.
     */
    function updateAllMethodsAndPriority()
    {
        $allIncidents = $this->db->getIncident();
        foreach ($allIncidents as $incident) {
            foreach (ALL_METHODS as $method) {
                $rating = $this->calculateIncident($method, $incident['sla_time'], $incident['urgency'], $incident['reproductive'], $incident['project_phase'], $incident['number_of_effective_machines'], $incident['impact']);
                $priority = $this->calculatePriority($method, $rating);
                $this->db->updateRatingAndPriority($incident['id'], $method, $rating, $priority);
            }
        }
    }

    //---------------------------------------------- END OF CALCULATION ------------------------------------------------

}

?>