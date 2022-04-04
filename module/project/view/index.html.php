<?php
/**
 * The html template file of index method of index module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     ZenTaoPMS
 * @version     $Id: index.html.php 5094 2013-07-10 08:46:15Z 631753810@qq.com $*/
?>
<?php include '../../common/view/header.html.php';?>
<?php if(empty($projects)):?>
<div class="table-empty-tip">
  <p><span class="text-muted"><?php echo $lang->project->noProject;?></span> <?php common::printLink('project', 'create', '', "<i class='icon icon-plus'></i> " . $lang->project->create, '', "class='btn btn-info'");?></p>
</div>
<?php else:?>
<?php echo $this->fetch('block', 'dashboard', 'module=project');?>
<?php endif;?>
<?php include '../../common/view/footer.html.php';?>
