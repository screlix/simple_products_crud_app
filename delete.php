<?php

$pp = new PDO('mysql:host=localhost;port=3306;dbname=products', 'root', '');
$pp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$id = $_GET['id'];

try {
    $statD = $pp->prepare("DELETE FROM product WHERE id=:idd");
    $statD->execute([
        ':idd' => $id,
    ]);
} catch (Exception $msg) {}
header('Location:index.php');

echo $id;
