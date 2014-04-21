<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 20.04.14
 * Time: 19:40
 */

namespace Acme;

class Calendar {

    protected $idCity;

    function __construct($idCity) {
        $this->idCity = $idCity;
    }

    public static function getListOfMonths($lang = 'pl') {
        $months = array(
            'pl'=>array('Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień')
        );

        return $months[$lang];
    }

    /*
     * Funkcja zwracająca ilość dostępnych dni w danym miesiącu dla konkretnego miasta
     *
     * @param date
     * @return array
     */
    public function getFreeDaysForCityInMonth($date) {
        $cityFreeDaysInMonth = \Model::factory('Calendar')->filter('getCalendarMonth',$date,$this->idCity)->find_many();
        $numberOfDays = date('t', strtotime($date));
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $cityCalendar = array();
        for($i=1;$i<=$numberOfDays; $i++) {
            foreach($cityFreeDaysInMonth as $day) {
                $freeDayDateFormated = date('Y-m-j', strtotime($day->date));
                if($freeDayDateFormated == $year.'-'.$month.'-'.$i)
                    $cityCalendar[$i] = $day;
            }

            if(!isset($cityCalendar[$i])) $cityCalendar[$i] = '';

        }
        return $cityCalendar;
    }
} 