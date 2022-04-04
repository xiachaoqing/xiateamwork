<?php
/**
 * The control file of report module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     report
 * @version     $Id: control.php 4622 2013-03-28 01:09:02Z 631753810@qq.com $
*/
class report extends control
{
    /**
     * The index of report, goto project deviation.
     *
     * @access public
     * @return void
     */

    public function __construct($module = '', $method = '')
    {
        parent::__construct($module, $method);
        $this->loadModel('company')->setMenu();
        $this->loadModel('dept');
        $this->loadModel('todo');
        $this->loadModel('user');
        $this->app->loadModuleConfig($this->moduleName);//Finish task #5118.(Fix bug #2271)
    }
    public function index()
    {
        $this->locate(inlink('producttime'));
    }

    /**
     * Project deviation report.
     *
     * @access public
     * @return void
     */
    public function projectDeviation($begin = 0, $end = 0)
    {
        $begin = $begin ? date('Y-m-d', strtotime($begin)) : '';
        $end   = $end   ? date('Y-m-d', strtotime($end))   : '';

        $this->view->title      = $this->lang->report->projectDeviation;
        $this->view->position[] = $this->lang->report->projectDeviation;

        $this->view->projects = $this->report->getProjects($begin, $end);
        $this->view->begin    = $begin;
        $this->view->end      = $end;
        $this->view->submenu  = 'project';
        $this->display();
    }

    /**
     * Product information report.
     *
     * @access public
     * @return void
     */
    public function productSummary($conditions = '')
    {
        $this->app->loadLang('product');
        $this->app->loadLang('productplan');
        $this->app->loadLang('story');
        $this->view->title      = $this->lang->report->productSummary;
        $this->view->position[] = $this->lang->report->productSummary;
        $this->view->products   = $this->report->getProducts($conditions);
        $this->view->users      = $this->loadModel('user')->getPairs('noletter|noclosed');
        $this->view->submenu    = 'product';
        $this->view->conditions = $conditions;
        $this->display();
    }

    /**
     * Bug create report.
     *
     * @param  int    $begin
     * @param  int    $end
     * @access public
     * @return void
     */
    public function bugCreate($begin = 0, $end = 0, $product = 0, $project = 0)
    {
        $this->app->loadLang('bug');
        $begin = $begin == 0 ? date('Y-m-d', strtotime('last month', strtotime(date('Y-m',time()) . '-01 00:00:01'))) : date('Y-m-d', strtotime($begin));
        $end   = $end == 0   ? date('Y-m-d', strtotime('now')) : $end = date('Y-m-d', strtotime($end));

        $this->view->title      = $this->lang->report->bugCreate;
        $this->view->position[] = $this->lang->report->bugCreate;
        $this->view->begin      = $begin;
        $this->view->end        = $end;
        $this->view->bugs       = $this->report->getBugs($begin, $end, $product, $project);
        $this->view->users      = $this->loadModel('user')->getPairs('noletter|noclosed|nodeleted');
        $this->view->projects   = array('' => '') + $this->loadModel('project')->getPairs();
        $this->view->products   = array('' => '') + $this->loadModel('product')->getPairs();
        $this->view->project    = $project;
        $this->view->product    = $product;
        $this->view->submenu    = 'test';
        $this->display();
    }

    /**
     * Bug assign report.
     *
     * @access public
     * @return void
     */
    public function bugAssign()
    {
        $this->view->title      = $this->lang->report->bugAssign;
        $this->view->position[] = $this->lang->report->bugAssign;
        $this->view->submenu    = 'test';
        $this->view->assigns    = $this->report->getBugAssign();
        $this->view->users      = $this->loadModel('user')->getPairs('noletter|noclosed|nodeleted');
        $this->display();
    }

    /**
     * Workload report.
     *
     * @param string $begin
     * @param string $end
     * @param int    $days
     * @param int    $workday
     * @param int    $dept
     * @param int    $assign
     *
     * @access public
     * @return void
     */
    public function workload($begin = '', $end = '', $days = 0, $workday = 0, $dept = 0, $assign = 'assign')
    {
        if($_POST)
        {
            $data    = fixer::input('post')->get();
            $begin   = $data->begin;
            $end     = $data->end;
            $dept    = $data->dept;
            $days    = $data->days;
            $assign  = $data->assign;
            $workday = $data->workday;
        }

        $this->app->loadConfig('project');
        $begin  = $begin ? strtotime($begin) : time();
        $end    = $end   ? strtotime($end)   : time() + (7 * 24 * 3600);
        $end   += 24 * 3600;
        $beginWeekDay = date('w', $begin);
        $begin  = date('Y-m-d', $begin);
        $end    = date('Y-m-d', $end);

        if(empty($workday))$workday = $this->config->project->defaultWorkhours;
        $diffDays = helper::diffDate($end, $begin);
        if($days > $diffDays) $days = $diffDays;
        if(empty($days))
        {
            $weekDay = $beginWeekDay;
            $days    = $diffDays;
            for($i = 0; $i < $diffDays; $i++,$weekDay++)
            {
                $weekDay = $weekDay % 7;
                if(($this->config->project->weekend == 2 and $weekDay == 6) or $weekDay == 0) $days --;
            }
        }

        $this->view->title      = $this->lang->report->workload;
        $this->view->position[] = $this->lang->report->workload;

        $this->view->workload = $this->report->getWorkload($dept, $assign);
        $this->view->users    = $this->loadModel('user')->getPairs('noletter|noclosed|nodeleted');
        $this->view->depts    = $this->loadModel('dept')->getOptionMenu();
        $this->view->begin    = $begin;
        $this->view->end      = date('Y-m-d', strtotime($end) - 24 * 3600);
        $this->view->days     = $days;
        $this->view->workday  = $workday;
        $this->view->dept     = $dept;
        $this->view->assign   = $assign;
        $this->view->allHour  = $days * $workday;
        $this->view->submenu  = 'staff';
        $this->display();
    }
    /**
     * Workload report.
     *
     * @param string $begin
     * @param string $end
     * @param int    $days
     * @param int    $workday
     * @param int    $dept
     * @param int    $assign
     *
     * @access public
     * @return void
     */
    public function taskload($begin = '', $end = '', $days = 0, $workday = 0, $dept = 0, $assign = 'assign')
    {
        if($_POST)
        {
            $data    = fixer::input('post')->get();
            $begin   = $data->begin;
            $end     = $data->end;
            $dept    = $data->dept;
            $days    = $data->days;
            $assign  = $data->assign;
            $workday = $data->workday;
        }

        $this->app->loadConfig('project');
        $begin  = $begin ? strtotime($begin) : time();
        $end    = $end   ? strtotime($end)   : time() + (7 * 24 * 3600);
        $end   += 24 * 3600;
        $beginWeekDay = date('w', $begin);
        $begin  = date('Y-m-d', $begin);
        $end    = date('Y-m-d', $end);

        if(empty($workday))$workday = $this->config->project->defaultWorkhours;
        $diffDays = helper::diffDate($end, $begin);
        if($days > $diffDays) $days = $diffDays;
        if(empty($days))
        {
            $weekDay = $beginWeekDay;
            $days    = $diffDays;
            for($i = 0; $i < $diffDays; $i++,$weekDay++)
            {
                $weekDay = $weekDay % 7;
                if(($this->config->project->weekend == 2 and $weekDay == 6) or $weekDay == 0) $days --;
            }
        }

        $this->view->title      = $this->lang->report->taskload;
        $this->view->position[] = $this->lang->report->taskload;

        $this->view->workload = $this->report->getTaskload($dept, $assign);
        $this->view->users    = $this->loadModel('user')->getPairs('noletter|noclosed|nodeleted');
        $this->view->depts    = $this->loadModel('dept')->getOptionMenu();
        $this->view->begin    = $begin;
        $this->view->end      = date('Y-m-d', strtotime($end) - 24 * 3600);
        $this->view->days     = $days;
        $this->view->workday  = $workday;
        $this->view->dept     = $dept;
        $this->view->assign   = $assign;
        $this->view->allHour  = $days * $workday;
        $this->view->submenu  = 'staff';
        $this->display();
    }
    /**
     * Workload time.
     *
     * @param string $begin
     * @param string $end
     * @param int    $days
     * @param int    $workday
     * @param int    $dept
     * @param int    $assign
     *
     * @access public
     * @return void
     */
    public function taskTime($begin = '', $end = '', $dept = 0, $assign = 'assign')
    {
        if($_POST)
        {
            $data    = fixer::input('post')->get();
            $begin   = $data->begin;
            $end     = $data->end;
            $use    = $data->use;
            $assign  = $data->assign;
        }

        $this->app->loadConfig('project');
        $begin  = $begin ? strtotime($begin) : time()-(24*3600);
        $end    = $end   ? strtotime($end)   : time() + (5 * 24 * 3600);
        $begin  = date('Y-m-d', $begin);
        $end    = date('Y-m-d', $end);
        if(empty($workday))$workday = $this->config->project->defaultWorkhours;

        $this->view->title      = $this->lang->report->taskTime;
        $this->view->position[] = $this->lang->report->taskTime;
        $this->view->workload = $this->report->getTasktime($use, $assign, $begin, $end);
        $this->view->users    = $this->loadModel('user')->getPill('noletter|noclosed|nodeleted');
        $this->view->depts    = $this->loadModel('dept')->getOptionMenu();
        $this->view->productlist  =$this->loadModel('tree')->ReturnTree(); //产品线
        $this->view->product  =$this->loadModel('tree')->ReturnPro(); //产品
        $this->view->begin    = $begin;
        $this->view->end      = $end;
        $this->view->workday  = $workday;
        $this->view->use     = $use;
        $this->view->assign   = $assign;
        $this->view->allHour  = 0;
        $this->view->submenu  = 'staff';
        
        $this->display();
    }
    /**
     * Workload time.
     *
     * @param string $begin
     * @param string $end
     * @param int    $days
     * @param int    $workday
     * @param int    $dept
     * @param int    $assign
     *
     * @access public
     * @return void
     */
    public function productTime($begin = '', $end = '', $workday = 0, $pro = 0, $assign = 'assign',$format='table')
    {
        if($_POST)
        {
            $data    = fixer::input('post')->get();
            $begin   = $data->begin;
            $end     = $data->end;
            $pro    =  $data->pro;
            $assign  = $data->assign;
            $format  = $data->format;
            $workday = $data->workday;
        }

        $this->app->loadConfig('project');
        $begin  = $begin ? strtotime($begin): time()-(24*3600);
        $end    = $end   ? strtotime($end)   : time() + (5 * 24 * 3600);
        $begin  = date('Y-m-d', $begin);
        $end    = date('Y-m-d', $end);

        //获取总小时数据
        if(empty($workday))$workday = $this->config->project->defaultWorkhours;
        $diffDays = helper::diffDate($end, $begin);
        $this->view->title      = $this->lang->report->productTime;
        $this->view->position[] = $this->lang->report->productTime;
        $this->view->workload = $this->report->getTaskproduct($pro, $assign, $begin, $end);
        $this->view->users    = $this->loadModel('user')->getPill('noletter|noclosed|nodeleted');
        $this->view->depts    = $this->loadModel('dept')->getOptionMenu();
        $this->view->productlist  =$this->loadModel('tree')->ReturnTree(); //产品线
        $this->view->product  =$this->loadModel('tree')->ReturnPro($pro); //产品
        $this->view->begin    = $begin;
        $this->view->end      = $end;
        $this->view->workday  = $workday;
        $this->view->pro     = $pro;
        $this->view->assign   = $assign;
        $this->view->format   =$format;
        $this->view->allHour  = ($diffDays+1)* $workday;
        $this->view->submenu  = 'product';
        $this->display();
    }
    /**
     * Finance time.
     *
     * @param string $begin
     * @param string $end
     * @param int    $days
     * @param int    $workday
     * @param int    $dept
     * @param int    $assign
     *
     * @access public
     * @return void
     */
    public function financeTime($begin = '', $end = '', $workday = 0, $pro = 0,$format='table')
    {
        if($_POST)
        {
            $data    = fixer::input('post')->get();
            $begin   = $data->begin;
            $end     = $data->end;
            $pro    =  $data->pro;
            $use    = $data->use;
            $format  = $data->format;
            $workday = $data->workday;
        }

        $this->app->loadConfig('project');
        $begin  = $begin ? strtotime($begin): time()-(24*3600);
        $end    = $end   ? strtotime($end)   : time() + (5 * 24 * 3600);
        $begin  = date('Y-m-d', $begin);
        $end    = date('Y-m-d', $end);
        //获取总小时数据
        if(empty($workday))$workday = $this->config->project->defaultWorkhours;
        $diffDays = helper::diffDate($end, $begin);
        $this->view->title      = $this->lang->report->financeTime;
        $this->view->position[] = $this->lang->report->financeTime;
        $this->view->workload = $this->report->getUserproduct($pro,$use,$begin,$end,$workday);
        $this->view->users    = $this->loadModel('user')->getPill('noletter|noclosed|nodeleted');
        $this->view->depts    = $this->loadModel('dept')->getOptionMenu();
        $this->view->productlist  =$this->loadModel('tree')->ReturnTree(); //产品线
        $this->view->product  =$this->loadModel('tree')->ReturnPro($pro); //产品
        $this->view->begin    = $begin;
        $this->view->end      = $end;
        $this->view->workday  = $workday;
        $this->view->pro     = $pro;
        $this->view->use     = $use;
        $this->view->format   =$format;
        $this->view->allHour  = $this->loadModel('report')->get_weekend_days($begin, $end);
        $this->view->submenu  = 'product';
        $this->display();
    }
     /**
     * get data to export
     *
     * @param  int    $
     * @access public
     * @return void
     */
    public function export($name, $orderBy)
    {
        /* format the fields of every story in order to export data. */
        if($_POST)
        {
            $this->loadModel('file');
            $this->loadModel('branch');
            $storyLang   = $this->lang->story;
            $storyConfig = $this->config->story;

            /* Create field lists. */
            $fields = $this->post->exportFields ? $this->post->exportFields : explode(',', $storyConfig->list->exportFields);
            foreach($fields as $key => $fieldName)
            {
                $fieldName = trim($fieldName);
                $fields[$fieldName] = isset($storyLang->$fieldName) ? $storyLang->$fieldName : $fieldName;
                unset($fields[$key]);
            }

            /* Get stories. */
            $stories = array();
            if($this->session->storyOnlyCondition)
            {
                $stories = $this->dao->select('*')->from(TABLE_STORY)->where($this->session->storyQueryCondition)
                    ->beginIF($this->post->exportType == 'selected')->andWhere('id')->in($this->cookie->checkedItem)->fi()
                    ->orderBy($orderBy)->fetchAll('id');
            }
            else
            {
                $stmt = $this->dbh->query($this->session->storyQueryCondition . ($this->post->exportType == 'selected' ? " AND t1.id IN({$this->cookie->checkedItem})" : '') . " ORDER BY " . strtr($orderBy, '_', ' '));
                while($row = $stmt->fetch()) $stories[$row->id] = $row;
            }

            /* Get users, products and projects. */
            $users    = $this->loadModel('user')->getPairs('noletter');
            $products = $this->loadModel('product')->getPairs('nocode');

            /* Get related objects id lists. */
            $relatedProductIdList = array();
            $relatedModuleIdList  = array();
            $relatedStoryIdList   = array();
            $relatedPlanIdList    = array();
            $relatedBranchIdList  = array();
            $relatedStoryIDs      = array();

            foreach($stories as $story)
            {
                $relatedProductIdList[$story->product] = $story->product;
                $relatedModuleIdList[$story->module]   = $story->module;
                $relatedPlanIdList[$story->plan]       = $story->plan;
                $relatedBranchIdList[$story->branch]   = $story->branch;
                $relatedStoryIDs[$story->id]           = $story->id;

                /* Process related stories. */
                $relatedStories = $story->childStories . ',' . $story->linkStories . ',' . $story->duplicateStory;
                $relatedStories = explode(',', $relatedStories);
                foreach($relatedStories as $storyID)
                {
                    if($storyID) $relatedStoryIdList[$storyID] = trim($storyID);
                }
            }

            $storyTasks = $this->loadModel('task')->getStoryTaskCounts($relatedStoryIDs);
            $storyBugs  = $this->loadModel('bug')->getStoryBugCounts($relatedStoryIDs);
            $storyCases = $this->loadModel('testcase')->getStoryCaseCounts($relatedStoryIDs);

            /* Get related objects title or names. */
            $productsType   = $this->dao->select('id, type')->from(TABLE_PRODUCT)->where('id')->in($relatedProductIdList)->fetchPairs();
            $relatedModules = $this->loadModel('tree')->getOptionMenu($productID);
            $relatedPlans   = $this->dao->select('id, title')->from(TABLE_PRODUCTPLAN)->where('id')->in(join(',', $relatedPlanIdList))->fetchPairs();
            $relatedStories = $this->dao->select('id,title')->from(TABLE_STORY) ->where('id')->in($relatedStoryIdList)->fetchPairs();
            $relatedFiles   = $this->dao->select('id, objectID, pathname, title')->from(TABLE_FILE)->where('objectType')->eq('story')->andWhere('objectID')->in(@array_keys($stories))->andWhere('extra')->ne('editor')->fetchGroup('objectID');
            $relatedSpecs   = $this->dao->select('*')->from(TABLE_STORYSPEC)->where('`story`')->in(@array_keys($stories))->orderBy('version desc')->fetchGroup('story');
            $relatedBranch  = array('0' => $this->lang->branch->all) + $this->dao->select('id, name')->from(TABLE_BRANCH)->where('id')->in($relatedBranchIdList)->fetchPairs();

            foreach($stories as $story)
            {
                $story->spec   = '';
                $story->verify = '';
                if(isset($relatedSpecs[$story->id]))
                {
                    $storySpec     = $relatedSpecs[$story->id][0];
                    $story->title  = $storySpec->title;
                    $story->spec   = $storySpec->spec;
                    $story->verify = $storySpec->verify;
                }

                if($this->post->fileType == 'csv')
                {
                    $story->spec = htmlspecialchars_decode($story->spec);
                    $story->spec = str_replace("<br />", "\n", $story->spec);
                    $story->spec = str_replace('"', '""', $story->spec);
                    $story->spec = str_replace('&nbsp;', ' ', $story->spec);

                    $story->verify = htmlspecialchars_decode($story->verify);
                    $story->verify = str_replace("<br />", "\n", $story->verify);
                    $story->verify = str_replace('"', '""', $story->verify);
                    $story->verify = str_replace('&nbsp;', ' ', $story->verify);
                }
                /* fill some field with useful value. */
                if(isset($products[$story->product]))      $story->product = $this->post->fileType == 'word' ? $products[$story->product] : $products[$story->product] . "(#$story->product)";
                if(isset($relatedModules[$story->module])) $story->module  = $this->post->fileType == 'word' ? $relatedModules[$story->module] : $relatedModules[$story->module] . "(#$story->module)";
                if(isset($relatedBranch[$story->branch]))  $story->branch  = $relatedBranch[$story->branch] . "(#$story->branch)";
                if(isset($story->plan))
                {
                    $plans = '';
                    foreach(explode(',', $story->plan) as $planID)
                    {
                        if(empty($planID)) continue;
                        if(isset($relatedPlans[$planID])) $plans .= $this->post->fileType == 'word' ? $relatedPlans[$planID] : $relatedPlans[$planID] . "(#$planID)";
                    }
                    $story->plan = $plans;
                }
                if(isset($relatedStories[$story->duplicateStory])) $story->duplicateStory = $relatedStories[$story->duplicateStory];

                if(isset($storyLang->priList[$story->pri]))             $story->pri          = $storyLang->priList[$story->pri];
                if(isset($storyLang->statusList[$story->status]))       $story->status       = $storyLang->statusList[$story->status];
                if(isset($storyLang->stageList[$story->stage]))         $story->stage        = $storyLang->stageList[$story->stage];
                if(isset($storyLang->reasonList[$story->closedReason])) $story->closedReason = $storyLang->reasonList[$story->closedReason];
                if(isset($storyLang->sourceList[$story->source]))       $story->source       = $storyLang->sourceList[$story->source];
                if(isset($storyLang->sourceList[$story->sourceNote]))   $story->sourceNote   = $storyLang->sourceList[$story->sourceNote];

                if(isset($users[$story->openedBy]))     $story->openedBy     = $users[$story->openedBy];
                if(isset($users[$story->assignedTo]))   $story->assignedTo   = $users[$story->assignedTo];
                if(isset($users[$story->lastEditedBy])) $story->lastEditedBy = $users[$story->lastEditedBy];
                if(isset($users[$story->closedBy]))     $story->closedBy     = $users[$story->closedBy];

                if(isset($storyTasks[$story->id]))     $story->taskCountAB = $storyTasks[$story->id];
                if(isset($storyBugs[$story->id]))      $story->bugCountAB  = $storyBugs[$story->id];
                if(isset($storyCases[$story->id]))     $story->caseCountAB = $storyCases[$story->id];

                $story->openedDate     = substr($story->openedDate, 0, 10);
                $story->assignedDate   = substr($story->assignedDate, 0, 10);
                $story->lastEditedDate = substr($story->lastEditedDate, 0, 10);
                $story->closedDate     = substr($story->closedDate, 0, 10);

                if($story->linkStories)
                {
                    $tmpLinkStories = array();
                    $linkStoriesIdList = explode(',', $story->linkStories);
                    foreach($linkStoriesIdList as $linkStoryID)
                    {
                        $linkStoryID = trim($linkStoryID);
                        $tmpLinkStories[] = isset($relatedStories[$linkStoryID]) ? $relatedStories[$linkStoryID] : $linkStoryID;
                    }
                    $story->linkStories = join("; \n", $tmpLinkStories);
                }

                if($story->childStories)
                {
                    $tmpChildStories = array();
                    $childStoriesIdList = explode(',', $story->childStories);
                    foreach($childStoriesIdList as $childStoryID)
                    {
                        $childStoryID = trim($childStoryID);
                        $tmpChildStories[] = isset($relatedStories[$childStoryID]) ? $relatedStories[$childStoryID] : $childStoryID;
                    }
                    $story->childStories = join("; \n", $tmpChildStories);
                }

                /* Set related files. */
                $story->files = '';
                if(isset($relatedFiles[$story->id]))
                {
                    foreach($relatedFiles[$story->id] as $file)
                    {
                        $fileURL = common::getSysURL() . $this->file->webPath . $this->file->getRealPathName($file->pathname);
                        $story->files .= html::a($fileURL, $file->title, '_blank') . '<br />';
                    }
                }

                $story->mailto = trim(trim($story->mailto), ',');
                $mailtos = explode(',', $story->mailto);
                $story->mailto = '';
                foreach($mailtos as $mailto)
                {
                    $mailto = trim($mailto);
                    if(isset($users[$mailto])) $story->mailto .= $users[$mailto] . ',';
                }
                $story->mailto = rtrim($story->mailto, ',');

                $story->reviewedBy = trim(trim($story->reviewedBy), ',');
                $reviewedBys = explode(',', $story->reviewedBy);
                $story->reviewedBy = '';
                foreach($reviewedBys as $reviewedBy)
                {
                    $reviewedBy = trim($reviewedBy);
                    if(isset($users[$reviewedBy])) $story->reviewedBy .= $users[$reviewedBy] . ',';
                }
                $story->reviewedBy = rtrim($story->reviewedBy, ',');

            }

            if($projectID)
            {
                $header = new stdclass();
                $header->name      = 'project';
                $header->tableName = TABLE_PROJECT;

                $this->post->set('header', $header);
            }
            if(!(in_array('platform', $productsType) or in_array('branch', $productsType))) unset($fields['branch']);// If products's type are normal, unset branch field.

            $this->post->set('fields', $fields);
            $this->post->set('rows', $stories);
            $this->post->set('kind', 'story');
            $this->fetch('file', 'export2' . $this->post->fileType, $_POST);
        }
        $fileName = $name;
        $this->view->fileName        = $fileName;
        $this->view->allExportFields = $this->config->report->list->productExport;
        $this->view->customExport    = true;
        $this->display();
    }
    
    /**
     * Send daily reminder mail.
     *
     * @access public
     * @return void
     */
    public function remind()
    {
        $bugs = $tasks = $todos = $testTasks = array();
        if($this->config->report->dailyreminder->bug)      $bugs  = $this->report->getUserBugs();
        if($this->config->report->dailyreminder->task)     $tasks = $this->report->getUserTasks();
        if($this->config->report->dailyreminder->todo)     $todos = $this->report->getUserTodos();
        if($this->config->report->dailyreminder->testTask) $testTasks = $this->report->getUserTestTasks();

        $reminder = array();

        $users = array_unique(array_merge(array_keys($bugs), array_keys($tasks), array_keys($todos), array_keys($testTasks)));
        if(!empty($users)) foreach($users as $user) $reminder[$user] = new stdclass();

        if(!empty($bugs))  foreach($bugs as $user => $bug)   $reminder[$user]->bugs  = $bug;
        if(!empty($tasks)) foreach($tasks as $user => $task) $reminder[$user]->tasks = $task;
        if(!empty($todos)) foreach($todos as $user => $todo) $reminder[$user]->todos = $todo;
        if(!empty($testTasks)) foreach($testTasks as $user => $testTask) $reminder[$user]->testTasks = $testTask;

        $this->loadModel('mail');

        /* Check mail turnon.*/
        if(!$this->config->mail->turnon)
        {
            echo "You should turn on the Email feature first.\n";
            return false;
        }

        foreach($reminder as $user => $mail)
        {
            /* Reset $this->output. */
            $this->clear();

            $mailTitle  = $this->lang->report->mailTitle->begin;
            $mailTitle .= isset($mail->bugs)  ? sprintf($this->lang->report->mailTitle->bug,  count($mail->bugs))  : '';
            $mailTitle .= isset($mail->tasks) ? sprintf($this->lang->report->mailTitle->task, count($mail->tasks)) : '';
            $mailTitle .= isset($mail->todos) ? sprintf($this->lang->report->mailTitle->todo, count($mail->todos)) : '';
            $mailTitle .= isset($mail->testTasks) ? sprintf($this->lang->report->mailTitle->testTask, count($mail->testTasks)) : '';
            $mailTitle  = rtrim($mailTitle, ',');

            /* Get email content and title.*/
            $this->view->mail      = $mail;
            $this->view->mailTitle = $mailTitle;

            $oldViewType = $this->viewType;
            if($oldViewType == 'json') $this->viewType = 'html';
            $mailContent = $this->parse('report', 'dailyreminder');
            $this->viewType == $oldViewType;

            /* Send email.*/
            echo date('Y-m-d H:i:s') . " sending to $user, ";
            $this->mail->send($user, $mailTitle, $mailContent, '', true);
            if($this->mail->isError())
            {
                echo "fail: \n" ;
                a($this->mail->getError());
            }
            echo "ok\n";
        }
    }
        /**
         * View a user.
         *
         * @param  string $account
         * @access public
         * @return void
         */
        public function view($account)
        {
            if($this->config->global->flow == 'onlyStory') $this->locate($this->createLink('report', 'dynamic', "period=today&account=$account"));
            if($this->config->global->flow == 'onlyTask')  $this->locate($this->createLink('report', 'task', "account=$account"));
            if($this->config->global->flow == 'onlyTest')  $this->locate($this->createLink('report', 'bug', "account=$account"));
            // $this->locate($this->createLink('report', 'todo', "account=$account"));
            $this->locate($this->createLink('report', 'task', "account=$account"));
        }

        /**
         * Todos of a user.
         *
         * @param  string $account
         * @param  string $type         the todo type, today|lastweek|thisweek|all|undone, or a date.
         * @param  string $status
         * @param  string $orderBy
         * @param  int    $recTotal
         * @param  int    $recPerPage
         * @param  int    $pageID
         * @access public
         * @return void
         */
        public function todo($account, $type = 'today', $status = 'all', $orderBy='date,status,begin', $recTotal = 0, $recPerPage = 20, $pageID = 1)
        {
            /* Set thie url to session. */
            $uri = $this->app->getURI(true);
            $this->session->set('todoList', $uri);
            $this->session->set('bugList',  $uri);
            $this->session->set('taskList', $uri);

            /* Load pager. */
            $this->app->loadClass('pager', $static = true);
            $pager = pager::init($recTotal, $recPerPage, $pageID);

            /* Append id for secend sort. */
            $sort = $this->loadModel('common')->appendOrder($orderBy);

            /* Get user, totos. */
            $user    = $this->user->getById($account);
            $account = $user->account;
            $todos   = $this->todo->getList($type, $account, $status, 0, $pager, $sort);
            $date    = (int)$type == 0 ? helper::today() : $type;

            /* set menus. */
            $this->lang->set('menugroup.user', 'company');
            $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

            $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->todo;
            $this->view->position[] = $this->lang->user->todo;
            $this->view->tabID      = 'todo';
            $this->view->date       = $date;
            $this->view->todos      = $todos;
            $this->view->user       = $user;
            $this->view->account    = $account;
            $this->view->type       = $type;
            $this->view->status     = $status;
            $this->view->orderBy    = $orderBy;
            $this->view->pager      = $pager;
            $this->display();
        }
          /**
     * Story of a user.
     *
     * @param  string $account
     * @param  string $type
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function story($account,$type = 'assignedTo', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {

        /* Save session. */
        $this->session->set('storyList', $this->app->getURI(true));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);
        /* Set menu. */
        $this->lang->set('menugroup.user', 'company');
        $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

        /* Assign. */
        $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->story;
        $this->view->position[] = $this->lang->user->story;
        $this->view->stories    = $this->loadModel('story')->getUserStories1($account,$type, 'id_desc', $pager);
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->type       = $type;
        $this->view->account    = $account;
        $this->view->pager      = $pager;

        $this->display();
    }

    /**
     * Tasks of a user.
     *
     * @param  string $account
     * @param  string $type
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function task($account,$type = 'assignedTo', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save the session. */
        $this->session->set('taskList', $this->app->getURI(true));
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Set the menu. */
        $this->lang->set('menugroup.user', 'company');
        $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

        /* Assign. */
        $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->task;
        $this->view->position[] = $this->lang->user->task;
        $this->view->tabID      = 'task';
        $this->view->tasks      = $this->loadModel('task')->getUserTasks($account,$type, 0, $pager);
        $this->view->type       = $type;
        $this->view->account    = $account;
        $this->view->user       = $this->user->getById($account);
        $this->view->pager      = $pager;

        $this->display();
    }

    /**
     * User bugs.
     *
     * @param  string $account
     * @param  string $type
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function bug($account,$type = 'assignedTo', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save the session. */
        $this->session->set('bugList', $this->app->getURI(true));
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Set menu. */
        $this->lang->set('menugroup.user', 'company');
        $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

        /* Load the lang of bug module. */
        $this->app->loadLang('bug');

        $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->bug;
        $this->view->position[] = $this->lang->user->bug;
        $this->view->tabID      = 'bug';
        $this->view->bugs       = $this->loadModel('bug')->getUserBugs($account,$type, $orderBy, 0, $pager);
        $this->view->account    = $account;
        $this->view->type       = $type;
        $this->view->user       = $this->user->getById($account);
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->pager      = $pager;

        $this->display();
    }

    /**
     * User's testtask
     *
     * @param  string $account
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function testtask($account,$orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Set menu. */
        $this->lang->set('menugroup.user', 'company');
        $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

        /* Save session. */
        $this->session->set('testtaskList', $this->app->getURI(true));

        $this->app->loadLang('testcase');

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

        $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->testTask;
        $this->view->position[] = $this->lang->user->testTask;
        $this->view->tasks      = $this->loadModel('testtask')->getByUser($account,$pager, $sort);
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->account    = $account;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;
        $this->display();

    }

    /**
     * User's test case.
     *
     * @param  string $type
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function testcase($account,$type = 'case2Him', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session, load lang. */
        $this->session->set('caseList', $this->app->getURI(true));
        $this->app->loadLang('testcase');

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

         /* Set menu. */
        $this->lang->set('menugroup.user', 'company');
        $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

        $cases = array();
        if($type == 'case2Him')
        {
            $cases = $this->loadModel('testcase')->getByAssignedTo($account, $sort, $pager);
        }
        elseif($type == 'caseByHim')
        {
            $cases = $this->loadModel('testcase')->getByOpenedBy($account, $sort, $pager);
        }
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'testcase', $type == 'case2Him' ? false : true);

        /* Assign. */
        $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->testCase;
        $this->view->position[] = $this->lang->user->testCase;
        $this->view->account    = $account;
        $this->view->cases      = $cases;
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->tabID      = 'test';
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;

        $this->display();
    }

    /**
     * User projects.
     *
     * @param  string $account
     * @access public
     * @return void
     */
    public function project($account)
    {
        /* Set the menus. */
        $this->loadModel('project');
        $this->lang->set('menugroup.user', 'company');
        $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclose|nodeleted'), $account);

        $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->project;
        $this->view->position[] = $this->lang->user->project;
        $this->view->tabID      = 'project';
        $this->view->projects   = $this->user->getProjects($account);
        $this->view->account    = $account;
        $this->view->user       = $this->user->getById($account);

        $this->display();
    }

    /**
     * Set the rerferer.
     *
     * @param  string   $referer
     * @access public
     * @return void
     */
    public function setReferer($referer = '')
    {
        if(!empty($referer))
        {
            $this->referer = helper::safe64Decode($referer);
        }
        else
        {
            $this->referer = $this->server->http_referer ? $this->server->http_referer: '';
        }
    }



    /**
     * Deny page.
     *
     * @param  string $module
     * @param  string $method
     * @param  string $refererBeforeDeny    the referer of the denied page.
     * @access public
     * @return void
     */
    public function deny($module, $method, $refererBeforeDeny = '')
    {
        $this->setReferer();
        $this->view->title             = $this->lang->user->deny;
        $this->view->module            = $module;
        $this->view->method            = $method;
        $this->view->denyPage          = $this->referer;        // The denied page.
        $this->view->refererBeforeDeny = $refererBeforeDeny;    // The referer of the denied page.
        $this->app->loadLang($module);
        $this->app->loadLang('my');
        $this->display();
        exit;
    }


    /**
     * User dynamic.
     *
     * @param  string $period
     * @param  string $account
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function dynamic($period = 'today',$account = '', $recTotal = 0, $date = '', $direction = 'next')
    {
        /* set menus. */
        $this->lang->set('menugroup.user', 'company');
        $this->view->userList = $this->user->setUserList($this->user->getPairs('noempty|noclosed|nodeleted'), $account);

        /* Save session. */
        $uri   = $this->app->getURI(true);
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

        /* Set the pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage = 50, $pageID = 1);

        /* Append id for secend sort. */
        $orderBy = $direction == 'next' ? 'date_desc' : 'date_asc';
        $sort    = $this->loadModel('common')->appendOrder($orderBy);
        $date    = empty($date) ? '' : date('Y-m-d', $date);

        $actions = $this->loadModel('action')->getDynamic($account, $period, $sort, $pager, 'all', 'all', $date, $direction);

        $this->view->title      = $this->lang->user->common . $this->lang->colon . $this->lang->user->dynamic;
        $this->view->position[] = $this->lang->user->dynamic;

        /* Assign. */
        $this->view->type       = $period;
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');
        $this->view->account    = $account;
        $this->view->pager      = $pager;
        $this->view->user       = $this->user->getById($account);
        $this->view->dateGroups = $this->action->buildDateGroup($actions, $direction);
        $this->view->direction  = $direction;
        $this->display();
    }

    /**
     * Get user for ajax
     *
     * @param  string $requestID
     * @param  string $assignedTo
     * @access public
     * @return void
     */
    public function ajaxGetUser($taskID = '', $assignedTo = '')
    {
        $users = $this->user->getPairs('noletter, noclosed');
        $html = "<form method='post' target='hiddenwin' action='" . $this->createLink('task', 'assignedTo', "taskID=$taskID&assignedTo=$assignedTo") . "'>";
        $html .= html::select('assignedTo', $users, $assignedTo);
        $html .= html::submitButton('', '', 'btn btn-primary');
        $html .= '</form>';
        echo $html;
    }

    /**
     * AJAX: get users from a contact list.
     *
     * @param  int    $contactListID
     * @access public
     * @return string
     */
    public function ajaxGetContactUsers($contactListID)
    {
        $users = $this->user->getPairs('devfirst|nodeleted');
        if(!$contactListID) return print(html::select('mailto[]', $users, '', "class='form-control' multiple data-placeholder='{$this->lang->chooseUsersToMail}'"));
        $list = $this->user->getContactListByID($contactListID);
        return print(html::select('mailto[]', $users, $list->userList, "class='form-control' multiple data-placeholder='{$this->lang->chooseUsersToMail}'"));
    }

    /**
     * Ajax get contact list.
     *
     * @access public
     * @return string
     */
    public function ajaxGetContactList()
    {
        $contactList = $this->user->getContactLists($this->app->user->account, 'withnote');
        if(empty($contactList)) return false;
        return print(html::select('', $contactList, '', "class='form-control' onchange=\"setMailto('mailto', this.value)\""));
    }
}
