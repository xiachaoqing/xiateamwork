<?php
/**
 * The timezone view file of custom module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     custom
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.html.php';?>
<div id='mainMenu' class='clearfix'>
  <div class='btn-toolbar pull-left'><?php common::printAdminSubMenu('system');?></div>
</div>
<div id='mainContent' class='main-content'>
  <div class='center-block mw-500px'>
    <?php if(!function_exists('date_default_timezone_set')):?>
    <div class='alert alert-warning'><?php echo $lang->custom->notice->cannotSetTimezone;?></div>
    <?php else:?>
    <?php include $this->app->getConfigRoot() . 'timezones.php';?>
    <form class="load-indicator main-form form-ajax" method='post'>
      <table class='table table-form'>
        <tr>
          <th class='w-80px'><?php echo $lang->custom->timezone;?></th>
          <td><?php echo html::select('timezone', $timezoneList, $config->timezone, "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <td colspan='2' class='form-actions text-center'><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
    <?php endif;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>

