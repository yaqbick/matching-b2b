<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<form method="POST">
<div class="form-group">
<button type="submit" class="btn btn-success" name="matching_generate">generuj nową listę</button>
<button type="submit" class="btn btn-success" name="matching_export">eksportuj do csv</button>
<button type="submit" class="btn btn-success">zapisz i wyślij</button>
</div>
</form>
<?php
// include(ABSPATH.'\wp-content\plugins\matching-b2b\run.php');
use tinder\controllers\panelController;
use tinder\services\RequestService;

RequestService::check();
$pairs = panelController::getAll();
// echo 'ILOŚĆ PAR: '.count($pairs);
$forms =  panelController::getAllForms();
$formSelector = '<form action="POST"><div class="form-group"><select>';
foreach ($forms as $form) {
    $formSelector.= '<option value="'.$form['id'].'" >'.$form['name'].'</option>';
}
$formSelector.= '</select><button type="submit" class="btn btn-success" name="matching_form">wybierz</button></div></form>';
$table = '<table><thead><tr><th>UCZESTNIK A</th><th>UCZESTNIK B</th><th>PRZEDZIAŁ CZASOWY</th><th>CZYNNIK Y</th><th>CZYNNIK Z</th></tr></thead><tbody>';
foreach ($pairs as $pair) {

//     $table.= '<tr><td><input value="'.$pair->getParticipantA()->getName().'"></td>
//      <td><input value="'.$pair->getParticipantB()->getName().'"></td>';
    // $table.= paramsToString('timeInterval', $pair->getParticipantA()).'<br>';
    // $table.= paramsToString('myY', $pair->getParticipantA()).'<br>';
    // $table.= paramsToString('myChoiceY', $pair->getParticipantA()).'<br>';
    // $table.= paramsToString('myZ', $pair->getParticipantA()).'<br>';
    // $table.= paramsToString('myChoiceZ', $pair->getParticipantA()).'<br>';
    // $table.= '</td><td>'.paramsToString('timeInterval', $pair->getParticipantB()).'<br>';
    // $table.= paramsToString('myY', $pair->getParticipantB()).'<br>';
    // $table.= paramsToString('myChoiceY', $pair->getParticipantB()).'<br>';
    // $table.= paramsToString('myZ', $pair->getParticipantB()).'<br>';
    // $table.= paramsToString('myChoiceZ', $pair->getParticipantB()).'<br>';
    // $table.= '<td>'.$pair->getCriterium('timeInterval').'</td>
    // <td>'.$pair->getCriterium('Y').'</td>
    // <td>'.$pair->getCriterium('Z').'</td>
    $table.= '<tr>
    <td><input value="'.$pair['participantA'].'"></td>
    <td><input value="'.$pair['participantB'].'"></td>
    <td>'.$pair['timeInterval'].'</td>
    <td>'.$pair['factorY'].'</td>
    <td>'.$pair['factorZ'].'</td>
    <td><form method="POST"><button type = "submit" class="btn btn-danger" value ="'.$pair['id'].'"name="matching_delete">USUŃ</button></form></td></tr>';
}
$table.= '</tbody></table>';
echo $formSelector;
echo $table;
