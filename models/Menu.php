<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



class Menu extends Model{

    public static $_table = 'Menus';
    public static $_id_column = 'id_menu';

    function names() {
        return $this->has_many('MenuName', 'id_menu');
    }

    public static function getAllNames($orm, $lang) {
        return $orm->join('Menus_Names', array('Menus.id_menu', '=', 'Menus_Names.id_menu'))->where('Menus_Names.lang',$lang);
    }

}
?>
