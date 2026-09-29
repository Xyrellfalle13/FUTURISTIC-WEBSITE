<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "db.php";

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {
    header("Location: users.php");
    exit();
}

$message = "";
$messageType = "";


/* GET USER */

$stmt = $conn->prepare(
    "SELECT id, fullname, username, birthdate
     FROM users
     WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {

    header("Location: users.php");
    exit();

}

$user = $result->fetch_assoc();

$stmt->close();


/* UPDATE USER */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = trim($_POST["fullname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $birthdate = $_POST["birthdate"] ?? "";
    $password = $_POST["password"] ?? "";


    if (
        $fullname === "" ||
        $username === "" ||
        $birthdate === ""
    ) {

        $message = "PLEASE COMPLETE ALL REQUIRED FIELDS";
        $messageType = "error";

    } else {

        /* Check duplicate username */

        $check = $conn->prepare(
            "SELECT id
             FROM users
             WHERE username = ?
             AND id != ?"
        );

        $check->bind_param(
            "si",
            $username,
            $id
        );

        $check->execute();

        $duplicate = $check->get_result();


        if ($duplicate->num_rows > 0) {

            $message = "USERNAME ALREADY EXISTS";
            $messageType = "error";

        } else {

            if ($password !== "") {

                if (strlen($password) < 8) {

                    $message =
                        "PASSWORD MUST BE AT LEAST 8 CHARACTERS";

                    $messageType = "error";

                } else {

                    $hashedPassword =
                        password_hash(
                            $password,
                            PASSWORD_DEFAULT
                        );

                    $update = $conn->prepare(
                        "UPDATE users
                         SET fullname = ?,
                             username = ?,
                             birthdate = ?,
                             password = ?
                         WHERE id = ?"
                    );

                    $update->bind_param(
                        "ssssi",
                        $fullname,
                        $username,
                        $birthdate,
                        $hashedPassword,
                        $id
                    );

                    $update->execute();

                    $update->close();

                    header("Location: users.php");
                    exit();
                }

            } else {

                $update = $conn->prepare(
                    "UPDATE users
                     SET fullname = ?,
                         username = ?,
                         birthdate = ?
                     WHERE id = ?"
                );

                $update->bind_param(
                    "sssi",
                    $fullname,
                    $username,
                    $birthdate,
                    $id
                );

                $update->execute();

                $update->close();

                header("Location: users.php");
                exit();
            }
        }

        $check->close();
    }

    $user["fullname"] = $fullname;
    $user["username"] = $username;
    $user["birthdate"] = $birthdate;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit User | XY Future</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body>

<div class="grid"></div>

<div class="login-container">

    <div class="login-card">

        <div class="logo-container">

            <div class="xy-logo">
                XY
            </div>

            <div class="logo-text">
                FUTURE
            </div>

        </div>

        <h1>
            EDIT USER
        </h1>

        <p class="subtitle">
            Update account information
        </p>


        <?php if ($message !== ""): ?>

            <div class="status-message <?= $messageType ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <form method="POST">

            <div class="input-group">

                <input
                    type="text"
                    name="fullname"
                    value="<?= htmlspecialchars($user["fullname"]) ?>"
                    required
                >

                <label>
                    FULL NAME
                </label>

            </div>


            <div class="input-group">

                <input
                    type="text"
                    name="username"
                    value="<?= htmlspecialchars($user["username"]) ?>"
                    required
                >

                <label>
                    USERNAME
                </label>

            </div>


            <div class="input-group">

                <input
                    type="date"
                    name="birthdate"
                    value="<?= htmlspecialchars($user["birthdate"]) ?>"
                    required
                >

                <label>
                    DATE OF BIRTH
                </label>

            </div>


            <div class="input-group">

                <input
                    type="password"
                    name="password"
                >

                <label>
                    NEW PASSWORD
                </label>

            </div>


            <button
                type="submit"
                class="login-btn"
            >
                SAVE CHANGES
            </button>

        </form>


        <p class="register-text">

            <a href="users.php">
                ← BACK TO USERS
            </a>

        </p>

    </div>

</div>

</body>

</html>