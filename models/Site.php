<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



class Site extends Model{
        
    public static $_table = 'Sites';
    public static $_id_column = 'id_site';

    function steps() {
        return $this->has_many('Step', 'id_site');
    }
    
}
?>
