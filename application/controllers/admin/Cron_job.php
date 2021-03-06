<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Cron_Job extends Base_Controller {

    function db_backup() {//Daily Cron For Database Backup
        $backup_type = $this->dbvars->BACKUP_TYPE;
        $backup_deletion_period = $this->dbvars->BACKUP_DELETION_PERIOD;
        $insert_id = $this->cron_job_model->insertCronJobHistory('db_backup');
        $res = $this->cron_job_model->generateBackup($insert_id, $backup_type, $backup_deletion_period);
        if ($res) {
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Success');
            echo 'Success';
        } else {
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Failed');
            echo 'Failed';
        }
    }

    function update_currency_rate() {//Daily Cron For Update Currency Values 
        //sudo apt-get install php7.0-curl
        if ($this->dbvars->MULTI_CURRENCY_STATUS == 'active') {
            $default_currency = $this->dbvars->DEFAULT_CURRENCY_CODE;
            $insert_id = $this->cron_job_model->insertCronJobHistory('update_currency_rate');
            $res = $this->cron_job_model->updateCurrencyRates($default_currency);
            if ($res) {
                $this->cron_job_model->updateCronJobHistory($insert_id, 'Success');
                echo 'Success';
            } else {
                $this->cron_job_model->updateCronJobHistory($insert_id, 'Failed');
                echo 'Failed';
            }
        }
    }

}
