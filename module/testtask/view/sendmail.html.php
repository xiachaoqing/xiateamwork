<?php
/**
 * The mail file of testtesttask module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     bug
 * @version     $Id: sendmail.html.php 3717 2012-12-10 00:37:07Z zhujinyonging@gmail.com $
*/
?>
<?php $mailTitle = 'TESTTASK #' . $testtask->id . ' ' . $testtask->name;?>
<?php include $this->app->getModuleRoot() . 'common/view/mail.header.html.php';?>
<tr>
  <td>
    <table cellpadding='0' cellspacing='0' width='600' style='border: none; border-collapse: collapse;'>
      <tr>
        <td style='padding: 10px; background-color: #F8FAFE; border: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid #e5e5e5;'>
          <?php $color = empty($testtask->color) ? '#333' : $testtask->color;?>
          <?php echo html::a(zget($this->config->mail, 'domain', common::getSysURL()) . helper::createLink('testtask', 'view', "testtaskID=$testtask->id", 'html'), $mailTitle, '', "style='color: {$color}; text-decoration: underline;'");?>
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td style='padding: 10px; border: none;'>
    <fieldset style='border: 1px solid #e5e5e5'>
      <legend style='color: #114f8e'><?php echo $this->lang->testtask->desc;?></legend>
      <div style='padding:5px;'><?php echo $testtask->desc;?></div>
    </fieldset>
  </td>
</tr>
<?php include $this->app->getModuleRoot() . 'common/view/mail.footer.html.php';?>
