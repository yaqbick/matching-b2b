<?php
require_once 'vendor/autoload.php';
use tinder\Participant;
use tinder\TimeInterval;
use tinder\Trade;
use tinder\Match;
use tinder\Criteria;

function generatePairs()
{
    $participants = generateData();
    $intervals = countTimeIntervals($participants);
    $result = matching($participants);
    $percent = (floor(count($result))/floor($intervals/2))*100;
    echo "pary : ".count($result)." intervały : ".($intervals/2)." skuteczność : ".$percent. '%';
    return $result;
}

function generateData()
{
    $faker = Faker\Factory::create();
    $GLOBALS['matches'] = [];

    // $ti1 = new TimeInterval(1, '10:30');
    // $ti2 = new TimeInterval(2, '13:00');
    // $ti3 = new TimeInterval(3, '16:00');
    $timeIntervals = array('1'=>'10:30','2'=>'13:00' ,'3'=>'16:00');
    // $trade1 = new Trade(1, 'IT');
    // $trade2 = new Trade(2, 'Medycyna');
    // $trade3 = new Trade(3, 'Logistyka');
    // $trade4 = new Trade(4, 'Handel');
    // $trade5 = new Trade(5, 'Reklama');
    $trades = array('1'=>'IT','2'=>'Medycyna','3'=>'Logistyka' ,'4'=>'Handel','5'=>'Reklama');
    $participants = [];


    for ($j = 0; $j < 100; $j++) {
        $random1 = $faker->numberBetween(1, 3);
        // $random2 = $faker->numberBetween(1, 5);
        // $random3 = $faker->numberBetween(1, 5);
        $random4 = $faker->numberBetween(1, 5);
        $random5 = $faker->numberBetween(1, 5);
        // $random1 = 1;
        $random2 = 1;
        $random3 = 1;
        // $random4 = 1;
        // $random5 = 1;
        $timeInterval = [];
        $y =[];
        $z= [];
        $choiceY = [];
        $choiceZ = [];

        // $id = $faker->unique()->randomDigit;
        $id = uniqid();
        $name = $faker->unique()->name;
        $faker1 = Faker\Factory::create();
        for ($i=0;$i<$random1;$i++) {
            $key = $faker1->unique()->numberBetween(1, 3);
            $value = $timeIntervals[$key];
            $timeInterval[$key] = new TimeInterval(array_search($value, $timeIntervals), $value);
        }
        $faker2 = Faker\Factory::create();
        for ($k=0;$k<$random2;$k++) {
            $key = $faker2->unique()->numberBetween(1, 5);
            $y[$key] = $trades[$key];
        }
        $faker3 = Faker\Factory::create();
        for ($l=0;$l<$random3;$l++) {
            $key =  $faker3->unique()->numberBetween(1, 5);
            $z[$key] = $trades[$key];
        }
        $faker4 = Faker\Factory::create();
        for ($m=0;$m<$random4;$m++) {
            $key = $faker4->unique()->numberBetween(1, 5);
            $choiceY[$key] = $trades[$key];
        }
        $faker5 = Faker\Factory::create();
        for ($n=0;$n<$random5;$n++) {
            $key=  $faker5->unique()->numberBetween(1, 5);
            $choiceZ[$key] = $trades[$key];
        }
        $participant = new Participant($id, $name, $timeInterval, $y, $z, $choiceY, $choiceZ) ;
        $participants [] = $participant;
    }
    return $participants;
}

function countTimeIntervals($participants)
{
    $val = 0;
    foreach ($participants as $participant) {
        $val += count($participant->getTimeInterval());
    }
    return $val;
}
function matching(array $participants)
{
    $allMatches = [];

    usort($participants, "cmp");
    for ($a =0; $a<count($participants); $a++) {
        for ($b =0; $b<count($participants); $b++) {
            if ($participants[$a]!=$participants[$b]) {
                $match =  matchTimeInterval($participants[$a], $participants[$b]);
                if ($match) {
                    $allMatches [] =   $match;
                    break;
                }
            }
        }
    }
    return $allMatches;
}

function cmp($a, $b)
{
    return $a->getWeight() - $b->getWeight();
}


function matchTimeInterval(&$participantA, &$participantB)
{
    foreach ($participantA->getTimeInterval() as $intervalA) {
        $ATI = $participantA->getTimeIntervalByID($intervalA->getID());
        $BTI = $participantB->getTimeIntervalByID($intervalA->getID());
        if ($ATI && $BTI) {
            // var_dump($ATI->getAvailability().$BTI->getAvailability());
        }
        if (in_array($intervalA, $participantB->getTimeInterval()) && $ATI && $BTI &&  ($ATI->getAvailability()=='nic'  &&  $BTI->getAvailability()=='nic')) {
            $result =  matchY($participantA, $participantB, $intervalA); // uczestnicy mają wspólny wolny interwał
            if ($result) {
                $participantA->getTimeIntervalByID($intervalA->getID())->take($participantB->getName());
                $participantB->getTimeIntervalByID($intervalA->getID())->take($participantA->getName());
                $result->setCriterium('timeInterval', $intervalA->getValue());
                // var_dump('success!');
                return $result;
            }
        } else {
            // var_dump('fail!');
        }
    }
    return false;
}


function matchY($participantA, $participantB)
{
    $matches = [];
    foreach ($participantA->getMyChoiceY() as $AChoiceY) {
        if (in_array($AChoiceY, $participantB->getMyY())) {
            foreach ($participantB->getMyChoiceY() as $BChoiceY) {
                if (in_array($BChoiceY, $participantA->getMyY())) {
                    $result2 = matchZ($participantA, $participantB);
                    if ($result2) {
                        $criteria = array($AChoiceY,$BChoiceY);
                        $result2->setCriterium('Y', $criteria);
                        return $result2;
                    }
                }
                //wiemy, ze A chce sie spotkac z B i wzajemnie (Y)
            }
            return false;
        }
    }
}

function matchZ($participantA, $participantB)
{
    foreach ($participantA->getMyChoiceZ() as $AChoiceZ) {
        if (in_array($AChoiceZ, $participantB->getMyZ())) {
            foreach ($participantB->getMyChoiceZ() as $BChoiceZ) {
                if (in_array($BChoiceZ, $participantA->getMyZ())) {
                    $match = new Match($participantA, $participantB);
                    $criteria = array($AChoiceZ,$BChoiceZ);
                    $match->setCriterium('Z', $criteria);
                    $GLOBALS['matches'][] = $match;
                    return $match;
                }
                //wiemy, ze A chce sie spotkac z B i wzajemnie (Y)
            }
            return false;
        }
    }
}

function paramsToString($key, $participant)
{
    if (method_exists($participant, 'get'.$key)) {
        $params = call_user_func(array($participant,'get'.$key));
        $paramsToString = '<b>'.$key.' : </b>';
        foreach ($params as $param) {
            if (method_exists($param, 'getValue')) {
                $paramsToString .=  $param->getValue().' | ';
            } else {
                $paramsToString .=  $param;
            }
            if (method_exists($param, 'getAvailability')) {
                $paramsToString .=  ' | '.$param->getAvailability();
            }
        }
        return $paramsToString;
    }
}
//MATCH BLOKUJE WSZYSTKIE ATRYBUTY - MYY, MYCHOICEY,MYZ,MYCHOCEZ!
