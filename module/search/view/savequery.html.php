<?php
/**
 * The save query view file of search module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     search
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<form target='hiddenwin' method='post' style='padding: 15px 70px 15px 15px'>
  <div class='input-group'>
    <input name='title' id='title' class="form-control" autocomplete="off" type="text">
    <?php if($onMenuBar == 'yes'):?>
    <span class='input-group-addon'>
      <div class="checkbox-primary">
        <input type="checkbox" name="onMenuBar" value="1" id="onMenuBar" />
        <label for="onMenuBar"><?php echo $lang->search->onMenuBar?></label>
      </div>
    </span>
    <?php endif;?>
    <span class='input-group-btn'><?php echo html::submitButton('', '', 'btn btn-primary') . html::hidden('module', $module)?></span>
  </div>
</form>
<?php include '../../common/view/footer.lite.html.php';?>
