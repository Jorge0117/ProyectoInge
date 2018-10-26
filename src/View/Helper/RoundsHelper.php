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
            $s_year = substr($last[0],0,4);
            $s_month = substr($last[0],5,2);
            $s_day = substr($last[0],8,2);
            $last[0] = $s_day . "-" . $s_month . "-" . $s_year;
            $e_year = substr($last[4],0,4);
            $e_month = substr($last[4],5,2);
            $e_day = substr($last[4],8,2);
            $last[4] = $e_day . "-" . $e_month . "-" . $e_year;
            return $last;
        }
        return null;
        
    }
    //devuelve el día actual.
    public function getToday() {
        return (new RoundsTable)->getToday();
    }

    //obtiene la ultima ronda creada.
    public function getLastRound() {
        $last = $this->getLastRow();
        if($last!= null){
            return ["Ronda #" . $last[1], "Inicio:" . $last[0], "Fin:" . $last[4]]; 
        }
        return "";
    }

    //devuelve un booleano que informa si el dia de hoy esta dentro del rango de las fechas establecidas.
    public function between(){
        return (new RoundsTable)->between();
    }
}
