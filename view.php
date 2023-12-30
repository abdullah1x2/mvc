<?php require_once 'model.php'; ?>
<title>User List</title>
<link rel="stylesheet" href="style.css">

<body>
    <!-- Form to add a new user -->
    <h2>Add User</h2>
    <form action="controller.php" method="post">
        <input type="hidden" name="action" value="add">
        <label for="username">Username : </label>
        <input type="text" name="username" required> <br><br>
        <label for="password">Password : </label>
        <input type="password" name="password" required> <br><br>
        <button type="submit">Add User</button>
    </form>

    <h2>User List</h2>

    <?php
    // Handle form submissions for both adding and updating users
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if the 'action' parameter is set in the POST data
        if (isset($_POST['action'])) {
            $action = $_POST['action'];

            // Check the value of 'action' to determine the specific action to perform
            if ($action == 'add') {
                // If the action is 'add', retrieve the username and password from the POST data
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Call the addUser function to add a new user
                addUser($username, $password);
            } elseif ($action == 'update') {
                // If the action is 'update', retrieve the user ID, username, and password from the POST data
                $id = $_POST['id'];
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Call the updateUser function to update an existing user
                updateUser($id, $username, $password);
            }
        }

        // Redirect to the 'list' action after handling the form submission
        header('Location: controller.php?action=list');
        exit;
    }


    // Display the list of users
    $users = getAllUsers();
    if (isset($users) && is_array($users) && count($users) > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th colspan="2">Action</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td>
                        <?php echo $user['id']; ?>
                    </td>
                    <td>
                        <?php echo $user['username']; ?>
                    </td>
                    <td>
                        <?php echo $user['password']; ?>
                    </td>
                    <td>
                        <a href="controller.php?action=edit&id=<?php echo $user['id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a href="controller.php?action=delete&id=<?php echo $user['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No users found.</p>
    <?php endif; ?>

    <!-- Form to edit an existing user -->
    <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) : ?>
        <?php $id = $_GET['id']; ?>
        <?php $user = getUserById($id); ?>
        <?php if ($user) : ?>
            <h2>Edit User</h2>
            <form action="controller.php" method="post">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                <label for="password">Password:</label>
                <input type="password" name="password" value="<?php echo $user['password']; ?>" required>
                <button type="submit">Update User</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

</body>

</html>