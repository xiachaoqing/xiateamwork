<?php
/**
 * The index view file of product module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     product
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.html.php';?>
<?php if(empty($products)):?>
<div class="table-empty-tip">
  <p><span class="text-muted"><?php echo $lang->product->noProduct;?></span> <?php common::printLink('product', 'create', '', "<i class='icon icon-plus'></i> " . $lang->product->create, '', "class='btn btn-info'");?></p>
</div>
<?php else:?>
<?php echo $this->fetch('block', 'dashboard', 'module=product');?>
<?php endif;?>
<?php include '../../common/view/footer.html.php';?>
