<?php
/**
 * The model file of dashboard module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     dashboard
 * @version     $Id: model.php 4129 2013-01-18 01:58:14Z wwccss $
*/
?>
<?php
class myModel extends model
{
    /**
     * Set menu.
     * 
     * @access public
     * @return void
     */
    public function setMenu()
    {
        /* Adjust the menu order according to the user role. */
        $flowModule = $this->config->global->flow . '_my';
        $customMenu = isset($this->config->customMenu->$flowModule) ? $this->config->customMenu->$flowModule : array();

        if(empty($customMenu))
        {
            $role = $this->app->user->role;
            if($role == 'qa')
            {
                unset($this->lang->my->menuOrder[15]);
                $this->lang->my->menuOrder[32] = 'task';
                $this->lang->my->dividerMenu = str_replace(',task,', ',' , $this->lang->my->menuOrder[20] . ',', $this->lang->my->dividerMenu);
            }
            elseif($role == 'po')
            {
                $this->lang->my->menuOrder[15] = 'story';
                $this->lang->my->menuOrder[30] = 'task';
                $this->lang->my->dividerMenu = str_replace(',task,', ',story,', $this->lang->my->dividerMenu);
            }
            elseif($role == 'pm')
            {
                unset($this->lang->my->menuOrder[35]);
                $this->lang->my->menuOrder[17] = 'myProject';
            }
        }
    }
}
