<?php
require_once 'vendor/autoload.php';
use tinder\Participant;
use tinder\TimeInterval;
use tinder\Trade;
use tinder\Match;
use tinder\Criteria;

include('src/views/panel.view.php');


function storeInDb()
{
}


function getTradesIDS()
{
    $ids = [];
    $args =array('post_type'=>'trade','post_status'=>'publish', 'posts_per_page'=>'-1');
    $trades= new WP_Query($args);
    while ($trades->have_posts()) {
        $trades->the_post();
        // echo '<input type="checkbox" id='.get_the_ID().'>'.get_the_title().'<br>';
        $ids[] = get_the_ID();
    }
    return $ids;
}
