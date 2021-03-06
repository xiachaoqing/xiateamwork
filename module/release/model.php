<?php
/**
 * The model file of release module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     release
 * @version     $Id: model.php 4129 2013-01-18 01:58:14Z wwccss $
*/
?>
<?php
class releaseModel extends model
{
    /**
     * Get release by id.
     * 
     * @param  int    $releaseID 
     * @param  bool   $setImgSize
     * @access public
     * @return object
     */
    public function getByID($releaseID, $setImgSize = false)
    {
        $release = $this->dao->select('t1.*, t2.id as buildID, t2.filePath, t2.scmPath, t2.name as buildName, t2.project, t3.name as productName, t3.type as productType')
            ->from(TABLE_RELEASE)->alias('t1')
            ->leftJoin(TABLE_BUILD)->alias('t2')->on('t1.build = t2.id')
            ->leftJoin(TABLE_PRODUCT)->alias('t3')->on('t1.product = t3.id')
            ->where('t1.id')->eq((int)$releaseID)
            ->orderBy('t1.id DESC')
            ->fetch();
        if(!$release) return false;

        $this->loadModel('file');
        $release = $this->file->replaceImgURL($release, 'desc');
        $release->files = $this->file->getByObject('release', $releaseID);
        if(empty($release->files))$release->files = $this->file->getByObject('build', $release->buildID);
        if($setImgSize) $release->desc = $this->file->setImgSize($release->desc);
        return $release;
    }

    /**
     * Get list of releases.
     * 
     * @param  int    $productID 
     * @access public
     * @return array
     */
    public function getList($productID, $branch = 0)
    {
        return $this->dao->select('t1.*, t2.name as productName, t3.id as buildID, t3.name as buildName')
            ->from(TABLE_RELEASE)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product = t2.id')
            ->leftJoin(TABLE_BUILD)->alias('t3')->on('t1.build = t3.id')
            ->where('t1.product')->eq((int)$productID)
            ->beginIF($branch)->andWhere('t1.branch')->eq($branch)->fi()
            ->andWhere('t1.deleted')->eq(0)
            ->orderBy('t1.date DESC')
            ->fetchAll();
    }

    /**
     * Get last release.
     * 
     * @param  int    $productID 
     * @access public
     * @return bool | object 
     */
    public function getLast($productID, $branch = 0)
    {
        return $this->dao->select('id, name')->from(TABLE_RELEASE)
            ->where('product')->eq((int)$productID)
            ->beginIF($branch)->andWhere('branch')->eq($branch)->fi()
            ->orderBy('date DESC')
            ->limit(1)
            ->fetch();
    }

    /**
     * Get release builds from product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function getReleaseBuilds($productID, $branch = 0)
    {
        $releases = $this->dao->select('build')->from(TABLE_RELEASE)
            ->where('deleted')->eq(0)
            ->andWhere('product')->eq($productID)
            ->beginIF($branch)->andWhere('branch')->eq($branch)->fi()
            ->fetchAll('build');
        return array_keys($releases);
    }

    /**
     * Create a release.
     * 
     * @param  int    $productID 
     * @access public
     * @return int
     */
    public function create($productID, $branch = 0)
    {
        $productID = (int)$productID;
        $branch    = (int)$branch;
        $buildID   = 0;
        if($this->post->build == false && $this->post->name)
        {
            $build = $this->dao->select('*')->from(TABLE_BUILD)
                ->where('deleted')->eq('0')
                ->andWhere('name')->eq($this->post->name)
                ->andWhere('product')->eq($productID)
                ->andWhere('branch')->eq($branch)
                ->fetch();
            if($build)
            {
                dao::$errors['build'] = sprintf($this->lang->release->existBuild, $this->post->name);
            }
            else
            {
                $build = fixer::input('post')
                    ->add('product', (int)$productID)
                    ->add('builder', $this->app->user->account)
                    ->add('branch', $branch)
                    ->stripTags($this->config->release->editor->create['id'], $this->config->allowedTags)
                    ->remove('marker,build,files,labels,uid')
                    ->get();
                $build = $this->loadModel('file')->processImgURL($build, $this->config->release->editor->create['id']);
                $this->dao->insert(TABLE_BUILD)->data($build)
                    ->autoCheck()
                    ->check('name', 'unique', "product = {$productID} AND branch = {$branch} AND deleted = '0'")
                    ->batchCheck($this->config->release->create->requiredFields, 'notempty')
                    ->exec();
                $buildID = $this->dao->lastInsertID();
            }
        }

        if($this->post->build) $branch = $this->dao->select('branch')->from(TABLE_BUILD)->where('id')->eq($this->post->build)->fetch('branch');
        $release = fixer::input('post')
            ->add('product', (int)$productID)
            ->add('branch',  (int)$branch)
            ->setDefault('stories', '')
            ->join('stories', ',')
            ->join('bugs', ',')
            ->setIF($this->post->build == false, 'build', $buildID)
            ->stripTags($this->config->release->editor->create['id'], $this->config->allowedTags)
            ->remove('allchecker,files,labels,uid')
            ->get();

        $release = $this->loadModel('file')->processImgURL($release, $this->config->release->editor->create['id'], $this->post->uid);
        $this->dao->insert(TABLE_RELEASE)->data($release)
            ->autoCheck()
            ->batchCheck($this->config->release->create->requiredFields, 'notempty')
            ->check('name', 'unique', "product = {$release->product} AND branch = $branch AND deleted = '0'");

        if(dao::isError())
        {
            if($buildID) $this->dao->delete()->from(TABLE_BUILD)->where('id')->eq($buildID)->exec();
            return false;
        }

        $this->dao->exec();

        if(dao::isError())
        {
            if($buildID) $this->dao->delete()->from(TABLE_BUILD)->where('id')->eq($buildID)->exec();
        }
        else
        {
            $releaseID = $this->dao->lastInsertID();
            $this->file->updateObjectID($this->post->uid, $releaseID, 'release');
            $this->file->saveUpload('release', $releaseID);
            $this->loadModel('score')->create('release', 'create', $releaseID);

            return $releaseID;
        }

        return false;
    }

    /**
     * Update a release.
     * 
     * @param  int    $releaseID 
     * @access public
     * @return void
     */
    public function update($releaseID)
    {
        $releaseID  = (int)$releaseID;
        $oldRelease = $this->dao->select('*')->from(TABLE_RELEASE)->where('id')->eq($releaseID)->fetch();
        $branch     = $this->dao->select('branch')->from(TABLE_BUILD)->where('id')->eq((int)$this->post->build)->fetch('branch');

        $release = fixer::input('post')->stripTags($this->config->release->editor->edit['id'], $this->config->allowedTags)
            ->add('branch',  (int)$branch)
            ->setIF(!$this->post->marker, 'marker', 0)
            ->cleanInt('product')
            ->remove('files,labels,allchecker,uid')
            ->get();
        $release = $this->loadModel('file')->processImgURL($release, $this->config->release->editor->edit['id'], $this->post->uid);
        $this->dao->update(TABLE_RELEASE)->data($release)
            ->autoCheck()
            ->batchCheck($this->config->release->edit->requiredFields, 'notempty')
            ->check('name', 'unique', "id != '$releaseID' AND product = '{$release->product}' AND branch = '$branch' AND deleted = '0'")
            ->where('id')->eq((int)$releaseID)
            ->exec();
        if(!dao::isError())
        {
            $this->file->updateObjectID($this->post->uid, $releaseID, 'release');
            return common::createChanges($oldRelease, $release);
        }
    }

    /**
     * Link stories
     * 
     * @param  int    $releaseID 
     * @access public
     * @return void
     */
    public function linkStory($releaseID)
    {
        $release = $this->getByID($releaseID);

        $release->stories .= ',' . join(',', $this->post->stories);
        $this->dao->update(TABLE_RELEASE)->set('stories')->eq($release->stories)->where('id')->eq((int)$releaseID)->exec();
        if($release->stories)
        {
            $this->loadModel('story');
            foreach($this->post->stories as $storyID)
            {
                $this->story->setStage($storyID);
                $this->loadModel('action')->create('story', $storyID, 'linked2release', '', $releaseID);
            }
        }
    }

    /**
     * Unlink story 
     * 
     * @param  int    $releaseID 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function unlinkStory($releaseID, $storyID)
    {
        $release = $this->getByID($releaseID);
        $release->stories = trim(str_replace(",$storyID,", ',', ",$release->stories,"), ',');
        $this->dao->update(TABLE_RELEASE)->set('stories')->eq($release->stories)->where('id')->eq((int)$releaseID)->exec();
        $this->loadModel('action')->create('story', $storyID, 'unlinkedfromrelease', '', $releaseID);
    }

    /**
     * Batch unlink story.
     * 
     * @param  int    $releaseID 
     * @access public
     * @return void
     */
    public function batchUnlinkStory($releaseID)
    {
        $storyList = $this->post->unlinkStories;
        if(empty($storyList)) return true;

        $release = $this->getByID($releaseID);
        $release->stories = ",$release->stories,";
        foreach($storyList as $storyID) $release->stories = str_replace(",$storyID,", ',', $release->stories);
        $release->stories = trim($release->stories, ',');
        $this->dao->update(TABLE_RELEASE)->set('stories')->eq($release->stories)->where('id')->eq((int)$releaseID)->exec();
        foreach($this->post->unlinkStories as $unlinkStoryID)
        {
            $this->loadModel('action')->create('story', $unlinkStoryID, 'unlinkedfromrelease', '', $releaseID);
        }
    }

    /**
     * Link bugs.
     * 
     * @param  int    $releaseID 
     * @access public
     * @return void
     */
    public function linkBug($releaseID, $type = 'bug')
    {
        $release = $this->getByID($releaseID);

        $field = $type == 'bug' ? 'bugs' : 'leftBugs';
        $release->$field .= ',' . join(',', $this->post->bugs);
        $this->dao->update(TABLE_RELEASE)->set($field)->eq($release->$field)->where('id')->eq((int)$releaseID)->exec();
        foreach($this->post->bugs as $bugID)
        {
            $this->loadModel('action')->create('bug', $bugID, 'linked2release', '', $releaseID);
        }
    }

    /**
     * Unlink bug. 
     * 
     * @param  int    $releaseID 
     * @param  int    $bugID 
     * @access public
     * @return void
     */
    public function unlinkBug($releaseID, $bugID, $type = 'bug')
    {
        $release = $this->getByID($releaseID);
        $field = $type == 'bug' ? 'bugs' : 'leftBugs';
        $release->{$field} = trim(str_replace(",$bugID,", ',', ",{$release->$field},"), ',');
        $this->dao->update(TABLE_RELEASE)->set($field)->eq($release->$field)->where('id')->eq((int)$releaseID)->exec();
        $this->loadModel('action')->create('bug', $bugID, 'unlinkedfromrelease', '', $releaseID);
    }

    /**
     * Batch unlink bug.
     * 
     * @param  int    $releaseID 
     * @access public
     * @return void
     */
    public function batchUnlinkBug($releaseID, $type = 'bug')
    {

        $bugList = $this->post->unlinkBugs;
        if(empty($bugList)) return true;

        $release = $this->getByID($releaseID);
        $field   = $type == 'bug' ? 'bugs' : 'leftBugs';
        $release->$field = ",{$release->$field},";
        foreach($bugList as $bugID) $release->$field = str_replace(",$bugID,", ',', $release->$field);
        $release->$field = trim($release->$field, ',');
        $this->dao->update(TABLE_RELEASE)->set($field)->eq($release->$field)->where('id')->eq((int)$releaseID)->exec();
        foreach($this->post->unlinkBugs as $unlinkBugID)
        {
            $this->loadModel('action')->create('bug', $unlinkBugID, 'unlinkedfromrelease', '', $releaseID);
        }
    }

    /**
     * Change status.
     * 
     * @param  int    $releaseID 
     * @param  string $status 
     * @access public
     * @return bool
     */
    public function changeStatus($releaseID, $status)
    {
        $this->dao->update(TABLE_RELEASE)->set('status')->eq($status)->where('id')->eq($releaseID)->exec();
        return dao::isError();
    }
}
