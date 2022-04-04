<?php
/**
 * The create view of testsuite module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     testsuite
 * @version     $Id: create.html.php 4728 2013-05-03 06:14:34Z 631753810@qq.com $
*/
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2><?php echo $lang->testsuite->create;?></h2>
    </div>
    <form class='load-indicator main-form form-ajax' method='post' target='hiddenwin' id='dataform'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->testsuite->name;?></th>
          <td><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->testsuite->desc;?></th>
          <td colspan='2'><?php echo html::textarea('desc', '', "rows=10 class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->testsuite->author;?></th>
          <td><?php echo html::radio('type', $lang->testsuite->authorList, 'private');?></td>
        </tr>
        <tr>
          <th></th>
          <td class='text-left form-actions' colspan='2'>
            <?php echo html::submitButton();?>
            <?php echo html::backButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
