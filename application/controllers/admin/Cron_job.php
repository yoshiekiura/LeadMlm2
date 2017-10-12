<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Cron_Job extends Base_Controller {

    function db_backup() {//Daily Cron For Database Backup
        $backup_type=$this->dbvars->backup_type;
        $backup_deletion_period=$this->dbvars->backup_deletion_period;
        $insert_id = $this->cron_job_model->insertCronJobHistory('db_backup');
        $res = $this->cron_job_model->generateBackup($insert_id,$backup_type,$backup_deletion_period);
        if ($res) {            
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Success');
            echo 'Success';
        } else {
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Failed');
            echo 'Failed';
        }
    }
    
    function dbvars() {
        $this->dbvars->backup_type = '';
        $this->dbvars->backup_deletion_period = '30';
        $this->dbvars->mlm_plan = 'binary';
    }
    

}
