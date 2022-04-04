<?php
/**
 * The html template file of index method of index module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     ZenTaoPMS
 * @version     $Id: index.html.php 1947 2011-06-29 11:58:03Z wwccss $*/
?>
<?php include '../../common/view/header.html.php';?>
<?php echo $this->fetch('block', 'dashboard', 'module=my');?>
<?php include '../../common/view/footer.html.php';?>
