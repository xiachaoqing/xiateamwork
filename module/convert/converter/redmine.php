<?php
/**
 * The baisc model file of bugfree convert of ZenTaoPMS.
 *

 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     convert
 * @version     $Id $
*/
class redmineConvertModel extends convertModel
{
    public $map         = array();
    public $filePath    = '';
    static public $info = array();

    /**
     * Connect to db auto.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        parent::connectDB();
    }

    /**
     * Check table.
     * 
     * @access public
     * @return bool
     */
    public function checkTables()
    {
        return true;
    }

    /**
     * Check the install path.
     * 
     * @access public
     * @return bool
     */
    public function checkPath()
    {
        $this->setPath();
        return file_exists($this->filePath);
    }

    /**
     * Set the path of attachments.
     * 
     * @access public
     * @return bool
     */
    public function setPath()
    {
        $this->filePath = realpath($this->post->installPath) . DS . 'files' . DS;
    }

    /**
     * Excute the convert.
     * 
     * @param  int    $version 
     * @access public
     * @return void
     */
    public function execute($version)
    {
    }

    /**
     * Clear rows added in converting.
     * 
     * @access public
     * @return void
     */
    public function clear()
    {
        foreach($this->session->state as $table => $maxID)
        {
            $this->dao->dbh($this->dbh)->delete()->from($table)->where('id')->gt($maxID)->exec();
        }
    }
}
