<?php
/**
 * The mail file of bug module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     bug
 * @version     $Id: sendmail.html.php 4626 2013-04-10 05:34:36Z 631753810@qq.com $
*/
?>
<?php $mailTitle = 'BUG #' . $bug->id . ' ' . $bug->title;?>
<?php include $this->app->getModuleRoot() . 'common/view/mail.header.html.php';?>
<tr>
  <td>
    <table cellpadding='0' cellspacing='0' width='600' style='border: none; border-collapse: collapse;'>
      <tr>
        <td style='padding: 10px; background-color: #F8FAFE; border: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid #e5e5e5;'>
          <?php $color = empty($bug->color) ? '#333' : $bug->color;?>
          <?php echo html::a(zget($this->config->mail, 'domain', common::getSysURL()) . helper::createLink('bug', 'view', "bugID=$bug->id", 'html'), $mailTitle, '', "style='color: {$color}; text-decoration: underline;'");?>
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td style='padding: 10px; border: none;'>
    <fieldset style='border: 1px solid #e5e5e5'>
      <legend style='color: #114f8e'><?php echo $this->lang->bug->legendSteps;?></legend>
      <div style='padding:5px;'><?php echo $bug->steps;?></div>
    </fieldset>
  </td>
</tr>
<?php include $this->app->getModuleRoot() . 'common/view/mail.footer.html.php';?>
