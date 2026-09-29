<?php

session_start();

require_once "db.php";

$message = "";
$messageType = "";

if (isset($_SESSION["registration_success"])) {

    $message = $_SESSION["registration_success"];

    $messageType = "success";

    unset($_SESSION["registration_success"]);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");

    $password = $_POST["password"] ?? "";


    if ($username === "" || $password === "") {

        $message = "PLEASE ENTER USERNAME AND PASSWORD";

        $messageType = "error";

    } else {

        $sql = "
            SELECT
                id,
                fullname,
                username,
                password
            FROM users
            WHERE username = ?
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);


        if (!$stmt) {

            die(
                "DATABASE QUERY ERROR: "
                . $conn->error
            );

        }


        $stmt->bind_param(
            "s",
            $username
        );

        $stmt->execute();

        $result = $stmt->get_result();


        if ($result->num_rows === 0) {

            $message =
                "USERNAME NOT FOUND IN DATABASE";

            $messageType = "error";

        } else {

            $user = $result->fetch_assoc();


            if (
                password_verify(
                    $password,
                    $user["password"]
                )
            ) {

                session_regenerate_id(true);


                $_SESSION["user_id"] =
                    $user["id"];

                $_SESSION["fullname"] =
                    $user["fullname"];

                $_SESSION["username"] =
                    $user["username"];


                header("Location: home.php");

                exit();


            } else {

                $message =
                    "PASSWORD IS INCORRECT";

                $messageType = "error";

            }

        }

        $stmt->close();

    }

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

    <title>Login | Future System</title>

    <link
        <link rel="stylesheet" href="style.css?v=999">
    >

</head>


<body>

<div class="grid"></div>


<div class="login-container">

    <div class="login-card">

        <div class="logo">
<br>
<div class="xy-logo">
        XY
    </div>


            ✦ FUTURE
        </div>


        <h1>
            WELCOME BACK
        </h1>


        <p class="subtitle">
            Access the future
        </p>


        <?php if ($message !== ""): ?>

            <div
                class="status-message <?= $messageType ?>"
            >

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="index.php"
        >

            <div class="input-group">

                <input
                    type="text"
                    name="username"
                    required
                >

                <label>
                    USERNAME
                </label>

            </div>


            <div class="input-group">

                <input
                    type="password"
                    name="password"
                    required
                >

                <label>
                    PASSWORD
                </label>

            </div>


            <button
                type="submit"
                class="login-btn"
            >
                LOGIN
            </button>

        </form>


        <p class="register-text">
            
            <br>

            Don't have an account?

            <a href="register.php">
                CREATE ACCOUNT
            </a>

        </p>

    </div>

</div>

</body>

</html>