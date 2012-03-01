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
     * @var String 
     */
    private $line;
    
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
     * @override
     * @param string $file_name
     * @param string $open_mode
     * @param string $use_include_path
     * @param array $context 
     * 
     */
    public function __construct($file_name, $open_mode = 'r', $use_include_path = false, array $context = array()) {
        parent::__construct($file_name, $open_mode, $use_include_path, stream_context_create($context));        
	$this->openMode = $open_mode;
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
     * @return integer 
     */
    public function getLine() 
    {
        return $this->key();
    }

    /**
     *
     * @param integer $line 
     */
    public function setLine($line) 
    {
        $this->line = $line;
    }    
    
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
     * @description if is empty return true, else return false
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


}
