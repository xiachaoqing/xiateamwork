<?php
/**
 * The model file of misc module of ZenTaoPMS.

 * @author      XCQ
 * @package     misc
 * @version     $Id: model.php 4129 2013-01-18 01:58:14Z wwccss $
*/
?>
<?php
class miscModel extends model
{
    public function hello()
    {
        return 'hello world from hello()<br />';
    }

    /**
     * Get table and status.
     *
     * @param  string $type
     *
     * @access public
     * @return array|false
     */
    public function getTableAndStatus($type = 'check')
    {
        if($type != 'check' and $type != 'repair') return false;
        $tables = array();
        $stmt   = $this->dao->query("show full tables");
        while($table = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $tableName = $table["Tables_in_{$this->config->db->name}"];
            $tableType = strtolower($table['Table_type']);
            if($tableType == 'base table')
            {
                $tableStatus        = $this->dao->query("$type table $tableName")->fetch();
                $tables[$tableName] = strtolower($tableStatus->Msg_text);
            }
        }
        return $tables;
    }
}
