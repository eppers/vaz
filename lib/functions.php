<?php

$GLOBALS['normalizeChars'] = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 
    'Å'=>'A', 'Ą'=>'A', 
    'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ę'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 
    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'ę'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 
    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
    //PL
    'Ą'=>'A', 'Ć'=>'C', 'Ę'=>'E', 'Ł'=>'L', 'Ń'=>'N', 'Ó'=>'O', 'Ś'=>'S', 'Ź'=>'Z', 'Ż'=>'Z',
    'ą'=>'a', 'ć'=>'c', 'ę'=>'e', 'ł'=>'l', 'ń'=>'n', 'ó'=>'o', 'ś'=>'s', 'ź'=>'z', 'ż'=>'z'
);
 
function cleanForShortURL($toClean) {
    $toClean     =     str_replace('&', '-and-', $toClean);
    $toClean = strtr($toClean, $GLOBALS['normalizeChars']);
    $toClean     =    trim(preg_replace('/[^\w\d_ -]/si', '', $toClean));//remove all illegal chars
    $toClean     =     str_replace(' ', '-', $toClean);
    $toClean     =     str_replace('--', '-', $toClean);
    
   
    

    
    if (function_exists('mb_strtolower')) { 
     return mb_strtolower($toClean); 
   } else { 
     return strtolower($toClean); 
   } 
   
}

function clearName($name) {
    $allow = '/[^\p{L}\s0-9]/u';
    $name = preg_replace($allow, "", $name);
    
    return $name;
}

function prepareHtmlToDb($string) {

        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

    return htmlspecialchars(str_replace($search, $replace, $string));
}

function prepareDbToHtml($string) {
    $search = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
    $replace = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");

    return str_replace($search, $replace, htmlspecialchars_decode($string));
}


?>
