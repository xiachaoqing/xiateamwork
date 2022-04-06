<?php
/**
 * @author        XCQ
 * @package     admin
 * @version       1.0
*/
?>
<?php include '../../common/view/header.html.php';?>
<div id='mainContent' class='main-content'>
  <?php if(!$bind and !$ignore and common::hasPriv('admin', 'register')):?>
  <div id="notice" class='alert alert-success'>
    <?php echo html::a(inlink('ignore'), '<i class="icon-close icon-sm"></i> ' . $lang->admin->notice->ignore, 'hiddenwin', 'class="close" data-dismiss="alert" style="font-size: 12px"');?>
    <div class="content"><i class='icon-exclamation-sign'></i> <?php echo sprintf($lang->admin->notice->register, html::a(inlink('register'), $lang->admin->register->click, '', 'class="alert-link"'));?></div>
  </div>
  <?php endif;?>

  <div class='main-header'>
    <h2>
      <?php
       echo '欢迎来到夏小石';
      // printf($lang->admin->info->version, $config->version);
      // if($bind) echo sprintf($lang->admin->info->account, '<span class="red">' . $account . '</span>');
      // echo $lang->admin->info->links;
      ?>
    </h2>
  </div>
  <!-- <?php include '../../misc/view/links.html.php';?> -->
</div>
<?php include '../../common/view/footer.html.php';?>
