<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h2>Form</h2>
        <form id="userForm" onsubmit="saveOrUpdateUser(); return false;">
            <input type="hidden" id="editUserId" name="id">
            <label for="editUsername">Username: </label>
            <input type="text" id="editUsername" name="username" required><br><br>
            <label for="editPassword">Password: </label>
            <input type="password" id="editPassword" name="password" required><br><br>
            <button type="submit" id="save">Save</button>
            <button type="button" id="update" onclick="updateUser()" disabled>Update</button>
            <button type="button" onclick="resetForm()">Reset</button>
        </form>
    </div>

    <h2>User List</h2>

    <div id="userList">
        <!-- User list will be displayed here using AJAX -->
    </div>

    <script>
        // Load user list when the page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadUserList();
        });

        function loadUserList() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        document.getElementById('userList').innerHTML = xhr.responseText;
                        // Add event listeners for edit and delete buttons after updating the user list
                        addEventListeners();
                    } else {
                        console.error('Error loading user list:', xhr.responseText);
                    }
                }
            };
            xhr.open('GET', 'controller.php?action=list', true);
            xhr.send();
        }

        function addUser(username, password) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        loadUserList();
                        //clearForm();
                        document.getElementById('save').disabled = true;
                        document.getElementById('update').disabled = false;
                    } else {
                        console.error('Error adding user:', xhr.responseText);
                    }
                }
            };
            xhr.open('POST', 'controller.php?action=add', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('username=' + username + '&password=' + password);
        }

        function showEditForm(userId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        try {
                            var userData = JSON.parse(xhr.responseText);
                            populateEditForm(userData);
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                        }
                    } else {
                        console.error('Error retrieving user data:', xhr.responseText);
                    }
                }
            };
            xhr.open('GET', 'controller.php?action=edit&id=' + userId, true);
            xhr.send();
        }

        function populateEditForm(userData) {
            document.getElementById('editUserId').value = userData.id;
            document.getElementById('editUsername').value = userData.username;
            document.getElementById('editPassword').value = userData.password;
            document.getElementById('save').disabled = true;
            document.getElementById('update').disabled = false;
        }

        function clearForm() {
            document.getElementById('editUserId').value = '';
            document.getElementById('editUsername').value = '';
            document.getElementById('editPassword').value = '';
            document.getElementById('save').disabled = false;
            document.getElementById('update').disabled = true;
        }

        function resetForm() {
            clearForm();
        }

        function saveOrUpdateUser() {
            var userId = document.getElementById('editUserId').value;
            var username = document.getElementById('editUsername').value;
            var password = document.getElementById('editPassword').value;

            if (userId) {
                // Update existing user
                updateUser(userId, username, password);
            } else {
                // Add new user
                addUser(username, password);
            }
        }

        function updateUser() {
            var userId = document.getElementById('editUserId').value;
            var username = document.getElementById('editUsername').value;
            var password = document.getElementById('editPassword').value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        loadUserList();
                        //clearForm();
                    } else {
                        console.error('Error updating user:', xhr.responseText);
                    }
                }
            };
            xhr.open('POST', 'controller.php?action=update', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + userId + '&username=' + username + '&password=' + password);
        }

        function addEventListeners() {
            // Get all elements with the class 'edit-user' and add click event listener
            var editButtons = document.getElementsByClassName('edit-user');
            Array.from(editButtons).forEach(function(button) {
                button.addEventListener('click', function() {
                    showEditForm(button.getAttribute('data-user-id'));
                });
            });
        }

        function deleteUser(userId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        loadUserList();
                        clearForm();
                    } else {
                        console.error('Error deleting user:', xhr.responseText);
                    }
                }
            };
            xhr.open('GET', 'controller.php?action=delete&id=' + userId, true);
            xhr.send();
        }
    </script>
</body>

</html>