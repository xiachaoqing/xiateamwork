<?php
/**
 * The model file of report module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     report
 * @version     $Id: model.php 4726 2013-05-03 05:51:27Z 631753810@qq.com $
*/
?>
<?php
class reportModel extends model
{
    /**
     * Compute percent of every item.
     *
     * @param  array    $datas
     * @access public
     * @return array
     */
    public function computePercent($datas)
    {
        $sum = 0;
        foreach($datas as $data) $sum += $data->value;
        foreach($datas as $data) $data->percent = round($data->value / $sum, 2);
        return $datas;
    }

    /**
     * Create json data of single charts
     * @param  array $sets
     * @param  array $dateList
     * @return string the json string
     */
    public function createSingleJSON($sets, $dateList)
    {
        $data = '[';
        $now  = date('Y-m-d');
        $preValue = 0;
        $setsDate = array_keys($sets);
        foreach($dateList as $i => $date)
        {
            $date  = date('Y-m-d', strtotime($date));
            if($date > $now) break;
            if(!isset($sets[$date]) and $sets)
            {
                $tmpDate = $setsDate;
                $tmpDate[] = $date;
                sort($tmpDate);
                $tmpDateStr = ',' . join(',', $tmpDate);
                $preDate = rtrim(substr($tmpDateStr, 0, strpos($tmpDateStr, $date)), ',');
                $preDate = substr($preDate, strrpos($preDate, ',') + 1);

                if($preDate)
                {
                    $preValue = $sets[$preDate];
                    $preValue = $preValue->value;
                }
            }

            $data .= isset($sets[$date]) ? "{$sets[$date]->value}," : "{$preValue},";
        }
        $data = rtrim($data, ',');
        $data .= ']';
        return $data;
    }

    /**
     * Convert date format.
     *
     * @param  array  $dateList
     * @param  string $format
     * @access public
     * @return array
     */
    public function convertFormat($dateList, $format = 'Y-m-d')
    {
        foreach($dateList as $i => $date) $dateList[$i] = date($format, strtotime($date));
        return $dateList;
    }

    /**
     * Get projects.
     *
     * @access public
     * @return void
     */
    public function getProjects($begin = 0, $end = 0)
    {
        $tasks = $this->dao->select('t1.*,t2.name as projectName')->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id')
            ->where('t1.status')->ne('cancel')
            ->andWhere('t1.deleted')->eq(0)
            ->beginIF(!$this->app->user->admin)->andWhere('t2.id')->in($this->app->user->view->projects)->fi()
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.parent')->lt(1)
            ->andWhere('t2.status')->eq('closed')
            ->beginIF($begin)->andWhere('t2.begin')->ge($begin)->fi()
            ->beginIF($end)->andWhere('t2.end')->le($end)->fi()
            ->orderBy('t2.end_desc')
            ->fetchAll();

        $projects = array();
        foreach($tasks as $task)
        {
            $projectID = $task->project;
            if(!isset($projects[$projectID]))
            {
                $projects[$projectID] = new stdclass();
                $projects[$projectID]->estimate = 0;
                $projects[$projectID]->consumed = 0;
            }

            $projects[$projectID]->name      = $task->projectName;
            $projects[$projectID]->estimate += $task->estimate;
            $projects[$projectID]->consumed += $task->consumed;
        }

        return $projects;
    }

    /**
     * Get products.
     *
     * @access public
     * @return array
     */
    public function getProducts($conditions)
    {
        $products = $this->dao->select('id, code, name, PO')->from(TABLE_PRODUCT)
            ->where('deleted')->eq(0)
            ->beginIF(strpos($conditions, 'closedProduct') === false)->andWhere('status')->ne('closed')->fi()
            ->beginIF(!$this->app->user->admin)->andWhere('id')->in($this->app->user->view->products)->fi()
            ->fetchAll('id');
        $plans    = $this->dao->select('*')->from(TABLE_PRODUCTPLAN)->where('deleted')->eq(0)->andWhere('product')->in(array_keys($products))
            ->beginIF(strpos($conditions, 'overduePlan') === false)->andWhere('end')->gt(date('Y-m-d'))->fi()
            ->fetchAll('id');
        foreach($plans as $plan) $products[$plan->product]->plans[$plan->id] = $plan;

        $planStories      = array();
        $unplannedStories = array();
        $stmt = $this->dao->select('id,plan,product,status')->from(TABLE_STORY)->where('deleted')->eq(0)->query();
        while($story = $stmt->fetch())
        {
            if(empty($story->plan))
            {
                $unplannedStories[$story->id] = $story;
                continue;
            }

            $storyPlans   = array();
            $storyPlans[] = $story->plan;
            if(strpos($story->plan, ',') !== false) $storyPlans = explode(',', trim($story->plan, ','));
            foreach($storyPlans as $planID)
            {
                if(isset($plans[$planID]))
                {
                    $planStories[$story->id] = $story;
                    break;
                }
            }
        }

        foreach($planStories as $story)
        {
            $storyPlans = array();
            $storyPlans[] = $story->plan;
            if(strpos($story->plan, ',') !== false) $storyPlans = explode(',', trim($story->plan, ','));
            foreach($storyPlans as $planID)
            {
                if(!isset($plans[$planID])) continue;
                $plan = $plans[$planID];
                $products[$plan->product]->plans[$planID]->status[$story->status] = isset($products[$plan->product]->plans[$planID]->status[$story->status]) ? $products[$plan->product]->plans[$planID]->status[$story->status] + 1 : 1;
            }
        }

        foreach($unplannedStories as $story)
        {
            $product = $story->product;
            if(isset($products[$product]))
            {
                if(!isset($products[$product]->plans[0]))
                {
                    $products[$product]->plans[0] = new stdClass();
                    $products[$product]->plans[0]->title = $this->lang->report->unplanned;
                    $products[$product]->plans[0]->begin = '';
                    $products[$product]->plans[0]->end   = '';
                }
                $products[$product]->plans[0]->status[$story->status] = isset($products[$product]->plans[0]->status[$story->status]) ? $products[$product]->plans[0]->status[$story->status] + 1 : 1;
            }
        }

        unset($products['']);
        return $products;
    }

    /**
     * Get bugs
     *
     * @param  int    $begin
     * @param  int    $end
     * @access public
     * @return array
     */
    public function getBugs($begin, $end, $product, $project)
    {
        $end = date('Ymd', strtotime("$end +1 day"));
        $bugs = $this->dao->select('id, resolution, openedBy, status')->from(TABLE_BUG)
            ->where('deleted')->eq(0)
            ->andWhere('openedDate')->ge($begin)
            ->andWhere('openedDate')->le($end)
            ->beginIF($product)->andWhere('product')->eq($product)->fi()
            ->beginIF($project)->andWhere('project')->eq($project)->fi()
            ->fetchAll();

        $bugCreate = array();
        foreach($bugs as $bug)
        {
            $bugCreate[$bug->openedBy][$bug->resolution] = empty($bugCreate[$bug->openedBy][$bug->resolution]) ? 1 : $bugCreate[$bug->openedBy][$bug->resolution] + 1;
            $bugCreate[$bug->openedBy]['all']            = empty($bugCreate[$bug->openedBy]['all']) ? 1 : $bugCreate[$bug->openedBy]['all'] + 1;
            if($bug->status == 'resolved' or $bug->status == 'closed')
            {
                $bugCreate[$bug->openedBy]['resolved'] = empty($bugCreate[$bug->openedBy]['resolved']) ? 1 : $bugCreate[$bug->openedBy]['resolved'] + 1;
            }
        }

        foreach($bugCreate as $account => $bug)
        {
            $validRate = 0;
            if(isset($bug['fixed']))     $validRate += $bug['fixed'];
            if(isset($bug['postponed'])) $validRate += $bug['postponed'];
            $bugCreate[$account]['validRate'] = (isset($bug['resolved']) and $bug['resolved']) ? ($validRate / $bug['resolved']) : "0";
        }
        uasort($bugCreate, 'sortSummary');
        return $bugCreate;
    }

    /**
     * Get workload.
     *
     * @param int    $dept
     * @param string $assign
     *
     * @access public
     * @return array
     */
    public function getWorkload($dept = 0, $assign = 'assign')
    {
        $deptUsers = array();
        if($dept) $deptUsers = $this->loadModel('dept')->getDeptUserPairs($dept);

        if($assign == 'noassign')
        {
            $members = $this->dao->select('t1.account,t2.name,t1.root')->from(TABLE_TEAM)->alias('t1')
                ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t2.id = t1.root')
                ->where('t2.status')->notin('cancel, closed, done, suspended')
                ->andWhere('t2.deleted')->eq(0)
                ->beginIF($dept)->andWhere('t1.account')->in(array_keys($deptUsers))->fi()
                ->andWhere('t1.type')->eq('project')
                ->andWhere("t1.account NOT IN(SELECT `assignedTo` FROM " . TABLE_TASK . " WHERE `project` = t1.`root` AND `status` NOT IN('cancel, closed, done, pause') AND assignedTo != '' GROUP BY assignedTo)")
                ->fetchGroup('account', 'name');

            $workload = array();
            if(!empty($members))
            {
                foreach($members as $member => $projects)
                {
                    if(!empty($projects))
                    {
                        foreach($projects as $name => $project)
                        {
                            $workload[$member]['task'][$name]['count']     = 0;
                            $workload[$member]['task'][$name]['manhour']   = 0;
                            $workload[$member]['task'][$name]['projectID'] = $project->root;
                            $workload[$member]['total']['count']           = 0;
                            $workload[$member]['total']['manhour']         = 0;
                        }
                    }
                }
            }
            return $workload;
        }

        $stmt = $this->dao->select('t1.*, t2.name as projectName')->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.status')->notin('cancel, closed, done, pause')
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.status')->notin('cancel, closed, done, suspended')
            ->andWhere('assignedTo')->ne('');

        $allTasks = $stmt->fetchAll('id');
        $tasks    = $stmt->beginIF($dept)->andWhere('t1.assignedTo')->in(array_keys($deptUsers))->fi()->fetchAll('id');

        if(empty($allTasks)) return array();

        /* Fix bug for children. */
        $parents       = array();
        $taskIdList    = array();
        $taskGroups    = array();
        foreach($tasks as $task)
        {
            if($task->parent > 0) $parents[$task->parent] = $task->parent;
            $taskGroups[$task->assignedTo][$task->id] = $task;
        }

        $multiTaskTeams = $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('task')
            ->andWhere('root')->in(array_keys($allTasks))
            ->beginIF($dept)->andWhere('account')->in(array_keys($deptUsers))->fi()
            ->fetchGroup('account', 'root');

        foreach($multiTaskTeams as $assignedTo => $multiTasks)
        {
            foreach($multiTasks as $task)
            {
                $userTask = clone $allTasks[$task->root];
                $userTask->estimate = $task->estimate;
                $userTask->consumed = $task->consumed;
                $userTask->left     = $task->left;
                $taskGroups[$assignedTo][$task->root] = $userTask;
            }
        }

        $workload = array();
        foreach($taskGroups as $user => $userTasks)
        {
            if($user)
            {
                foreach($userTasks as $task)
                {
                    if(isset($parents[$task->id])) continue;
                    $workload[$user]['task'][$task->projectName]['count']     = isset($workload[$user]['task'][$task->projectName]['count']) ? $workload[$user]['task'][$task->projectName]['count'] + 1 : 1;
                    $workload[$user]['task'][$task->projectName]['manhour']   = isset($workload[$user]['task'][$task->projectName]['manhour']) ? $workload[$user]['task'][$task->projectName]['manhour'] + $task->left : $task->left;
                    $workload[$user]['task'][$task->projectName]['projectID'] = $task->project;
                    $workload[$user]['total']['count']   = isset($workload[$user]['total']['count'])   ? $workload[$user]['total']['count'] + 1 : 1;
                    $workload[$user]['total']['manhour'] = isset($workload[$user]['total']['manhour']) ? $workload[$user]['total']['manhour'] + $task->left : $task->left;
                }
            }
        }
        unset($workload['closed']);
        return $workload;
    }
     /**
     * Get Tasktime.
     *
     * @param int    $dept    部门
     * @param string $assign  是否派遣
     * @param string $begin  开始时间
     * @param string $end  结束时间
     *
     * @access public
     * @return array
     */
    public function getTasktime($use = 0, $assign = 'assign',$begin,$end)
    {
        if($assign == 'noassign')
        {
            $members = $this->dao->select('t1.account,t2.name,t1.root')->from(TABLE_TEAM)->alias('t1')
                ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t2.id = t1.root')
                ->where('t2.status')->notin('cancel, closed, done, suspended')
                ->andWhere('t2.deleted')->eq(0)
                // ->beginIF($begin)->andWhere("if(realStarted='0000-00-00',assignedDate,realStarted)>="."'$begin'")
                // ->beginIF($end)->andWhere("if(finishedDate='0000-00-00 00:00:00',deadline,finishedDate)<="."'$end'")
                ->beginIF($use)->andWhere('t1.account')->in($use)->fi()
                ->andWhere('t1.type')->eq('project')
                ->andWhere("t1.account NOT IN(SELECT `assignedTo` FROM " . TABLE_TASK . " WHERE `project` = t1.`root` AND `status` NOT IN('cancel, closed, done, pause') AND assignedTo != '' GROUP BY assignedTo)")
                ->fetchGroup('account', 'name');

            $workload = array();
            if(!empty($members))
            {
                foreach($members as $member => $projects)
                {
                    if(!empty($projects))
                    {
                        foreach($projects as $name => $project)
                        {
                            $workload[$member]['task'][$name]['count']     = 0;
                            $workload[$member]['task'][$name]['manhour']   = 0;
                            $workload[$member]['task'][$name]['projectID'] = $project->root;
                            $workload[$member]['total']['count']           = 0;
                            $workload[$member]['total']['manhour']         = 0;
                        }
                    }
                }
            }
            return $workload;
        }
        //获取任务
        if($use){
            $allTasks = $this->dao->query("SELECT
            t.account as assignedTo,
            t1.consumed,
            t1.left,
            IFNULL(0,0) as line,
            GROUP_CONCAT(DISTINCT t.task) as taskid,
            IFNULL(t3.product,t4.product) as product,
            t1.id,t1.parent,t1.story,t1.name,t1.project,
            t2.NAME AS projectName 

        FROM
            `zt_taskestimate` AS t
            LEFT JOIN `zt_task` AS t1 ON t1.id = t.task
            LEFT JOIN `zt_project` AS t2 ON t1.project = t2.id 
            LEFT JOIN `zt_projectstory` AS t3 ON t1.story =t3.story
            LEFT JOIN `zt_projectproduct` AS t4 ON t1.project =t4.project
        WHERE
            t1.deleted = '0' 
            AND t1.STATUS NOT IN ( 'cancel' ) 
            AND t2.deleted = '0' 
            AND t2.STATUS NOT IN ( 'cancel' ) 
            AND assignedTo != '' 
            AND t.account in ("."'$use'".")
            AND t.date BETWEEN "."'$begin'"."
            AND"."'$end'"."
            GROUP BY
            t.task,
            t.account	ORDER BY t.account asc")->fetchAll();
        }else{
            $allTasks = $this->dao->query("SELECT
            t.account as assignedTo,
            t1.consumed,
            t1.left,
            IFNULL(0,0) as line,
            GROUP_CONCAT(DISTINCT t.task) as taskid,
            IFNULL(t3.product,t4.product) as product,
            t1.id,t1.parent,t1.story,t1.name,t1.project,
            t2.NAME AS projectName 
        FROM
            `zt_taskestimate` AS t
            LEFT JOIN `zt_task` AS t1 ON t1.id = t.task
            LEFT JOIN `zt_project` AS t2 ON t1.project = t2.id 
            LEFT JOIN `zt_projectstory` AS t3 ON t1.story =t3.story
            LEFT JOIN `zt_projectproduct` AS t4 ON t1.project =t4.project
        WHERE
            t1.deleted = '0' 
            AND t1.STATUS NOT IN ( 'cancel' ) 
            AND t2.deleted = '0' 
            AND t2.STATUS NOT IN ( 'cancel' ) 
            AND assignedTo != '' 
            AND t.date BETWEEN "."'$begin'"."
            AND"."'$end'"."
            GROUP BY
            t.task,
            t.account	ORDER BY t.account asc")->fetchAll();
        }
        if(empty($allTasks)) return array();
        //消耗工时单独做
        $consumeds=array();
        $consumed =$this->dao->query("SELECT
        task,account,
        cast(sum(consumed) AS DECIMAL(10, 2))as consumed
        FROM
            `zt_taskestimate`
        WHERE
        date BETWEEN "."'$begin'"."
        AND"."'$end'"."
        GROUP BY
        task,account ORDER BY account asc")->fetchAll();
        foreach($consumed as $val){
            $consumeds[$val->task][$val->account]=$val->consumed;
        }

        $tasks=$allTasks;
        $products =$this->loadModel('tree')->ReturnP(); //产品

        /* Fix bug for children. */
        $parents       = array();
        $taskGroups    = array();
        $tasklist      =array();
        foreach($tasks as $task)
        {
            $tasklist[]=$task->id;
            if($task->parent > 0) $parents[$task->parent] = $task->parent;
            //更改消耗
            $task->consumed=$consumeds[$task->id][$task->assignedTo];
            $taskGroups[$task->assignedTo][$task->id] = $task;
        }
        // //是否是团队中的，然后把时间更改
        // $multiTaskTeams = $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('task')
        // ->andWhere('root')->in(implode(",", $tasklist))
        // ->beginIF($use)->andWhere('account')->in($use)->fi()
        // ->fetchGroup('account', 'root');

        // foreach($multiTaskTeams as $assignedTo => $multiTasks)
        // {
        //     foreach($multiTasks as $task)
        //     {
        //         $userTask = $taskGroups[$task->account][$task->root];
        //         if(isset($userTask)){
        //             $userTask->estimate = $task->estimate;
        //             $userTask->consumed = $task->consumed;
        //             $userTask->left     = $task->left;
        //             $taskGroups[$assignedTo][$task->root] = $userTask;
        //         }
        //     }
        // }
        $workload = array();
        foreach($taskGroups as $user => $userTasks)
        {
            if($user)
            {
                foreach($userTasks as $t=>$task)
                {
                    //过滤掉父集任务，只保留子集
                    if(isset($parents[$task->id])) continue;
                    $workload[$user]['task'][$task->projectName]['count']     = isset($workload[$user]['task'][$task->projectName]['count']) ? $workload[$user]['task'][$task->projectName]['count'] + 1 : 1;
                    $workload[$user]['task'][$task->projectName]['manhour']   = isset($workload[$user]['task'][$task->projectName]['manhour']) ? $workload[$user]['task'][$task->projectName]['manhour'] + $task->left : $task->left;
                    $workload[$user]['task'][$task->projectName]['consumed']   = isset($workload[$user]['task'][$task->projectName]['consumed']) ? $workload[$user]['task'][$task->projectName]['consumed'] + $task->consumed : $task->consumed;
                    $workload[$user]['task'][$task->projectName]['projectID'] = $task->project;
                    //任务
                    $workload[$user]['task'][$task->projectName]['task'][$t] = $task->name;
                    //产品
                    $workload[$user]['task'][$task->projectName]['product'][$task->product] = $products[$task->product]->name;

                    $workload[$user]['total']['count']   = isset($workload[$user]['total']['count'])   ? $workload[$user]['total']['count'] + 1 : 1;
                    $workload[$user]['total']['manhour'] = isset($workload[$user]['total']['manhour']) ? $workload[$user]['total']['manhour'] + $task->left : $task->left;
                    $workload[$user]['total']['consumed'] = isset($workload[$user]['total']['consumed']) ? $workload[$user]['total']['consumed'] + $task->consumed : $task->consumed;
                }
            }
        }
        unset($workload['closed']);
        return $workload;
    }
    /**
     * Get TaskgetTaskproduct.
     *
     * @param int    $dept    产品
     * @param string $assign  是否派遣
     * @param string $begin  开始时间
     * @param string $end  结束时间
     *
     * @access public
     * @return array
     */
    public function getTaskproduct($pro = 0, $assign = 'assign',$begin,$end)
    {
        if($assign == 'noassign')
        {
            $members = $this->dao->select('t1.account,t2.name,t1.root')->from(TABLE_TEAM)->alias('t1')
                ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t2.id = t1.root')
                ->where('t2.status')->notin('cancel, closed, done, suspended')
                ->andWhere('t2.deleted')->eq(0)
                ->andWhere('t1.type')->eq('project')
                ->andWhere("t1.account NOT IN(SELECT `assignedTo` FROM " . TABLE_TASK . " WHERE `project` = t1.`root` AND `status` NOT IN('cancel, closed, done, pause') AND assignedTo != '' GROUP BY assignedTo)")
                ->fetchGroup('account', 'name');

            $workload = array();
            if(!empty($members))
            {
                foreach($members as $member => $projects)
                {
                    if(!empty($projects))
                    {
                        foreach($projects as $name => $project)
                        {
                            $workload[$member]['task'][$name]['count']     = 0;
                            $workload[$member]['task'][$name]['manhour']   = 0;
                            $workload[$member]['task'][$name]['projectID'] = $project->root;
                            $workload[$member]['total']['count']           = 0;
                            $workload[$member]['total']['manhour']         = 0;
                        }
                    }
                }
            }
            return $workload;
        }
        //获取任务
        // 一个项目关联一个产品，如果没有需求，只取第一个产品需求
        $allTasks = $this->dao->query("SELECT
            t.account as assignedTo,
            t1.consumed,
            t1.left,
            IFNULL(0,0) as line,
            t1.id,t1.parent,t1.story,t1.name,t1.project,
            IFNULL(t3.product,t4.product) as product,
            t2.NAME AS projectName 
        FROM
            `zt_taskestimate` AS t
            LEFT JOIN `zt_task` AS t1 ON t1.id = t.task
            LEFT JOIN `zt_project` AS t2 ON t1.project = t2.id 
            LEFT JOIN `zt_projectstory` AS t3 ON t1.story =t3.story
            LEFT JOIN `zt_projectproduct` AS t4 ON t1.project =t4.project
        WHERE
            t1.deleted = '0' 
            AND t1.STATUS NOT IN ( 'cancel' ) 
            AND t2.deleted = '0' 
            AND t2.STATUS NOT IN ( 'cancel' ) 
            AND assignedTo != '' 
            AND t.date BETWEEN "."'$begin'"."
            AND"."'$end'"."
            GROUP BY
            t.task,
            t.account	ORDER BY t.date desc")->fetchAll();
        if(empty($allTasks)) return array();
        //消耗工时单独做
        $consumeds=array();
        $consumed =$this->dao->query("SELECT
        task,account,
        cast(sum(consumed) AS DECIMAL(10, 2))as consumed
        FROM
            `zt_taskestimate`
        WHERE
        date BETWEEN "."'$begin'"."
        AND"."'$end'"."
        GROUP BY
        task,account ORDER BY account asc")->fetchAll();
        foreach($consumed as $val){
            $consumeds[$val->task][$val->account]=$val->consumed;
        }
        $product=$this->loadModel('tree')->ReturnP();
        $tasks=$allTasks;
        /* Fix bug for children. */
        $parents       = array();
        $taskGroups    = array();
        $taskProduct   = array();
        $tasklist      = array();
        $taskPro       = array();

        foreach($tasks as $task)
        {
            $tasklist[]=$task->id;
            if($task->parent > 0) $parents[$task->parent] = $task->parent;
            $task->line= $product[$task->product]->line;
            //更改消耗
            $task->consumed=$consumeds[$task->id][$task->assignedTo];
            $taskProduct[$task->assignedTo][$task->id] = $task;
        }

        //是否是团队中的，然后把消耗时间更改
        // $multiTaskTeams = $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('task')
        // ->andWhere('root')->in(implode(",", $tasklist))
        // ->fetchGroup('account', 'root');
        // // var_dump($multiTaskTeams);
        // //消耗工时
        // foreach($multiTaskTeams as $assignedTo => $multiTasks)
        // {
        //     foreach($multiTasks as $task)
        //     {
        //         $userTask =$taskProduct[$assignedTo][$task->root];
        //         if(isset($userTask)){
        //             $userTask->estimate = $task->estimate;
        //             $userTask->consumed = $task->consumed;
        //             $userTask->left     = $task->left;
        //             $taskProduct[$assignedTo][$task->root] = $userTask;
        //         }
        //     }
        // }
        //组合元素
        foreach($taskProduct as $assignedTo=>$tasks)
        {
            foreach($tasks as $ids=>$task){
                $taskPro[$task->line][$task->product][$assignedTo][$ids]= $task;
            }
        }
        foreach($taskPro as $list => $p)
        {
            if($list)
            {
                foreach($p as $pro=>$users)
                { 
                    foreach($users as $us=> $taskid)
                    {
                        foreach($taskid as $t=> $products)
                        {
                            //过滤掉父集任务，只保留子集
                            if(isset($parents[$products->id])) continue;
                            //用户清单
                            $workload[$list][$pro]['user'][]=$us;
                            //项目清单
                            $workload[$list][$pro]['projectName'][$products->project]=$products->projectName;
                            //任务清单
                            $workload[$list][$pro]['task'][]=$t;
                            //剩余时间
                            $workload[$list][$pro]['manhour']   = isset($workload[$list][$pro]['manhour']) ? $workload[$list][$pro]['manhour'] +  $products->left : $products->left;
                            //消耗时间
                            $workload[$list][$pro]['consumed']   = isset($workload[$list][$pro]['consumed']) ? $workload[$list][$pro]['consumed'] +  $products->consumed :  $products->consumed;
                            //总计
                            $workload['users'][]=$us;
                            $workload[$list]['task'][]=$t;
                            $workload[$list]['user'][]=$us;
                            $workload[$list]['total']['manhour'] = isset($workload[$list]['total']['manhour']) ? $workload[$list]['total']['manhour'] + $products->left : $products->left;
                            $workload[$list]['total']['consumed'] = isset($workload[$list]['total']['consumed']) ? $workload[$list]['total']['consumed'] + $products->consumed : $products->consumed;
                        }
                    }
                }
            }
        }
        $workload['users']=array_unique($workload['users']);
        unset($workload['closed']);
        return $workload;
    }
    /**
     * Get TaskgetUserproduct.
     *
     * @param int    $dept    产品
     * @param string $use  用户
     * @param string $begin  开始时间
     * @param string $end  结束时间
     *
     * @access public
     * @return array
     */
    public function getUserproduct($pro = 0,$use,$begin,$end,$workday=8)
    {
        //获取任务
        // 一个项目关联一个产品，如果没有需求，只取第一个产品需求
        $allTasks = $this->dao->query("SELECT
            t.account as assignedTo,
            t1.consumed,
            t1.left,
            IFNULL(0,0) as line,
            t1.id,t1.parent,t1.story,t1.name,t1.project,
            IFNULL(t3.product,t4.product) as product,
            t2.NAME AS projectName 
        FROM
            `zt_taskestimate` AS t
            LEFT JOIN `zt_task` AS t1 ON t1.id = t.task
            LEFT JOIN `zt_project` AS t2 ON t1.project = t2.id 
            LEFT JOIN `zt_projectstory` AS t3 ON t1.story =t3.story
            LEFT JOIN `zt_projectproduct` AS t4 ON t1.project =t4.project
        WHERE
            t1.deleted = '0' 
            AND t1.STATUS NOT IN ( 'cancel' ) 
            AND t2.deleted = '0' 
            AND t2.STATUS NOT IN ( 'cancel' ) 
            AND assignedTo != '' 
            AND t.date BETWEEN "."'$begin'"."
            AND"."'$end'"."
            GROUP BY
            t.task,
            t.account	ORDER BY t.date desc")->fetchAll();

        if(empty($allTasks)) return array();
        //消耗工时单独做
        $consumeds=array();
        $consumed =$this->dao->query("SELECT
        task,account,
        cast(sum(consumed) AS DECIMAL(10, 2))as consumed
        FROM
            `zt_taskestimate`
        WHERE
        date BETWEEN "."'$begin'"."
        AND"."'$end'"."
        GROUP BY
        task,account ORDER BY account asc")->fetchAll();
        foreach($consumed as $val){
            $consumeds[$val->task][$val->account]=$val->consumed;
        }
        $product=$this->loadModel('tree')->ReturnP();
        $tasks=$allTasks;
        /* Fix bug for children. */
        $parents       = array();
        $taskProduct   = array();
        $tasklist      = array();
        $taskPro       = array();

        foreach($tasks as $task)
        {
            $tasklist[]=$task->id;
            if($task->parent > 0) $parents[$task->parent] = $task->parent;
            $task->line= $product[$task->product]->line;
            //更改消耗
            $task->consumed=$consumeds[$task->id][$task->assignedTo];
            $taskProduct[$task->assignedTo][$task->id] = $task;
        }
        //组合元素
        foreach($taskProduct as $assignedTo=>$tasks)
        {
            if(empty($use)){
                foreach($tasks as $ids=>$task){
                    $taskPro[$task->line][$task->product][$assignedTo][$ids]= $task;
                }
            }else{
                if($assignedTo==$use){
                    foreach($tasks as $ids=>$task){
                        $taskPro[$task->line][$task->product][$assignedTo][$ids]= $task;
                    }
                }
            }
        }
        // 工作天数
        $days=$this->get_weekend_days($begin, $end);

        foreach($taskPro as $list => $p)
        {
            if($list)
            {
                foreach($p as $pro=>$users)
                {
                    foreach($users as $us=> $taskid)
                    {
                        foreach($taskid as $t=> $products)
                        {
                            //过滤掉父集任务，只保留子集
                            if(isset($parents[$products->id])) continue;
                            //人员
                            $workload[$list][$pro]['user'][]=$us;
                            $Users[$us][$pro]=isset($workload[$list][$pro][$us]['consumed']) ? number_format($workload[$list][$pro][$us]['consumed'] +  $products->consumed/$workday,1) :  number_format($products->consumed/$workday,1);

                            //产品人员消耗时间
                            $workload[$list][$pro][$us]['consumed'] = isset($workload[$list][$pro][$us]['consumed']) ? number_format($workload[$list][$pro][$us]['consumed'] +  $products->consumed/$workday,1) :  number_format($products->consumed/$workday,1);

                            //产品线人员剩余时间
                            $workload[$list][$us]['lmanhour']  = isset($workload[$list][$us]['lmanhour']) ? $workload[$list][$us]['lmanhour'] +  $products->left : $products->left;
                            //产品线人员消耗时间
                            $workload[$list][$us]['lconsumed'] = isset($workload[$list][$us]['lconsumed']) ? number_format($workload[$list][$us]['lconsumed'] +  $products->consumed/$workday,1) :  number_format($products->consumed/$workday,1);

                            //总计
                            $workload[$list]['user'][]=$us;
                            $workload['users'][]=$us;
                            $workload[$list]['total']['manhour'] = isset($workload[$list]['total']['manhour']) ? $workload[$list]['total']['manhour'] + $products->left : $products->left;
                            $workload[$list]['total']['consumed'] = isset($workload[$list]['total']['consumed']) ? number_format($workload[$list]['total']['consumed'] + $products->consumed/$workday,1) : number_format($products->consumed/$workday,1);
                        }
                    }
                }
            }
        }
        $Uselist=$this->getUsetime($Users,$days);
        $workload['uselist']=$Uselist;
        unset($workload['closed']);
        return $workload;
    }
    /**
     * 生成0~1随机小数
     * @param  Int   $min
     * @param  Int   $max
     * @return Float
     */
    public function randFloat($min=0, $max=1){
        return $min + mt_rand()/mt_getrandmax() * ($max-$min);
    }
    /**
     * Get Usertime.
     * | @param array $array 人员时间消耗
     * | @param int   $sum  总工时
     * | @param int   $time  工时
     * | @return array
    */
    public function getUsetime($array,$days)
    {
        $use=array();
        $list=array();
        if($array){
            foreach($array as $k=>$v){
                $Usum=array_sum($v);
                foreach($v as $kk=>$va){
                    if($Usum>$days){
                        $use[$k][$kk]=$va;
                    }else{
                        $use[$k][$kk]=$this->upDecimal(($va/$Usum)*($days+$this->randFloat(0,1)),1);
                    }
                }
            }
        }
        if($use){
            foreach($use as $uk=>$uv){
                foreach($uv as $lk=>$lv){
                        $list[$lk]+=$lv;
                }
            }
        }
        $uses['use']=$use;
        $uses['list']=$list;
        return $uses;
    }
    /**
     * 对时间进行向上或向下取整
     * @param $price    时间
     * @param $decimal  保留小数位数
     * @param $type 1：向上 2：向下
     */
    public function upDecimal($num, $qty = 2, $type = 1){
        $num2 =  explode('.', $num);
        $dcmnum = $num2[1]?$num2[1]:0;

        $subnum = 0;
        if($dcmnum > 0){
            $subnum = bcsub(strlen($dcmnum), $qty, 10);
        }
        $powint = bcpow(10, $qty);
        $num = bcmul($num, $powint, $subnum);
        $numArr = explode('.', $num);
        $num = $numArr[0];
        $dcm = $numArr[1] ?$numArr[1]:0;
        if($dcm > 0){
            if($type == 1 && $num > 0){
                $num = $num + 1;
            }elseif($type == 2 && $num < 0){
                $num = $num - 1;
            }
        }
        return bcdiv($num, $powint, $qty);
    }
     /**
     * Get Taskload.
     *
     * @param int    $dept    部门
     * @param string $assign  是否派遣
     * @param string $begin  开始时间
     * @param string $end  结束时间
     *
     * @access public
     * @return array
     */
    public function getTaskload($dept = 0, $assign = 'assign')
    {
        $deptUsers = array();
        if($dept) $deptUsers = $this->loadModel('dept')->getDeptUserPairs($dept);

        if($assign == 'noassign')
        {
            $members = $this->dao->select('t1.account,t2.name,t1.root')->from(TABLE_TEAM)->alias('t1')
                ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t2.id = t1.root')
                ->where('t2.status')->notin('cancel, closed, done, suspended')
                ->andWhere('t2.deleted')->eq(0)
                ->beginIF($dept)->andWhere('t1.account')->in(array_keys($deptUsers))->fi()
                ->andWhere('t1.type')->eq('project')
                ->andWhere("t1.account NOT IN(SELECT `assignedTo` FROM " . TABLE_TASK . " WHERE `project` = t1.`root` AND `status` NOT IN('cancel, closed, done, pause') AND assignedTo != '' GROUP BY assignedTo)")
                ->fetchGroup('account', 'name');

            $workload = array();
            if(!empty($members))
            {
                foreach($members as $member => $projects)
                {
                    if(!empty($projects))
                    {
                        foreach($projects as $name => $project)
                        {
                            $workload[$member]['task'][$name]['count']     = 0;
                            $workload[$member]['task'][$name]['manhour']   = 0;
                            $workload[$member]['task'][$name]['projectID'] = $project->root;
                            $workload[$member]['total']['count']           = 0;
                            $workload[$member]['total']['manhour']         = 0;
                        }
                    }
                }
            }
            return $workload;
        }

        $stmt = $this->dao->select('t1.*, t2.name as projectName')->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.status')->notin('cancel, closed, done, pause')
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.status')->notin('cancel, closed, done, suspended')
            ->andWhere('assignedTo')->ne('');

        $allTasks = $stmt->fetchAll('id');
        $tasks    = $stmt->beginIF($dept)->andWhere('t1.assignedTo')->in(array_keys($deptUsers))->fi()->fetchAll('id');

        if(empty($allTasks)) return array();

        /* Fix bug for children. */
        $parents       = array();
        $taskIdList    = array();
        $taskGroups    = array();
        foreach($tasks as $task)
        {
            if($task->parent > 0) $parents[$task->parent] = $task->parent;
            $taskGroups[$task->assignedTo][$task->id] = $task;
        }

        $multiTaskTeams = $this->dao->select('*')->from(TABLE_TEAM)->where('type')->eq('task')
            ->andWhere('root')->in(array_keys($allTasks))
            ->beginIF($dept)->andWhere('account')->in(array_keys($deptUsers))->fi()
            ->fetchGroup('account', 'root');
        foreach($multiTaskTeams as $assignedTo => $multiTasks)
        {
            foreach($multiTasks as $task)
            {
                $userTask = clone $allTasks[$task->root];
                $userTask->estimate = $task->estimate;
                $userTask->consumed = $task->consumed;
                $userTask->left     = $task->left;
                $taskGroups[$assignedTo][$task->root] = $userTask;
            }
        }

        $workload = array();
        foreach($taskGroups as $user => $userTasks)
        {
            if($user)
            {
                foreach($userTasks as $task)
                {
                    if(isset($parents[$task->id])) continue;
                    $workload[$user]['task'][$task->projectName]['count']     = isset($workload[$user]['task'][$task->projectName]['count']) ? $workload[$user]['task'][$task->projectName]['count'] + 1 : 1;
                    $workload[$user]['task'][$task->projectName]['manhour']   = isset($workload[$user]['task'][$task->projectName]['manhour']) ? $workload[$user]['task'][$task->projectName]['manhour'] + $task->left : $task->left;
                    $workload[$user]['task'][$task->projectName]['projectID'] = $task->project;
                    $workload[$user]['total']['count']   = isset($workload[$user]['total']['count'])   ? $workload[$user]['total']['count'] + 1 : 1;
                    $workload[$user]['total']['manhour'] = isset($workload[$user]['total']['manhour']) ? $workload[$user]['total']['manhour'] + $task->left : $task->left;
                }
            }
        }
        unset($workload['closed']);
        return $workload;
    }
    /**
     * | Author: Saron.Mo <momosweb@qq.com>
     * | @param char|int $start_date 一个有效的日期格式，例如：20091016，2009-10-16
     * | @param char|int $end_date 同上
     * | @param int $weekend_days 一周休息天数
     * | @return array
     * | array[total_days]  给定日期之间的总天数
     * | array[total_relax] 给定日期之间的周末天数
    */
    public function get_weekend_days($start_date, $end_date, $weekend_days=2) 
    {
            $data = array();
            if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);
            $start_reduce = $end_add = 0;
            $start_N      = date('N',strtotime($start_date));
            $start_reduce = ($start_N == 7) ? 1 : 0;
            $end_N = date('N',strtotime($end_date));
            // 进行单、双休判断，默认按单休计算
            $weekend_days = intval($weekend_days);
            switch ($weekend_days)
            {
                case 2:
                    in_array($end_N,array(6,7)) && $end_add = ($end_N == 7) ? 2 : 1;
                    break;
                case 1:
                default:
                    $end_add = ($end_N == 7) ? 1 : 0;
                    break;
            }
            $days = round(abs(strtotime($end_date) - strtotime($start_date))/86400) + 1;
            $data['total_days'] = $days;
            $data['total_relax'] = floor(($days + $start_N - 1 - $end_N) / 7) * $weekend_days - $start_reduce + $end_add;
            return $data['total_days']-$data['total_relax'];
    }

    /**
     * Get bug assign.
     *
     * @access public
     * @return array
     */
    public function getBugAssign()
    {
        $bugs = $this->dao->select('t1.*, t2.name as productName')->from(TABLE_BUG)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product = t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.status')->eq('active')
            ->andWhere('t2.deleted')->eq(0)
            ->fetchGroup('assignedTo');
        $assign = array();
        foreach($bugs as $user => $userBugs)
        {
            if($user)
            {
                foreach($userBugs as $bug)
                {
                    $assign[$user]['bug'][$bug->productName]['count']     = isset($assign[$user]['bug'][$bug->productName]['count']) ? $assign[$user]['bug'][$bug->productName]['count'] + 1 : 1;
                    $assign[$user]['bug'][$bug->productName]['productID'] = $bug->product;
                    $assign[$user]['total']['count']   = isset($assign[$user]['total']['count']) ? $assign[$user]['total']['count'] + 1 : 1;
                }
            }
        }
        unset($assign['closed']);
        return $assign;
    }

    /**
     * Get System URL.
     *
     * @access public
     * @return void
     */
    public function getSysURL()
    {
        if(isset($this->config->mail->domain)) return $this->config->mail->domain;

        /* Ger URL when run in shell. */
        if(PHP_SAPI == 'cli')
        {
            $url = parse_url(trim($this->server->argv[1]));
            $port = (empty($url['port']) or $url['port'] == 80) ? '' : $url['port'];
            $host = empty($port) ? $url['host'] : $url['host'] . ':' . $port;
            return $url['scheme'] . '://' . $host;
        }
        else
        {
            return common::getSysURL();
        }
    }

    /**
     * Get user bugs.
     *
     * @access public
     * @return void
     */
    public function getUserBugs()
    {
        return $this->dao->select('t1.id, t1.title, t2.account as user, t1.deadline')
            ->from(TABLE_BUG)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')
            ->on('t1.assignedTo = t2.account')
            ->where('t1.assignedTo')->ne('')
            ->andWhere('t1.assignedTo')->ne('closed')
            ->andWhere('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.deadline', true)->eq('0000-00-00')
            ->orWhere('t1.deadline')->lt(date(DT_DATE1, strtotime('+4 day')))
            ->markRight(1)
            ->fetchGroup('user');
    }

    /**
     * Get user tasks.
     *
     * @access public
     * @return void
     */
    public function getUserTasks()
    {
        return $this->dao->select('t1.id, t1.name, t2.account as user, t1.deadline')->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.assignedTo = t2.account')
            ->leftJoin(TABLE_PROJECT)->alias('t3')->on('t1.project = t3.id')
            ->where('t1.assignedTo')->ne('')
            ->andWhere('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.status')->in('wait,doing')
            ->andWhere('t3.status')->ne('suspended')
            ->andWhere('t1.deadline', true)->eq('0000-00-00')
            ->orWhere('t1.deadline')->lt(date(DT_DATE1, strtotime('+4 day')))
            ->markRight(1)
            ->fetchGroup('user');
    }

    /**
     * Get user todos.
     *
     * @access public
     * @return array
     */
    public function getUserTodos()
    {
        $stmt = $this->dao->select('t1.*, t2.account as user')
            ->from(TABLE_TODO)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')
            ->on('t1.account = t2.account')
            ->where('t1.status')->eq('wait')
            ->orWhere('t1.status')->eq('doing')
            ->query();

        $todos = array();
        while($todo = $stmt->fetch())
        {
            if($todo->type == 'task') $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_TASK)->fetch('name');
            if($todo->type == 'bug')  $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_BUG)->fetch('title');
            $todos[$todo->user][] = $todo;
        }
        return $todos;
    }

    /**
     * Get user testTasks.
     *
     * @access public
     * @return array
     */
    public function getUserTestTasks()
    {
        return $this->dao->select('t1.*, t2.account as user')->from(TABLE_TESTTASK)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.owner = t2.account')
            ->where('t1.deleted')->eq('0')
            ->andWhere('t2.deleted')->eq('0')
            ->andWhere("(t1.status='wait' OR t1.status='doing')")
            ->fetchGroup('user');
    }
}

/**
 * @param $pre
 * @param $next
 *
 * @return int*/
function sortSummary($pre, $next)
{
    if($pre['validRate'] == $next['validRate']) return 0;
    return $pre['validRate'] > $next['validRate'] ? -1 : 1;
}

