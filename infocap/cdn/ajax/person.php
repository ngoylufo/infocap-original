<?php
require('../../application/config.php');
$form = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(!empty($form['id']))
{
    $read = New Small\Database\Read;
    $read->Select('people', '*', "WHERE id=:id LIMIT 1", "id={$form['id']}");
    if ($read->success()):
        extract($read->getResultSet()[0]);
?>
    <div class="card border-0">
      <div class="card-body">
        <h5 class="card-title"><?= "$firstName $lastName" ?></h5>
        <p class="card-text"><?= $summary ?></p>
      </div>

      <ul class="list-group list-group-flush">
        <li class="list-group-item">Birth Date: <?= date('d/m/Y', strtotime($birthDate)) ?></li>
        <li class="list-group-item">Gender: <?= get_gender($gender) ?></li>
        <li class="list-group-item">Email: <?= $email ?></li>
        <li class="list-group-item">Phone: <?= format_number($cellphone) ?></li>
      </ul>

      <div class="card-body">
        <p>Record created on the: <b><?= date('d/m/Y', strtotime($recDate)) ?></b></p>
        <a delete-id="<?=$id?>" href="javascript:void(0)" class="ajax-delete btn btn-danger">Delete Information</a>
      </div>
    </div>
<?php
    else:
      echo "Bad request";
    endif;
}
