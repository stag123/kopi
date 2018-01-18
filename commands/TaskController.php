<?php
namespace app\commands;

use yii\console\ExitCode;

class TaskController extends BaseController
{

    public function actionIndex()
    {

        while(true) {
            $this->logger->info('Start task checker');

            $this->commandTaskCheck->execute();

            $this->logger->info('End task checker');
        }

        return ExitCode::OK;
    }
}
