<?php
/**
 * The edit view of group module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     group
 * @version     $Id: edit.html.php 4129 2013-01-18 01:58:14Z wwccss $
*/
?>
<?php include '../../common/view/header.html.php';?>
<div id='mainContent' class='main-content'> 
  <div class='main-header'>
    <h2 title='<?php echo $group->name;?>'>
      <span class='label label-id'><?php echo $group->id;?></span>
      <?php echo $group->name;?>
      <small><?php echo $lang->arrow . $lang->group->edit;?></small>
    </h2>
  </div>
  <form method='post' target='hiddenwin' id='dataform'>
    <table align='center' class='table table-form'> 
      <tr>
        <th><?php echo $lang->group->name;?></th>
        <td><?php echo html::input('name', $group->name, "class='form-control'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->group->desc;?></th>
        <td><?php echo html::textarea('desc', $group->desc, "rows='5' class='form-control'");?></td>
      </tr>  
      <tr>
        <td colspan='2' class='text-center'><?php echo html::submitButton();?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>