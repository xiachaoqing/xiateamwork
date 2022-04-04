<?php
/**
 * The checkExtension view file of upgrade module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <form method='post'>
    <div class='modal-dialog'>
      <div class='modal-header'>
        <strong><?php echo $lang->upgrade->checkExtension;?></strong>
      </div>
      <div class='modal-body'>
      <?php echo $data;?>
      </div>
      <div class='modal-footer'><?php echo html::a(inlink('selectVersion'), $this->lang->upgrade->continue, '', "class='btn'");?></div>
    </div>
  </form>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
