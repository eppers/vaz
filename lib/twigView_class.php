<?php

class twigView extends Slim_View {
    
    public function render( $template) {
        $loader = new Twig_Loader_Filesystem($this->getTemplatesDirectory());

      //  $filter = new Twig_SimpleFilter('shortUrl', 'cleanForShortURL');
        
        $twig = new Twig_Environment($loader);
        $twig->addFilter('cleanUrl', new Twig_Filter_Function('cleanForShortURL'));
        $twig->addGlobal("session", $_SESSION);
                return $twig->render($template, $this->data);
    }
    
}

?>
