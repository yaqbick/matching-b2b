<?php
/**

 *@package matching-b2b

 *
/*
Plugin Name: Matching B2B
Description: Tinder for business
Author: yaqbick
*/

?>
<?php

defined('ABSPATH') or die('you cannot access this file');
define('TABLENAME', 'matching');
add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu()
{
    add_menu_page('My Plugin Page', 'Matching B2B', 'read', 'matching_b2b', 'display_panel');
}

function display_panel()
{
    require_once(ABSPATH.'wp-content/plugins/matching-b2b/panel.php');
}

register_activation_hook(__FILE__, 'jal_install');

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install()
{
    global $wpdb;
    global $jal_db_version;
    $table_name = $wpdb->prefix .TABLENAME;
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		participantA varchar(55) NOT NULL,
		participantB varchar(55) NOT NULL,
        timeInterval varchar(55) NOT NULL,
        factorY varchar(55) NOT NULL,
        factorZ varchar(55) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('jal_db_version', $jal_db_version);
}

add_filter('frm_bulk_field_choices', 'add_custom_frm_options');
function add_custom_frm_options($opts)
{
    $args = array(
        'post_type' => 'trade',
        'post_status' => 'publish'
    );

    $loop = new WP_Query($args);
    $trades = [];
    while ($loop->have_posts()) : $loop->the_post();
    $trades[] = get_the_title();
    endwhile;
    $opts['branże'] = $trades;
    return $opts;
}
