<?php
include 'include/header.php';
include 'include/navigation.php';

if(isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = '';
}

switch($page){
    case 'food':
        include 'page/data/food.php';
        break;
    case 'receipe':
        include 'page/data/receipe.php';
        break;
    default:
    include 'page/main.php';
    break;
}

include 'include/footer.php';