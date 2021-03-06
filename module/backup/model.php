<?php
/**
 * The model file of backup module of ZenTaoCMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     backup
 * @version     $Id$
*/
class backupModel extends model
{
    /**
     * Backup SQL 
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function backSQL($backupFile)
    {
        $zdb = $this->app->loadClass('zdb');
        return $zdb->dump($backupFile);
    }

    /**
     * Backup file.
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function backFile($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $nozip = strpos($this->config->backup->setting, 'nozip') !== false;
        if(!$nozip)
        {
            $oldDir = getcwd();
            chdir($this->app->getTmpRoot());
            $this->app->loadClass('pclzip', true);
            $zip = new pclzip($backupFile);
            $zip->create($this->app->getAppRoot() . 'www/data/', PCLZIP_OPT_REMOVE_PATH, $this->app->getAppRoot() . 'www/data/', PCLZIP_OPT_TEMP_FILE_ON);
            if($zip->errorCode() != 0)
            {
                $return->result = false;
                $return->error  = $zip->errorInfo();
            }
            chdir($oldDir);
        }
        else
        {
            if(!is_dir($backupFile)) mkdir($backupFile, 0777, true);
            $zfile = $this->app->loadClass('zfile');
            $zfile->copyDir($this->app->getAppRoot() . 'www/data/', $backupFile);
        }

        return $return;
    }

    /**
     * Backup code.
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function backCode($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $appRoot     = $this->app->getAppRoot();
        $fileList    = glob($appRoot . '*');
        $wwwFileList = glob($appRoot . 'www/*');

        $tmpFile  = array_search($appRoot . 'tmp', $fileList);
        $wwwFile  = array_search($appRoot . 'www', $fileList);
        $dataFile = array_search($appRoot . 'www/data', $wwwFileList);
        unset($fileList[$tmpFile]);
        unset($fileList[$wwwFile]);
        unset($wwwFileList[$dataFile]);

        $fileList = array_merge($fileList, $wwwFileList);

        $nozip = strpos($this->config->backup->setting, 'nozip') !== false;
        if(!$nozip)
        {
            $oldDir = getcwd();
            chdir($this->app->getTmpRoot());
            $this->app->loadClass('pclzip', true);
            $zip = new pclzip($backupFile);
            $zip->create($fileList, PCLZIP_OPT_REMOVE_PATH, $appRoot, PCLZIP_OPT_TEMP_FILE_ON);
            if($zip->errorCode() != 0)
            {
                $return->result = false;
                $return->error  = $zip->errorInfo();
            }
            chdir($oldDir);
        }
        else
        {
            if(!is_dir($backupFile)) mkdir($backupFile, 0777, true);
            $zfile = $this->app->loadClass('zfile');
            foreach($fileList as $codeFile)
            {
                $file = trim(str_replace($appRoot, '', $codeFile), DS);
                if(is_dir($codeFile))
                {
                    if(!is_dir($backupFile . DS . $flle)) mkdir($backupFile . DS . $flle, 0777, true);
                    $zfile->copyDir($codeFile, $backupFile . DS . $file);
                }
                else
                {
                    $dirName = dirname($file);
                    if(!is_dir($backupFile . DS . $dirName)) mkdir($backupFile . DS . $dirName, 0777, true);
                    $zfile->copyFile($codeFile, $backupFile . DS . $file);
                }
            }
        }

        return $return;
    }

    /**
     * Restore SQL 
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function restoreSQL($backupFile)
    {
        $zdb = $this->app->loadClass('zdb');
        return $zdb->import($backupFile);
    }

    /**
     * Restore File 
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function restoreFile($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $nozip = strpos($this->config->backup->setting, 'nozip') !== false;
        if(!$nozip)
        {
            $oldDir = getcwd();
            chdir($this->app->getTmpRoot());
            $this->app->loadClass('pclzip', true);
            $zip = new pclzip($backupFile);
            if($zip->extract(PCLZIP_OPT_PATH, $this->app->getAppRoot() . 'www/data/', PCLZIP_OPT_TEMP_FILE_ON) == 0)
            {
                $return->result = false;
                $return->error  = $zip->errorInfo();
            }
            chdir($oldDir);
        }
        else
        {
            $zfile = $this->app->loadClass('zfile');
            $zfile->copyDir($backupFile, $this->app->getAppRoot() . 'www/data/');
        }

        return $return;
    }

    /**
     * Add file header.
     * 
     * @param  string    $fileName 
     * @access public
     * @return bool
     */
    public function addFileHeader($fileName)
    {
        $firstline = false;
        $die       = "<?php die();?" . ">\n";
        $fileSize  = filesize($fileName);

        $fh    = fopen($fileName, 'c+');
        $delta = strlen($die);
        while(true)
        {
            $offset = ftell($fh);
            $line   = fread($fh, 1024 * 1024);
            if(!$firstline)
            {
                $line = $die . $line;
                $firstline = true;
            }
            else
            {
                $line = $compensate . $line;
            }
            
            $compensate = fread($fh, $delta);
            fseek($fh, $offset);
            fwrite($fh, $line);

            if(ftell($fh) >= $fileSize)
            {
                fwrite($fh, $compensate);
                break;
            }
        }
        fclose($fh);
        return true;
    }

    /**
     * Remove file header.
     * 
     * @param  string    $fileName 
     * @access public
     * @return bool
     */
    public function removeFileHeader($fileName)
    {
        $firstline = false;
        $die       = "<?php die();?" . ">\n";
        $fileSize  = filesize($fileName);

        $fh = fopen($fileName, 'c+');
        while(true)
        {
            $offset = ftell($fh);
            if($firstline and $delta) fseek($fh, $offset + $delta);
            $line = fread($fh, 1024 * 1024);
            if(!$firstline)
            {
                $firstline    = true;
                $beforeLength = strlen($line);
                $line         = str_replace($die, '', $line);
                $afterLength  = strlen($line);
                $delta        = $beforeLength - $afterLength;
                if($delta == 0)
                {
                    fclose($fh);
                    return true;
                }
            }
            fseek($fh, $offset);
            fwrite($fh, $line);

            if(ftell($fh) >= $fileSize - $delta) break;
        }
        ftruncate($fh, ($fileSize - $delta));
        fclose($fh);
        return true;
    }

    /**
     * Get dir size.
     * 
     * @param  string    $backupFile 
     * @access public
     * @return int
     */
    public function getBackupSize($backupFile)
    {
        $zfile = $this->app->loadClass('zfile');
        if(!is_dir($backupFile)) return $zfile->getFileSize($backupFile);
        return $zfile->getDirSize($backupFile);
    }

    /**
     * Get backup path.
     * 
     * @access public
     * @return string
     */
    public function getBackupPath()
    {
        $backupPath = empty($this->config->backup->settingDir) ? $this->app->getTmpRoot() . 'backup' . DS : $this->config->backup->settingDir;
        return rtrim(str_replace('\\', '/', $backupPath), '/') . '/';
    }

    /**
     * Get backup file.
     * 
     * @param  string    $name 
     * @param  string    $type 
     * @access public
     * @return string
     */
    public function getBackupFile($name, $type)
    {
        $backupPath = $this->getBackupPath();
        if($type == 'sql')
        {
            if(file_exists($backupPath . $name . ".{$type}")) return $backupPath . $name . ".{$type}";
            if(file_exists($backupPath . $name . ".{$type}.php")) return $backupPath . $name . ".{$type}.php";
        }
        else
        {
            if(file_exists($backupPath . $name . ".{$type}")) return $backupPath . $name . ".{$type}";
            if(file_exists($backupPath . $name . ".{$type}.zip")) return $backupPath . $name . ".{$type}.zip";
            if(file_exists($backupPath . $name . ".{$type}.zip.php")) return $backupPath . $name . ".{$type}.zip.php";
        }

        return false;
    }

    /**
     * Process filesize.
     * 
     * @param  int    $fileSize 
     * @access public
     * @return string
     */
    public function processFileSize($fileSize)
    {
        $bit = 'KB';
        $fileSize = round($fileSize / 1024, 2);
        if($fileSize >= 1024)
        {
            $bit = 'MB';
            $fileSize = round($fileSize / 1024, 2);
        }
        if($fileSize >= 1024)
        {
            $bit = 'GB';
            $fileSize = round($fileSize / 1024, 2);
        }

        return $fileSize . $bit;
    }
}
