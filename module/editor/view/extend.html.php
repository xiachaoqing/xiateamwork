<?php
/**
 * The editor view file of dir module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     editor
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='main-header'>
  <div class='heading'><i class='icon-list-ul'></i> <strong><?php echo isset($lang->editor->modules[$module])? $lang->editor->modules[$module] : $module;?></strong></div>
</div>
<div class='main-content'>
  <?php echo $tree?>
</div>
<script>
$(function()
{
    $('.hitarea').click(function()
    {
        var $this  = $(this);
        var parent = $this.parent();
        if(parent.hasClass('expandable'))
        {
            parent.removeClass('expandable').addClass('collapsable');
            $this.removeClass('expandable-hitarea').addClass('collapsable-hitarea');
        }
        else
        {
            parent.addClass('expandable').removeClass('collapsable');
            $this.addClass('expandable-hitarea').removeClass('collapsable-hitarea');
        }
    });
});
</script>
<iframe frameborder='0' name='hiddenwin' id='hiddenwin' scrolling='no' class='hidden'></iframe>
<body>
</html>
