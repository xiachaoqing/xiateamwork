<?php
/**
 * The control file of action module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     action
 * @version     $Id$
*/
class action extends control
{
    /**
     * Trash 
     * 
     * @param  string $type all|hidden 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function trash($type = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('productList',     $uri);
        $this->session->set('productPlanList', $uri);
        $this->session->set('releaseList',     $uri);
        $this->session->set('storyList',       $uri);
        $this->session->set('projectList',     $uri);
        $this->session->set('taskList',        $uri);
        $this->session->set('buildList',       $uri);
        $this->session->set('bugList',         $uri);
        $this->session->set('caseList',        $uri);
        $this->session->set('testtaskList',    $uri);
        $this->session->set('docList',         $uri);

        /* Get deleted objects. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort    = $this->loadModel('common')->appendOrder($orderBy);
        $trashes = $this->action->getTrashes($type, $sort, $pager);

        /* Title and position. */
        $this->view->title      = $this->lang->action->trash;
        $this->view->position[] = $this->lang->action->trash;

        $this->view->trashes = $trashes;
        $this->view->type    = $type;
        $this->view->orderBy = $orderBy;
        $this->view->pager   = $pager;
        $this->view->users   = $this->loadModel('user')->getPairs('noletter');
        $this->display();
    }

    /**
     * Undelete an object.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function undelete($actionID)
    {
        $this->action->undelete($actionID);
        die(js::reload('parent'));
    }

    /**
     * Hide an deleted object. 
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function hideOne($actionID)
    {
        $this->action->hideOne($actionID);
        die(js::reload('parent'));
    }

    /**
     * Hide all deleted objects.
     * 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function hideAll($confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->action->confirmHideAll, inlink('hideAll', "confirm=yes")));
        }
        else
        {
            $this->action->hideAll();
            die(js::reload('parent'));
        }
    }

    /**
     * Comment. 
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @access public
     * @return void
     */
    public function comment($objectType, $objectID)
    {
        $actionID = $this->action->create($objectType, $objectID, 'Commented', $this->post->comment);
        if(defined('RUN_MODE') && RUN_MODE == 'api')
        {
            die(array('status' => 'success', 'data' => $actionID));
        }
        else
        {
            die(js::reload('parent'));
        }
    }

    /**
     * Edit comment of a action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function editComment($actionID)
    {
        if(trim(strip_tags($this->post->lastComment, '<img>')))
        {
            $this->action->updateComment($actionID);
        }
        else
        {
            dao::$errors['submit'][] = $this->lang->action->historyEdit;
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        $this->send(array('result' => 'success', 'locate' => 'reload'));
    }
}
