<?php
/**
 * The save view file of mail module of ZenTaoPMS.
 *

 * @author      Chunsheng Wang <wwccss@cnezsoft.com>
 * @package     mail
 * @version     $Id$
*/
?>
<?php include $this->app->getModuleRoot() . 'message/view/header.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block mw-700px'>
    <div class='main-header'>
      <h2>
        <?php echo $lang->mail->common;?>
        <small class='text-success'> <?php echo $lang->saveSuccess;?> <?php echo html::icon('check-circle');?></small>
      </h2>
    </div>
    <div class='alert alert-block with-icon'>
      <div class='content'>
        <?php echo $lang->mail->successSaved;?>
        <?php if($this->post->turnon and $mailExist) echo html::a(inlink('test'), $lang->mail->test . ' <i class="icon-rocket"></i>', '', "class='btn btn-primary btn-sm'");?>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
