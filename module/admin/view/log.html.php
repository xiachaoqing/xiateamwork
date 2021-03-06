<?php
/**
 * The log view file of admin module of ZenTaoPMS.
 *
 * @copyright   Copyright 夏小石
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     admin 
 * @version     $Id$
*/
?>
<?php include $this->app->getModuleRoot() . 'message/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block mw-600px'>
    <form id='logForm' method='post' class='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->admin->days;?></th>
          <td><?php echo html::input('days', $config->admin->log->saveDays, "class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td>
            <?php echo html::submitButton();?>
            <?php echo $lang->admin->info->log;?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
$(function(){$('#mainMenu #webhookTab').addClass('btn-active-text');})
</script>
<?php include '../../common/view/footer.html.php';?>
