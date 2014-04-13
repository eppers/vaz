<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



class City extends Model{
        
    public static $_table = 'Cities';
    public static $_id_column = 'id_city';

    function names() {
        return $this->has_many('CityName', 'id_city');
    }
   
}
?>
