<?php
/**
 * The suspend file of project module of ZenTaoPMS.
 *

 * @author      Chunsheng Wang<wwccss@gmail.com>
 * @package     project 
 * @version     $Id: suspend.html.php 935 2013-01-16 07:49:24Z wwccss@gmail.com $
*/
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2>
      <span class='prefix label-id'><strong><?php echo $project->id;?></strong></span>
      <?php echo isonlybody() ? ("<span title='$project->name'>" . $project->name . '</span>') : html::a($this->createLink('project', 'view', 'project=' . $project->id), $project->name, '_blank');?>
      <?php if(!isonlybody()):?>
      <small> <?php echo $lang->arrow . $lang->project->close;?></small>
      <?php endif;?>
    </h2>
  </div>
  <form class='load-indicator main-form' method='post' target='hiddenwin'>
    <table class='table table-form'>
      <tbody>
        <tr>
          <th class='w-50px'><?php echo $lang->comment;?></th>
          <td><?php echo html::textarea('comment', '', "rows='6' class='form-control kindeditor' hidefocus='true'");?></td>
        </tr>
        <tr>
          <td class='text-center form-actions' colspan='2'><?php echo html::submitButton() . html::linkButton($lang->goback, $this->session->taskList, 'self', '', 'btn btn-wide'); ?></td>
        </tr>
      </tbody>
    </table>
  </form>
   <hr class='small' />
  <div class='main'><?php include '../../common/view/action.html.php';?></div>
</div>
<?php include '../../common/view/footer.html.php';?>
