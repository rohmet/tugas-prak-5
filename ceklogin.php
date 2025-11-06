<?php
session_start();

$users = [
    "Admin" => "pass@admiN1",
    "Anita" => "pass@anitA2",
    "Sapta" => "pass@saptA3",
    "rohmet"  => "comel"
];

$username = $_POST['username'];
$password = $_POST['password'];

if($username == "" || $password == ""){
    header("Location: login.php?msg=Username dan Password belum diisi");
    exit;
}

if(!isset($users[$username])){
    header("Location: login.php?msg=Username tidak terdaftar");
    exit;
}

if($users[$username] != $password){
    header("Location: login.php?msg=Password yang dimasukkan salah");
    exit;
}

$_SESSION['login'] = 1;
$_SESSION['username'] = $username;

header("Location: index.php");
?>