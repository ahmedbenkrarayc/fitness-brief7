<?php
session_start();
if(!isset($_SESSION['id']) || !isset($_SESSION['role'])){
    header('Location: ./../index.php');
}else{
    if($_SESSION['role'] != 'membre'){
        header('Location: ./../index.php');
    }
}