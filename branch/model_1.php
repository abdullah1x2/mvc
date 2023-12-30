<?php

$con = new mysqli('localhost', 'root', '', 'testo');

function getAllUser()
{
    global $con;
    $data = $con->query('SELECT * FROM users');
    $uzers = $data->fetch_all(MYSQLI_ASSOC);
    return $uzers;
}

function getUserById($id)
{
    global $con;
    $stmt = $con->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function addUser($username,$password){
    global $con;
    $stmt=$con->prepare('INSERT INTO users (username,password) VALUES (?,?)');
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();
    $stmt->close();
}
