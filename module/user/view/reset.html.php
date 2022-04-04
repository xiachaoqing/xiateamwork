<?php
/**
 * The reset view file of user module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     user
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<?php if($needCreateFile):?>
<div class='container mw-700px' style='margin-top:100px;'>
  <div class='panel panel-default'>
    <div class='panel-heading'>
    <strong><?php echo $lang->user->resetPassword?></strong>
    </div>
    <div class='panel-body'>
      <div class='alert alert-info'>
      <?php printf($lang->user->noticeResetFile, $resetFileName);?>
      </div>
      <div class='text-center'><?php echo html::a(inlink('reset'), $this->lang->refresh, '', "class='btn btn-primary btn-wide'")?></div>
    </div>
  </div>
</div>
<?php elseif($status == 'reset'):?>
<div class='container mw-500px' style='margin-top:50px;'>
  <div class='panel'>
    <div class='panel-heading'>
    <strong><?php echo $lang->user->resetPassword?></strong>
    </div>
    <form method='post' target='hiddenwin'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->user->account?></th>
          <td><?php echo html::input('account', '', "class='form-control'")?></td>
        </tr>
        <tr>
          <input type='password' style="display:none"> <!-- Disable input password by browser automatically. -->
          <th><?php echo $lang->user->password?></th>
          <td><?php echo html::password('password1', '', "class='form-control'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->password2?></th>
          <td><?php echo html::password('password2', '', "class='form-control'")?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton()?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php endif;?>
<?php include '../../common/view/footer.lite.html.php';?>

