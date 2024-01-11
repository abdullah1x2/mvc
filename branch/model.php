<?php
$db = new mysqli("localhost", "root", "", "test");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

function getAllUsers() {
    global $db;
    $result = $db->query("SELECT * FROM users ORDER BY id DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getUserById($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function addUser($username, $password) {
    global $db;
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->close();
}

function updateUser($id, $username, $password) {
    global $db;
    $stmt = $db->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $password, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteUser($id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
