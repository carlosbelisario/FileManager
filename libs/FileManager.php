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
     * @var char $mode
     */
    private $mode;
    
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
     */
    public function delete() 
    {
        unlink($this->file->getRealPath());
    }
    
    
    public function read() {
        
    }

    public function save() 
    {
        
    }
    
    /**
     * 
     * @method update     
     * @description update the file in the line indicated 
     * @param int $key
     * @param string $line
     * @throws Exception 
     * 
     */
    public function update($key, $line) 
    {
        $this->file->fseek($key);        
        $arrayFile = $this->file->getContent();
        if(isset($arrayFile[$key])) {
            $arrayFile[$key] = $line;
            $file = implode("\n", $arrayFile);
            $this->changeMode('w');
            $this->file->fwrite($file);
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
     * 
     */
    public function addNewLine($str)
    {
        if($this->file->isWritable()) {
            if('a' == $this->mode) {
                $this->file->fwrite("\n" .$str);
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
     * @throws Exception if the file is not writable
     */
    public function write($line) 
    {        
        if($this->file->isWritable()) {            
            if('w' == $this->mode) {
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
        $this->mode = $mode;
        $this->file = $this->file->openFile($mode);                
    }
    
}