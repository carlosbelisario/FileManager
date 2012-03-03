<?php
namespace FileManager\Libs;

/**
 * class File
 *
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 * @version 1.0
 * @copyright Carlos Belisario 
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