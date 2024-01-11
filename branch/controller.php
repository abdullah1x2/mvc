<?php
require_once 'model.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'list') {
    displayUserList();
} elseif ($action == 'add') {
    addUserAction();
} elseif ($action == 'edit') {
    editUserAction();
} elseif ($action == 'update') {
    updateUserAction();
} elseif ($action == 'delete') {
    deleteUserAction();
} else {
    echo 'Invalid action';
}

function displayUserList()
{
    $users = getAllUsers();

    if (isset($users) && is_array($users) && count($users) > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Username</th><th>Password</th><th colspan="2">Action</th></tr>';

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['password']}</td>";
            echo "<td><a href='javascript:void(0);' class='edit-user' data-user-id='{$user['id']}'>Edit</a></td>";
            echo "<td><a href='javascript:void(0);' onclick='deleteUser({$user['id']})'>Delete</a></td>";
            echo "</tr>";
        }

        echo '</table>';
    } else {
        echo '<p>No users found.</p>';
    }
}

function addUserAction()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        addUser($username, $password);
        displayUserList();
    }
}

function editUserAction()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $user = getUserById($id);

            if ($user) {
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode($user);
                    exit;
                } else {
                    echo json_encode($user);
                    exit;
                }
            } else {
                echo json_encode(['error' => 'Invalid user ID']);
            }
        } else {
            echo json_encode(['error' => 'Invalid user ID']);
        }
    }
}

function updateUserAction()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        updateUser($id, $username, $password);
        displayUserList();
    }
}

function deleteUserAction()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteUser($id);
        displayUserList();
    }
}
?>
