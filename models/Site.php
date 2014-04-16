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

    function getOneSiteName() {
        return $this->has_many('SiteLang', 'id_site');
    }

    public static function getManySitesNames($orm, $lang) {
        return $orm->join('Sites_Langs', array('Sites.id_site', '=', 'Sites_Langs.id_site'))->where('Sites_Langs.lang',$lang);
    }

}
?>
