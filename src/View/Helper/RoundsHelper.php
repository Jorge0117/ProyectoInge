<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use App\Model\Table\RoundsTable;

/**
 * Rounds helper
 */
class RoundsHelper extends Helper
{

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
            $last[0] = $this->YmdtodmY($last[0]);
            $last[4] = $this->YmdtodmY($last[4]);
            return $last;
        }
        return null;
    }

    public function getPenultimateRow(){
        $penultimate = (new RoundsTable)->getPenultimateRow();
        if($penultimate != null){
            $penultimate[0] = $this->YmdtodmY($penultimate[0]);
            $penultimate[4] = $this->YmdtodmY($penultimate[4]);
            return $penultimate;
        }
        return null;
        
    }

    public function YmdtodmY($date){
        $j = $i = 0;
        while($date[$i] != '/' && $date[$i] != '-'){
            $i++;
        }
        $first = substr($date,$j,$i++);
        $j = $i;
        $i = 0;
        while($date[$j+$i] != '/' && $date[$j+$i] != '-'){
            $i++;
        }
        $second = substr($date,$j,$i++);
        
        $third = substr($date,$j+$i);
        return $third . "-" . $second . "-" . $first;
    }

    //devuelve el día actual.
    public function getToday() {
        $today = (new RoundsTable)->getToday();
        return $this->YmdtodmY($today);
    }

    //obtiene la ultima ronda creada.
    public function getLastRound() {
        $last = $this->getLastRow();
        if($last!= null){
            return ["Ronda #" . $last[1] .' '. $last[2] . ' ciclo ' . $last[3], "Inicio: " . $last[0], "Fin: " . $last[4]]; 
        }
        return "";
    }

    //devuelve un booleano que informa si el dia de hoy esta dentro del rango de las fechas establecidas.
    public function between(){
        return (new RoundsTable)->between();
    }

    public function active(){
        return (new RoundsTable)->active();
    }
}
