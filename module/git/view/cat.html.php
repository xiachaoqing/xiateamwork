<?php
/**
 * The cat view file of git module of ZenTaoPMS.
 *

 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     file
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='detail'>
  <div class='detail-title'><?php echo "$path@$revision";?></div>
  <div class='detail-content'><xmp><?php echo $code;?></xmp></div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
