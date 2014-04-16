<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



class City extends Model{
        
    public static $_table = 'Cities';
    public static $_id_column = 'id_city';

    function getOneCityName() {
        return $this->has_many('CityName', 'id_city');
    }

    public static function getManyCitiesNames($orm, $lang) {
        return $orm->join('Cities_Names', array('Cities.id_city', '=', 'Cities_Names.id_city'))->where('Cities_Names.lang',$lang);
    }
}
?>
