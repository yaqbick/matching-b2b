<?php
namespace tinder\services;

use tinder\controllers\panelController;

class RequestService
{
    public static function check()
    {
        if (isset($_POST['matching_delete'])) {
            panelController::delete($_POST['matching_delete']);
        }
        if (isset($_POST['matching_generate'])) {
            panelController::generateMatchList();
        }
        if (isset($_POST['matching_export'])) {
            panelController::exportToCSV();
        }
    }
}
