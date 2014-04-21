<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 19.04.14
 * Time: 13:34
 */

class Calendar extends Model{

    public static $_table = 'Calendar';
    public static $_id_column = 'id_calendar';

    public static function getCalendarMonth($orm,$date,$cityId) {
        return $orm->where_raw('id_city = :idCity AND date >= (LAST_DAY(:date) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND date <  (LAST_DAY(:date) + INTERVAL 1 DAY)',array('idCity'=>$cityId, 'date'=>$date));
    }
} 