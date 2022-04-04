<?php
/**
 * The manage privilege view of group module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     group
 * @version     $Id: managepriv.html.php 4129 2013-01-18 01:58:14Z wwccss $
*/
?>
<?php 
include '../../common/view/header.html.php';
if($type == 'byGroup')  include 'privbygroup.html.php';
if($type == 'byModule') include 'privbymodule.html.php';
include '../../common/view/footer.html.php';
