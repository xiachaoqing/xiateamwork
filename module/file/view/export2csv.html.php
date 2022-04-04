<?php
/**
 * The export2csv view file of file module of ZenTaoPMS.
 *

 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     file
 * @version     $Id$
*/
?>
<?php
echo '"'. implode('","', $fields) . '"' . "\n";
foreach($rows as $row)
{
    echo '"';
    foreach($fields as $fieldName => $fieldLabel)
    {
        isset($row->$fieldName) ? print(str_replace('"', '“', htmlspecialchars_decode(strip_tags($row->$fieldName, '<img>')))) : print('');
        echo '","';
    }
    echo '"' . "\n";
}
if($this->post->kind == 'task') echo $this->lang->file->childTaskTips;
