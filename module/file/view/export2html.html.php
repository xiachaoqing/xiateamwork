<?php
/**
 * The export2html view file of file module of ZenTaoPMS.
 *

 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     file
 * @version     $Id$
*/
?>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<style>
table, th, td{font-size:12px; border:1px solid gray; border-collapse:collapse;}
table th,table td{padding:5px;}
</style>
<title><?php echo $fileName;?></title>
<body>
<?php if($this->post->kind == 'task') echo "<font color='red'>" . $this->lang->file->childTaskTag . '</font>';?>
<table>
  <tr>
  <?php
  foreach($fields as $fieldLabel)
  {  
      echo "<th><nobr>$fieldLabel</nobr></th>\n";
  }
  ?>
  </tr>
<?php
$rowspans = $this->post->rowspan ? $this->post->rowspan : array();
$colspans = $this->post->colspan ? $this->post->colspan : array();
$i = 0;
foreach($rows as $row)
{
    echo "<tr valign='top'>\n";
    $col        = 0;
    $endColspan = 0;
    foreach($fields as $fieldName => $fieldLabel)
    {
        $col ++;
        if(!empty($endColspan) and $col < $endColspan) continue;
        if(isset($endRowspan[$fieldName]) and $i < $endRowspan[$fieldName]) continue;
        $fieldValue = isset($row->$fieldName) ? $row->$fieldName : '';
        $rowspan = '';
        if(isset($rowspans[$i]) and strpos($rowspans[$i]['rows'], $fieldName) !== false)
        {
            $rowspan = "rowspan='{$rowspans[$i]['num']}'";
            $endRowspan[$fieldName] = $i + $rowspans[$i]['num'];
        }
        $colspan = '';
        if(isset($colspans[$i]) and strpos($colspans[$i]['cols'], $fieldName) !== false)
        {
            $colspan = "colspan='{$colspans[$i]['num']}'";
            $endColspan = $col + $colspans[$i]['num'];
        }
        echo "<td $rowspan $colspan><nobr>$fieldValue</nobr></td>\n";

    }
    echo "</tr>\n";
    $i++;
}
?>
</table>
</body>
</html>
