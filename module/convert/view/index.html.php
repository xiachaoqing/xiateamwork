<?php
/**
 * The html template file of index method of convert module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     ZenTaoPMS
 * @version     $Id: index.html.php 4129 2013-01-18 01:58:14Z wwccss $*/
?>
<?php include '../../common/view/header.html.php';?>
<div class='container mw-700px'>
  <div id='titlebar'>
    <div class='heading'>
      <span class='prefix'><?php echo html::icon('cloud-upload');?></span>
      <strong><?php echo $lang->convert->common;?></strong>
    </div>
  </div>
  <div class='alert mg-0 bd-0'>
    <div class='content'>
      <?php echo nl2br($lang->convert->desc);?>
      <div class='text-center pdt-20'>
        <?php echo html::a($this->createLink('convert', 'selectsource'), $lang->convert->start, '', 'class="btn btn-primary"');?>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
