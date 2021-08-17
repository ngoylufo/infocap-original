<?php
require('../../application/config.php');
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $read = New Small\Database\Read;
    $read->Select('people', '*', "WHERE id=:id", "id=$id");

    if ($read->success()) {
        $delete = new Small\Database\Delete();
        $delete->Delete('people', "WHERE id=:id", "id=$id");

        if ($delete->success()) {
            alert(
                "Information Deleted!",
                "Successfully deleted information from the database.",
                "success"
            );
        }
    }  else {
        alert(
            "Nothing Deleted!",
            "Unable to delete information. Person info may not exist in the database.",
            "danger"
        );
    }
} else {
    alert("Oops!", "Seems we're are having server troubles! Please try again later.", "danger");
}
