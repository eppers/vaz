<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 20.04.14
 * Time: 19:40
 */

namespace Acme;

class File {

    protected static $maxSize = 2097152;
    protected static $typeAllowed = array('pdf');
    protected $workspace;
    protected $fileName;
    protected $filePath;

    public function __construct($file,$workspace) {
        $this->workspace = $workspace;
        $fileType = substr(strrchr($file['file']['name'],'.'),1);
        $this->fileName = md5(uniqid(rand(), true)).'.'.$fileType;
        $this->filePath = $workspace . $this->fileName;
        move_uploaded_file($file["file"]["tmp_name"], $this->filePath);
    }

    public static function load($file,$workspace) {
        try {
            $fileType = substr(strrchr($file['file']['name'],'.'),1);
            self::isFileCorrect($file);
            self::isTypeAllowed($fileType);
            self::checkWorkspace($workspace);
            return new File($file,$workspace);
        } catch (\NotFoundException $unfe) {
            return $unfe;
        }
    }


    protected static function isFileCorrect($files) {
        if (isset($files['file']['error']) && $files['file']['error'] != 0)
            throw new \Exception('Błąd pliku - wybierz plik');
        else if (!isset($files['file']['tmp_name']) || !@is_uploaded_file($files['file']['tmp_name']))
            throw new \Exception('Błąd pliku - test us_uploaded_file');
        else if (!isset($files['file']['name']))
            throw new \Exception('Błąd pliku - brak nazwy');
    }

    protected static function isTypeAllowed($fileType) {
        if(!in_array($fileType, self::$typeAllowed))
            throw new \Exception('Niewłaściwe rozszerzenie pliku'.$filetype);
    }

    protected static function checkWorkspace($workspace) {
        if (!file_exists($workspace)) {
            @mkdir($workspace, 0777);
        };
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }



    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

} 