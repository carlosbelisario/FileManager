<?php 
require_once 'FileManager.php';
$file = new FileManager\Libs\File('archivo.txt');
$content = $file->getContent();
foreach($content as $line => $lineContent) {
    $explodeFileLine[] = explode('|', $lineContent);
}?>
<table>
<?php 
foreach($explodeFileLine as $k =>$v) {?>
   <tr>
       <td><?php echo $k + 1;?></td>		
       <td><?php echo $v[0];?></td>
       <td><?php echo $v[1];?></td>
       <td><?php echo $v[2];?></td>
       <td><?php echo $v[3];?></td>
   </tr>
<?php }?>
</table>
