<?php
require('../../application/config.php');
$form = filter_input_array(INPUT_POST, FILTER_DEFAULT);
sleep(1);
if(!empty($form['column'])):
    $read = New Small\Database\Read;

    $terms = "ORDER BY {$form['column']} {$form['order']} LIMIT 10 OFFSET :offset";
    echo "$terms, offset={$form['offset']}";
    $columns = ['id', 'firstName', 'lastName', 'gender', 'recDate'];
    $read->Select('people', $columns, $terms, "offset={$form['offset']}");
    if ($read->success()):
        foreach ($read->getResultSet() as $result):
?>
    <tr class="person" id="<?= $result['id'] ?>">
        <td><?= $result['id'] ?></td>
        <td><?= "{$result['lastName']}, {$result['firstName']}" ?></td>
        <td><?= get_gender($result['gender']) ?></td>
        <td><?= date('d/m/Y', strtotime($result['recDate'])) ?></td>
    </tr>
<?php
        endforeach;
    else:
?>
    <tr>
        <td>no ifnfo</td>
    </tr>
<?php
    endif;
else:
    echo "Bad Request";
endif;
