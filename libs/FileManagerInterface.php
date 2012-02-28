<?php

/**
 * Interface for the manage the file
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 * @version 1.0
 */
interface FileManagerInterfaces
{
    /**
     * 
     * @method write in the file 
     * @param string $line
     * 
     */
    public function write($line);
    
    /**
     * 
     * @method read the file  
     * 
     */
    public function read();
    
    /**
     * 
     * @method delete the file 
     * @param String $file
     * 
     */
    public function delete();
    
    /**
     * 
     * @method update the file 
     * @param integer $line the line of edit
     *      
     */
    public function update($key, $line);
    
    /**
     * 
     * @method save for write or update the file     
     */
    public function save();
}

?>
