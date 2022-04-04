<?php
/**
 * The ztcomany view file of admin module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     admin
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block mw-500px'>
    <div class='main-header'>
      <h2><?php echo $lang->admin->ztCompany;?></h2>
    </div>
    <form method='post' target='hiddenwin'>
      <table class='table table-form'>
        <?php foreach($fields as $field):?>
        <tr>
          <th><?php echo $field == 'company' ? $lang->company->name : $lang->user->$field;?></th>
          <td><?php echo html::input($field, '', "class='form-control'");?></td>
        </tr>
        <?php endforeach;?>
        <tr>
          <td colspan='2' class='text-center'><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
