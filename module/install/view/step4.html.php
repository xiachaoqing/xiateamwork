<?php
/**
 * The html template file of step4 method of install module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     ZenTaoPMS
 * @version     $Id: step4.html.php 4129 2013-01-18 01:58:14Z wwccss $*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <div class='modal-dialog'>
  <?php if(isset($error)):?>
    <div class='modal-header'>
      <strong><?php echo $lang->install->error;?></strong>
    </div>
    <div class='modal-body'>
      <div class='alert alert-danger alert-pure with-icon'>
        <i class='icon-exclamation-sign'></i>
        <div class='content'><?php echo $error;?></div>
      </div>
    </div>
    <div class='modal-footer'>
      <?php echo html::commonButton($lang->install->pre, "onclick='javascript:history.back(-1)'");?>
    </div>
  <?php elseif(isset($success)):?>
    <div class='modal-header'>
      <strong><?php echo $lang->install->success;?></strong>
    </div>
    <div class='modal-body'>
      <div class='alert alert-success alert-pure with-icon'>
        <i class='icon-check-circle'></i>
        <div class='content'><?php echo $afterSuccess;?></div>
      </div>
    </div>
    <div class='modal-footer'>
      <?php echo html::commonButton($lang->install->pre, "onclick='javascript:history.back(-1)'");?>
    </div>
  <?php else:?>
    <div class='modal-header'>
      <strong><?php echo $lang->install->getPriv;?></strong>
    </div>
    <div class='modal-body'>
      <form method='post' target='hiddenwin'>
        <table class='table table-form mw-400px' style='margin: 0 auto'>
          <tr>
            <th class='w-200px'><?php echo $lang->install->company;?></th>
            <td class='w-300px'><?php echo html::input('company', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->install->working;?></th>
            <td><?php echo html::select('flow', $lang->install->workingList, 'full', "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->install->account;?></th>
            <td><?php echo html::input('account', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->install->password;?></th>
            <td><?php echo html::input('password', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th></th><td><?php echo html::checkBox('importDemoData', $lang->install->importDemoData);?></td>
          </tr>
          <tr class='text-center'>
            <td colspan='2'><?php echo html::submitButton();?></td>
          </tr>
        </table>
      </form>
    </div>
  <?php endif;?>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
