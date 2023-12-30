<?php
require_once 'model_1.php';

$users = getAllUser();

if (isset($users) && is_array($users) && count($users) > 0) {
?>
    <link rel="stylesheet" href="style_1.css">

    <body>
        <table>
            <tr>
                <h1>User List</h1>
            </tr>
        </table>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th colspan="2">Action</th>
            </tr>
            <?php foreach ($users as $user) {
            ?>
                <tr>
                    <td>
                        <?php echo $user['id']; ?>
                    </td>
                    <td>
                        <?php echo ucfirst($user['username']); ?>
                    </td>
                    <td>
                        <?php echo $user['password']; ?>
                    </td>
                    <td>
                        <a href="">Edit</a>
                    </td>
                    <td>
                        <a href="">Delete</a>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
        </table>

        <h2>Add User</h2>
        <form action="controller.php" method="post">
            <input type="hidden" name="action" value="add">
            <label for="username">Username : </label>
            <input type="text" name="username" required> <br><br>
            <label for="password">Password : </label>
            <input type="password" name="password" required> <br><br>
            <button type="submit">Add User</button>
        </form>

        <?php
            if($_SERVER['REQUEST_METHOD']== 'POST'){
                if(isset($_POST['action'])){
                    $action=$_POST['action'];
                    if($action=='add'){
                        $username=$_POST['username'];
                        $password=$_POST['password'];
                        addUser($username,$password);
                    }
                }
            }
        ?>

    </body>