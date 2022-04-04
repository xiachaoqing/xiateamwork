<?php
/**
 * The openprocess view file of cron module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     cron
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<script>
$(function()
{
    startCron(1);
    setTimeout(function(){parent.location.href = parent.location.href}, 300);
});
</script>
</body>
</html>
