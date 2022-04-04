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
        <strong><?php echo $lang->upgrade->consistency;?></strong>
      </div>
      <div class='modal-body'>
        <h4><?php echo $lang->upgrade->noticeSQL;?></h4>
        <p class='text-danger code'>
          SET @@sql_mode= '';<br />
          <?php echo nl2br($alterSQL);?>
        </p>
      </div>
      <div class='modal-footer'><?php echo html::a('#', $this->lang->refresh, '', "class='btn' onclick='location.reload()'");?></div>
    </div>
  </form>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
