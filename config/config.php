<?php

$conn = mysqli_connect('localhost','root','','dbcapstone');


function filter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>