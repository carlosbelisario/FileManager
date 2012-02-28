<?php
require_once 'FileManagerInterface.php';
require_once 'File.php';
/**
 * Class FileManager for manager the file
 *
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 * @version 1.0 
 */
class FileManager implements FileManagerInterfaces
{
    /**
     *
     * @var File
     */
    private $file;
    

    /**
    *
    * @method __construct
    * @description contruct the FileManager class, get the mode to "r" because is the mode initial of the construct of the File
    */
    public function __construct() 
    {
        $this->mode = 'r';
    }
    
    /**
     * Setter of the file
     * @param File $file
     * @return \FileManager
     * @throws Exception is a not valid file
     */
    public function setFile(File $file)
    {        
        if($file->isFile()) {
            $this->file = $file;
        } else {
            throw new Exception('the file is not valid');
        }
        return $this;        
    }
    
    /**
     * Getter of the file
     * @return File 
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * @method delete
     * @description delete the file if the user have permission
     * @void     
     * @waring if not have permission return a warning
     */
    public function delete() 
    {
        unlink($this->file->getRealPath());
    }
    
    
    public function read() 
    {
        $file = $this->file->getContent();
	if(!empty($file)) {
	    foreach($file as $line) {
	    	echo nl2br($line);
	    }
	} else {
	   die('The file was empty');
	}
    }

    /**
     * 
     * @method save
     * @description write or update switch case
     * @param string $str
     * @param int $key
     * @throws Exception 
     * @return int
     * 
     */	
    public function save($str, $key = null) 
    {
        if($this->file->isEmpty()) {
	    return $this->write($str);
	} else {
	    if(!is_null($key)) {
		return $this->update($key, $str);
	    } else {
		return $this->write($str);
	    }
	}
    }
    
    /**
     * 
     * @method update     
     * @description update the file in the line indicated, return true if is done and false if not done
     * @param int $key
     * @param string $line
     * @throws Exception 
     * @return int
     * 
     */
    public function update($key, $line) 
    {
        $arrayFile = $this->file->getContent();
        if(isset($arrayFile[$key])) {
            $arrayFile[$key] = $line;
            $file = implode("\n", $arrayFile);
            $this->changeMode('w');
            return $this->file->fwrite($file);		
        } else {
            throw new Exception('The line not exist');
        }        
    }
    
    /**
     * 
     * @method addNewLine
     * @description add a new line in the file
     * @param String $str
     * @throws Exception 
     * @return int
     */
    public function addNewLine($str)
    {
        if($this->file->isWritable()) {
            if('a' == $this->file->getModeOpen()) {
		 return $this->file->fwrite("\n" .$str);
            } else {
                throw new Exception('the mode must be a');
            }
        } else {
            throw new Exception('The file is not writable');
        }
    }

    /**
     * @method write
     * @desc write a new content in the file, this method truncate the file and write a new content
     * @param string $line
     * @return int
     * @throws Exception if the file is not writable
     */
    public function write($line) 
    {        
        if($this->file->isWritable()) {            
            if('w' == $this->file->getModeOpen()) {
                return $this->file->fwrite($line);
            } else {
                die('the mode must be w');
            }
        } else {
            throw new Exception('The file is not writable');
        }
        return $this;
    }    
    
    /**
     *  
     * @method changeMode
     * @description change the mode in that the file is opened
     * @param char $mode 
     */
    public function changeMode($mode)
    {        
        $this->file->setOpenMode($mode);
        $this->file = $this->file->openFile($mode);                
	return $this;
    }    
}
