<?php
/**
 * The detect view file of mail module of ZenTaoPMS.
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
        <small class='text-muted'> <?php echo $lang->arrow . $lang->mail->detect;?></small>
      </h2>
    </div>
    <form class='pdt-20' method='post' target='hiddenwin'>
      <table class='table table-form'>
        <tr><th style='width:140px'><?php echo $lang->mail->inputFromEmail; ?></th><td class='w-p50'><?php echo html::input('fromAddress', $fromAddress, "class='form-control'");?></td><td><?php echo html::submitButton($lang->mail->nextStep, '', 'btn btn-primary');?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
