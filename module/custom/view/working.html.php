<?php
/**
 * The set view file of custom module of ZenTaoPMS.
 *

 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     custom
 * @version     $Id$
*/
?>
<?php include 'header.html.php';?>
<div id='mainContent' class='main-content'>
  <form class="load-indicator main-form form-ajax" method='post'>
    <div class='main-header'>
      <div class='heading'>
        <strong><?php echo $lang->custom->working?></strong>
      </div>
    </div>
    <table class='table table-form'>
      <tr>
        <th class='text-top'><?php echo $lang->custom->working;?></th>
        <td>
          <?php $checkedKey = isset($config->global->flow) ? $config->global->flow : 'full';?>
          <?php foreach($lang->custom->workingList as $key => $value):?>
          <p><label class="radio-inline"><input type="radio" name="flow" value="<?php echo $key?>"<?php echo $key == $checkedKey ? " checked='checked'" : ''?> id="flow<?php echo $key;?>"><?php echo $value;?></label></p>
          <?php endforeach;?>
        </td>
      </tr>
      <tr><td></td><td><?php echo html::submitButton()?></td></tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
