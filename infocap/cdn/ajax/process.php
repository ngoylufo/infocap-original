<?php
require('../../application/config.php');
$form = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$summary = $form['summary'];
unset($form['summary']);

if(!empty($form['email']) && !(in_array('', $form)))
{
    $read = new Small\Database\Read;
    $create = New Small\Database\Create;
    if (empty($summary))
        $summary = "This person has not provided any summary.";
    $form['summary'] = htmlspecialchars($summary);

    // I'll be forgoing actual form checking here, I don't think it is quite
    // necessary for this.

    $read->Select('people', '*', "WHERE email=:email LIMIT 1", "email={$form['email']}");
    if ($read->success())
        alert("Duplicate Emails!", "It appears that the email you entered is already taken.", "danger");
    else {
        $create->Insert('people', $form);
        if ($create->success())
            alert("Hooray!", "We've successfully started keeping tabs on you.", "success");
        else
            alert("Hmmm....", "Seems our database is having trouble storing your data.", "danger");
    }

} elseif (in_array('', $form)) {
    alert("Empty fields!", "Please make sure you've filled all fields on the form.", "warning");
} else {
    alert("Oops!", "Seems we're are having server troubles! Please try again later.", "danger");
}
// $recorder = new DataRecorder();

