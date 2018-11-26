<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use App\Model\Table\RoundsTable;

/**
 * Rounds helper
 */
class RoundsHelper extends Helper{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    // devuelve la ultima tupla con el formato de fechas correcto.
    public function getLastRow() {
        
        $last = (new RoundsTable)->getLastRow();
        if($last != null){
            $last['start_date'] = $this->YmdtodmY($last['start_date']);
            $last['end_date'] = $this->YmdtodmY($last['end_date']);
            return $last;
        }
        return null;
    }

    public function getPenultimateRow(){
        
        $penultimate = (new RoundsTable)->getPenultimateRow();
        if($penultimate != null){
            $penultimate['start_date'] = $this->YmdtodmY($penultimate['start_date']);
            $penultimate['end_date'] = $this->YmdtodmY($penultimate['end_date']);
            return $penultimate;
        }
        return null;
    }

    public function YmdtodmY($date){
        $n = strlen($date);
        $j = $i = 0;
        while($date[$i] != '/' && $date[$i] != '-' && $i < $n)$i++;
        $first = substr($date,$j,$i++);
        $j = $i; $i = 0;
        while($date[$j+$i] != '/' && $date[$j+$i] != '-' && $i < $n)$i++;
        $second = substr($date,$j,$i++);
        $third = substr($date,$j+$i);
        $result = $third . "-" . $second . "-" . $first;

        return $result;
    }

    //devuelve el día actual.
    public function getToday() {
        $today = (new RoundsTable)->getToday();
        return $this->YmdtodmY($today);
    }

    //devuelve un booleano que informa si el dia de hoy esta dentro del rango de las fechas establecidas.
    public function between(){
        return (new RoundsTable)->between();
    }
}

