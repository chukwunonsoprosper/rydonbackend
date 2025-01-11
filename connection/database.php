<?php 
$connection = mysqli_connect('localhost', 'root', '', 'rydon');
if(!$connection) {
    die('connection failed');
}