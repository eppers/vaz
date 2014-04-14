<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author piotrm
 */
class Admin {
     /* var $app Slim */
    public $app;

    
    public function index() {
        $this->render('vazectomia.html.twig');
    }

    public function render($template) {
        $this->app->config('templates.path', './templates/admin');
        $args = array_slice(func_get_args(),1);
        $args = array_shift($args);
        $session['session'] = $_SESSION;
        $args = array_merge($args,$session);
        $this->app->render($template, $args);
    }
}

?>
