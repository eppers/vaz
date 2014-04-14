<?php

    /*** nullify any existing autoloads ***/
    spl_autoload_register(null, false);

    /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php');

    function libLoader($class)
    {
        $filename = filePath($class);
        $file ='../lib/' . $filename;
        if (!file_exists($file))
        {
            return false;
        }
        include $file;
    }

    function modelLoader($class)
    {
        $filename = filePath($class);
        $file ='../models/' . $filename;
        if (!file_exists($file))
        {
            return false;
        }
        include $file;
    }




    function filePath($className)
    {
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    return $fileName;
    }

    /*** register the loader functions ***/
    spl_autoload_register('libLoader');
    spl_autoload_register('modelLoader');
?>