<?php
namespace tinder\controllers;

use tinder\controllers\Controller;

include(wp_normalize_path(ABSPATH.'\wp-content\plugins\matching-b2b\run.php'));
class panelController implements Controller
{
    public function add()
    {
    }

    public function update()
    {
    }

    public static function delete($id)
    {
        global $wpdb;
        $table  = 'wp_'.TABLENAME;
        $delete = $wpdb->delete($table, array('id'=>$id));
    }

    public function save()
    {
    }

    public static function getAllForms()
    {
        global $wpdb;
        $table  = $wpdb->prefix .'frm_forms';
        $data = $wpdb->get_results('SELECT * from '.$table, ARRAY_A);
        return $data;
    }
    public static function generateMatchList()
    {
        panelController::clear();
        panelController::storeInDb();
    }
    public static function exportToCSV()
    {
        // $date = strval(get_the_date());
        $date = current_time('Y-m-d');
        $filename = ABSPATH.$date.'_file.csv';
        $fp = fopen($filename, 'w');
        $matches = panelController::getAll();
        foreach ($matches as $match) {
            fputcsv($fp, $match, ";");
        }
        fclose($fp);
    }

    public static function getAll()
    {
        global $wpdb;
        $table  = 'wp_' .TABLENAME;
        $data = $wpdb->get_results('SELECT * from '.$table, ARRAY_A);
        return $data;
    }

    public static function clear()
    {
        global $wpdb;
        $table  = 'wp_'.TABLENAME;
        $delete = $wpdb->query("TRUNCATE TABLE $table");
    }

    public static function storeInDb()
    {
        global $wpdb;
        $table  = 'wp_'.TABLENAME;
        $pairs = generatePairs();
        $query = 'INSERT INTO '.$table.'(participantA, participantB, timeInterval, factorY, factorZ) VALUES';
        foreach ($pairs as $pair) {
            $query.='("'.$pair->getParticipantA()->getName().'","'
                        .$pair->getParticipantB()->getName().'","'
                        .$pair->getCriterium('timeInterval').'","'
                        .$pair->getCriterium('Y').'","'
                        .$pair->getCriterium('Z').'"),';
        }
        $query = substr($query, 0, -1);
        $wpdb->query($query);
    }
}
