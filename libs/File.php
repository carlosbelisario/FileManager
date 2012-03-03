<?php
namespace FileManager\Libs;

/**
 * class File
 *
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 * @version 1.0
 * @copyright Carlos Belisario 
 */
class File extends \SplFileObject
{
    /**
     *
     * @var String 
     */
    private $type;
    
    /**
     *
     * @var array
     */
    private $content;    
    
    /**
     *
     * @var int
     */
    private $permission;

     /**
     *
     * @var char $modeOpen
     */
    private $openMode;
    
    /**
     *
     * @var boolean $firstLineIsFields
     */
    private $firstLineIsFields;

    /**
     * @override
     * @param string $file_name
     * @param string $open_mode
     * @param string $use_include_path     
     * @param array $context 
     * @param boolean $firstLineIsFields
     * 
     */
    public function __construct($file_name, $open_mode = 'r', $use_include_path = false, array $context = array(), $firstLineIsFields = true) {
        parent::__construct($file_name, $open_mode, $use_include_path, stream_context_create($context));        
	$this->openMode = $open_mode;        
        $this->firstLineIsFields = $firstLineIsFields;
    }
    
    /**
     * Getter $firstLineIsFields
     * @return boolean 
     */
    public function getFirstLineIsFields() 
    {        
        return $this->firstLineIsFields;
    }

    /**
     *
     * @return string 
     */
    public function getType() 
    {        
        $this->type = $this->getExtension();
        return $this->type;        
    }
   

    /**
     *
     * @return array
     */
    public function getContent() 
    {
        while(!$this->eof()) {
            $this->content[] = $this->fgets();
            $this->next();
        }
        return $this->content;
    }    

    
    
    /**
     *
     * @return int
     */
    public function getPermission()
    {
       return $this->getPerms();
    }

    /**
     *
     * @param char $openMode
     */
    public function setOpenMode($openMode)
    {
       $this->openMode = $openMode;
       return $this;
    }

    /**
     *
     * Getter modeOpen
     * @return char
     */
    public function getOpenMode($openMode)
    {
       return $this->openMode;
    }

    /**
     *
     * @method isEmpty
     * @description if the content of the file is empty return true, else return false
     * @return bool
     */
    public function isEmpty()
    {
	  $lineLength = count($this->getContent());
	  if($lineLength == 0) {
	       return true;
 	  } else {
	     return false;
	   }
    }
    /**
     * @method getFileName     
     * @param bool $returnPath
     * @return string 
     */
    public function getFileName($returnPath = true)
    {
        if($returnPath) {
            return $this->getRealPath();
        } else {
            return $this->getBasename();
        }
    }    

}