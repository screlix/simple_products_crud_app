<?php

$pp = new PDO('mysql:host=localhost;port=3306;dbname=products', 'root', '');
$pp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$image = $_POST['img'];
$price = $_POST['price'];

echo $image . '<br>';
$myfiles = array_diff(scandir($image), array('.', '..'));
echo $myfiles[0];

try {
    $stat = $pp->prepare("update product set title=:title, description=:description, image=:image, price=:price where id=:id");
    $stat->execute([
        ':title' => $title,
        ':description' => $description,
        ':image' => $image,
        ':price' => $price,
        ':id' => $id,
    ]);
} catch (Exception $msg) {}
