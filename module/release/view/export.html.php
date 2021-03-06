<?php
/**
 * The export stories or bugs to html view file of release module of ZenTaoPMS.
 *

 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     file
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<script>
function setDownloading()
{
    if($.browser.opera) return true;   // Opera don't support, omit it.

    $.cookie('downloading', 0);
    time = setInterval("closeWindow()", 300);
    return true;
}

function closeWindow()
{
    if($.cookie('downloading') == 1 || i >= 30)
    {
        parent.$.closeModal();
        $.cookie('downloading', null);
        clearInterval(time);
    }
    i ++;
}
</script>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2><?php echo $lang->export;?></h2>
  </div>
  <form method='post' target='hiddenwin' onsubmit='setDownloading();' style='padding: 10px 5%'>
    <table class='w-p100'>
      <tr>
        <td>
          <div class='input-group'>
            <span class='input-group-addon'><?php echo $lang->setFileName;?></span>
            <?php echo html::input('fileName', '', "class='form-control'");?>
            <span class='input-group-addon'>.html</span>
            <?php echo html::select('type', $lang->release->exportTypeList, 'all', "class='form-control'")?>
          </div>
        </td>
        <td><?php echo html::submitButton($lang->export, '', 'btn btn-primary');?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
