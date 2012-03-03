<?php
namespace FileManager\Libs;
require_once 'FileManagerInterface.php';
require_once 'File.php';
require_once 'FileManagerException.php';

use FileManagerInterface;
use FileManagerException;
use FileManager\Libs\File;
/**
 * Class FileManager for manager the file
 *
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 * @version 1.0 
 * @copyright Carlos Belisario 2012
 *
 * This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
        if(!$file->isFile()) {
            throw new FileManagerException('the file is not valid');            
        } 
        $this->file = $file;
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
        if(!$this->file->isWritable()) {
            throw new FileManagerException('Permission denied The File is not writable');
        }
        unlink($this->file->getRealPath());
    }
    
    /**
    *
    * @method read
    * @description this method return all content of a file in a array
    * @param void
    * @return array
    * @throw FileManagerException if the file is empty
    */
    public function read() 
    {
       $arrayFileContent = $this->file->getContent();
	   if($this->file->isEmpty()) {
	       throw new FileManagerException("The file was empty");               
	   } 
       return $arrayFileContent;
    }

    /**
     * 
     * @method save
     * @description write or update switch case
     * @param string $str
     * @param int $key     
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
     * @throws FileManagerException if the line does not exist 
     * @return int
     * 
     */
    public function update($key, $line) 
    {
        $arrayFile = $this->file->getContent();
        if(!isset($arrayFile[$key])) {
            throw new FileManagerExecption('The line not exist');            
        } 
        $arrayFile[$key] = $line;
        $file = implode("\n", $arrayFile);
        $this->changeMode('w');
        return $this->file->fwrite($file);      
    }
    
    /**
     * 
     * @method addNewLine
     * @description add a new line in the file
     * @param String $str
     * @throws FileManagerException if the file does not is writable or the open mode not is a
     * @return int
     */
    public function addNewLine($str)
    {
        if(!$this->file->isWritable()) {
            throw new FileManagerException('The file is not writable');    
        }
        if('a' != $this->file->getModeOpen()) {                
            throw new FileManagerException('the mode must be a');
        }        
        return $this->file->fwrite("\n" . $str);
    }


    /**
     * @method write
     * @desc write a new content in the file, this method truncate the file and write a new content
     * @param string $line
     * @return int
     * @throws FileManagerException if the file is not writable or if the open mode not is w
     */
    public function write($line) 
    {        
        if(!$this->file->isWritable()) {
            throw new FileManagerException('The file is not writable');
            
        }
        if('w' != $this->file->getModeOpen()) {
            throw new FileManagerException('The mode must be w');
            
        }
        return $this->file->fwrite($line);        
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

    /**
    *
    * @method findLine
    * @description this method return the content of the line indicated in the param
    * @param int $line
    * @return String
    * @throw FileManagerExeption is the line does not exist in the content of the file
    */

    public function findLine($line)
    {
        try {
            $content = $this->file->getContent();
            return $content[$line];
        } catch(FileManagerException $e) {
            $e->getMessage();
        }
    }    
    
    /**
     * @method firstLineFields
     * @description say if the first line of the file is the container of the fields     * 
     * @param boolean $isFields
     * @return boolean 
     */
    public function firstLineFields()
    {
        if($this->file->getFirstLineIsFields()) {
            return true;
        } else {
            return false;
        }
    }
    
   
}