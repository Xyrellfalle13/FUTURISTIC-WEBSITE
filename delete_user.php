<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "db.php";

$id = intval($_GET["id"] ?? 0);


/*
    Prevent the currently logged-in user
    from accidentally deleting themselves.
*/

if ($id <= 0 || $id == $_SESSION["user_id"]) {

    header("Location: users.php");

    exit();
}


$stmt = $conn->prepare(
    "DELETE FROM users WHERE id = ?"
);

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();

$stmt->close();


header("Location: users.php");

exit();

?>