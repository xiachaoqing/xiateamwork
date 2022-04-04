<?php
/**
 * The html template file of execute method of upgrade module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     upgrade
 * @version     $Id: execute.html.php 5119 2019-03-11 08:06:42Z wyd621@gmail.com $*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <div class='modal-dialog'>
    <div class='modal-header'>
      <strong><?php echo $lang->upgrade->result;?></strong>
    </div>
    <div class='modal-body'>
      <?php if($result == 'fail'):?>
      <div class='alert alert-danger mgb-10'><strong><?php echo $lang->upgrade->fail?></strong></div>
      <pre><?php echo join('<br />', $errors);?></pre>
      <?php endif;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
