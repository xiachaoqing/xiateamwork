<?php
/**
 * The createlib view of testsuite module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     testsuite
 * @version     $Id: create.html.php 4728 2013-05-03 06:14:34Z 631753810@qq.com $
*/
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id="mainContent" class="main-content">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->testsuite->createLib;?></h2>
    </div>
    <form class="load-indicator main-form form-ajax" id="createForm" method="post" target='hiddenwin'>
      <table class="table table-form">
        <tr>
          <th><?php echo $lang->testsuite->name;?></th>
          <td><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->testsuite->desc;?></th>
          <td><?php echo html::textarea('desc', '', "rows=10 class='form-control'");?></td>
        </tr>
        <tr>
          <td class='text-center form-actions' colspan='2'>
            <?php echo html::submitButton();?>
            <?php echo html::backButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
