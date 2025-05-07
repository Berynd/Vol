<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: ../vue/login.php');
    exit();
}
else {
    header('Location: /index.php');
}
