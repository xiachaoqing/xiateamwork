<?php
/**
 * The computeburn view file of project module of ZenTaoPMS.
 *

 * @author      Fu Jia <fujia@cnezsoft.com>
 * @package     project
 * @version     $Id: computeburn.html.php 4129 2013-01-18 01:58:14Z wwccss $
*/
?>
<?php
foreach($burns as $burn)
{
    echo $burn->project . "\t" . $burn->projectName . "\t" . $burn->date . "\t" . $burn->left . "\n";
}
?>
