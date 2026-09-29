<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "db.php";

$sql = "SELECT id, fullname, username, birthdate, created_at
        FROM users
        ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>User Management | XY Future</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body class="home-page">

<div class="grid"></div>

<nav class="navbar">

    <div class="nav-logo">
        ✦ XY FUTURE
    </div>

    <div class="nav-links">

        <a href="home.php">
            HOME
        </a>

        <a href="users.php" class="active">
            USERS
        </a>

    </div>

    <a
        href="logout.php"
        class="logout-btn"
    >
        LOGOUT
    </a>

</nav>


<main class="crud-container">

    <div class="crud-header">

        <div>

            <p class="small-title">
                DATABASE MANAGEMENT
            </p>

            <h1>
                USER <span>MANAGEMENT</span>
            </h1>

            <p class="crud-description">
                Manage registered users in the system.
            </p>

        </div>

        <a
            href="add_user.php"
            class="crud-add-btn"
        >
            + ADD USER
        </a>

    </div>


    <div class="crud-card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>FULL NAME</th>

                        <th>USERNAME</th>

                        <th>BIRTHDATE</th>

                        <th>CREATED</th>

                        <th>ACTION</th>

                    </tr>

                </thead>

                <tbody>

                <?php if ($result->num_rows > 0): ?>

                    <?php while ($row = $result->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?= $row["id"] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row["fullname"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row["username"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row["birthdate"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row["created_at"]) ?>
                            </td>

                            <td class="action-buttons">

                                <a
                                    href="edit_user.php?id=<?= $row["id"] ?>"
                                    class="edit-btn"
                                >
                                    EDIT
                                </a>

                                <a
                                    href="delete_user.php?id=<?= $row["id"] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this user?');"
                                >
                                    DELETE
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td
                            colspan="6"
                            class="empty-table"
                        >
                            NO USERS FOUND
                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</main>


<footer>

    <p>
        © 2026 XY FUTURE SYSTEM.
        ALL RIGHTS RESERVED.
    </p>

</footer>

</body>

</html>