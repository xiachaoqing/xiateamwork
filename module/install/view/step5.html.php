<?php
/**
 * The html template file of index method of install module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     ZenTaoPMS
 * @version     $Id: step5.html.php 2568 2012-02-18 15:53:35Z zhujinyong@cnezsoft.com$*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <div class='modal-dialog'>
    <div class='modal-header'>
      <strong><?php echo $lang->install->success;?></strong>
    </div>
    <div class='modal-body'>
      <div class='alert with-icon alert-pure'>
        <i class='icon-check-circle'></i>
        <div class='content'><?php echo nl2br(sprintf($lang->install->joinZentao, $config->version, $this->createLink('admin', 'register'), $this->createLink('admin', 'bind'), inlink('step6')));?></div>
      </div>
    </div>
    <div class='modal-footer'>
      <?php 
      echo html::a($lang->install->officeDomain, $lang->install->register, '_blank', "class='btn btn-success'");
      echo "<span class='text-muted'> &nbsp; " . $lang->install->or . ' &nbsp; </span>';
      echo html::a('index.php', $lang->install->login, '', "class='btn btn-primary'");
      ?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
