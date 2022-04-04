<?php
/**
 * The change view file of backup module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     backup
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2><?php echo $lang->backup->change;?></h2>
  </div>
  <form method='post' target='hiddenwin' style='padding:10px 5%'>
    <table class='w-p100'>
      <tr>
        <td>
          <div class='input-group'>
            <?php echo html::input('holdDays', $config->backup->holdDays, "class='form-control'");?>
            <strong class='input-group-addon'><?php echo $lang->day;?></strong>
          </div>
        </td>
        <td><?php echo html::submitButton('', '', 'btn btn-primary');?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.lite.html.php';?>

