<?php
require_once 'model.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

if ($action == 'list') {
    $users = getAllUsers();
    include 'view.php';
} elseif ($action == 'add') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        addUser($username, $password);
    }
    header('Location: controller.php?action=list');
} elseif ($action == 'edit') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $user = getUserById($id);

        // Display the edit form using heredoc syntax
        echo <<<HTML
            <link rel="stylesheet" href="style.css">
            <fieldset style="width:400px;margin:auto;">
                <h2>Edit User</h2>
                <form action="controller.php?action=update" method="post">
                    <input type="hidden" name="id" value="{$user['id']}">
                    <label for="username">Username : </label>
                    <input type="text" name="username" value="{$user['username']}" required>
                    <br>
                    <br>
                    <label for="password">Password : </label>
                    <input type="password" name="password" value="{$user['password']}" required>
                    <br>
                    <br>
                    <button type="submit">Update User</button>
                </form>
            </fieldset>
        HTML;
    } else {
        echo 'Invalid user ID';
    }
} elseif ($action == 'update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        updateUser($id, $username, $password);
    }
    header('Location: controller.php?action=list');
} elseif ($action == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteUser($id);
    }
    header('Location: controller.php?action=list');
} else {
    echo 'Invalid action';
}
