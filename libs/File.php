<?php

/**
 * class File
 *
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 * @version 1.0
 * @copyright Carlos Belisario 
 */
class File extends SplFileObject
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
     * @override
     * @param string $file_name
     * @param string $open_mode
     * @param string $use_include_path
     * @param string $context 
     * 
     */
    public function __construct($file_name, $open_mode = 'r', $use_include_path = false, $context = array()) {
        parent::__construct($file_name, $open_mode, $use_include_path, stream_context_create($context));        
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
}