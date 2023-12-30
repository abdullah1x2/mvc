<?php
require_once 'model.php';

// Determine the action from the request
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
// If 'action' parameter is set in the URL ($_GET), use its value; otherwise, default to 'list'.
// This is a common practice in web applications to handle different actions based on URL parameters.
// For example, if the URL is controller.php?action=add, $action will be 'add'.


// Perform actions based on the determined action
if ($action == 'list') {
    $users = getAllUsers();
    include 'view.php';
} elseif ($action == 'add') {
    handleAdd();
} elseif ($action == 'edit') {
    handleEdit();
} elseif ($action == 'update') {
    handleUpdate();
} elseif ($action == 'delete') {
    handleDelete();
} else {
    echo 'Invalid action';
}

// Function to handle adding a new user
function handleAdd()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        addUser($username, $password);
    }
    header('Location: controller.php?action=list');
    exit;
}

// Function to handle editing a user
function handleEdit()
{
    // Check if the 'id' parameter is set in the GET data
    if (isset($_GET['id'])) {
        // Retrieve the user ID from the GET data
        $id = $_GET['id'];

        // Get the user details based on the provided ID
        $user = getUserById($id);

        // Check if a user with the specified ID was found
        if ($user) {
            // Display the edit form using heredoc syntax
            echo <<<HTML
                <link rel="stylesheet" href="style.css">
                <fieldset style="width:400px;margin:auto;">
                    <h2>Edit User</h2>
                    <form action="controller.php?action=update" method="post">
                        <!-- Include a hidden input field to store the user ID -->
                        <input type="hidden" name="id" value="{$user['id']}">
                        
                        <label for="username">Username : </label>
                        <!-- Display the current username in the input field, set as 'required' -->
                        <input type="text" name="username" value="{$user['username']}" required><br><br>
                        
                        <label for="password">Password : </label>
                        <!-- Display the current password in the input field, set as 'required' -->
                        <input type="password" name="password" value="{$user['password']}" required><br><br>
                        
                        <button type="submit">Update User</button>
                    </form>
                </fieldset>
            HTML;
        } else {
            // If no user is found with the specified ID, display an error message
            echo 'Invalid user ID';
        }
    } else {
        // If the 'id' parameter is not set, display an error message
        echo 'Invalid user ID';
    }
}


// Function to handle updating user information
function handleUpdate()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        updateUser($id, $username, $password);
    }
    header('Location: controller.php?action=list');
    exit;
}

// Function to handle deleting a user
function handleDelete()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteUser($id);
    }
    header('Location: controller.php?action=list');
    exit;
}
