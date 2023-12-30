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

    </body>