<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_POST['image'];
$price = $_POST['price'];
$date = date('y-m-d H:i:s');
// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
require_once 'ffRand.php';
try {
    if ($_FILES['image'] && $_FILES['image']['tmp_name']) {
        $img = $_FILES['image']['name'];
        $imgPath = 'images/' . randomString() . '/' . $img;
        //create dir
        mkdir(dirname($imgPath), 0777, true);
        //remove dir
        //system("rm -rf " . escapeshellarg("images"));
        move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
    }
    $stat = $pdo->prepare("INSERT INTO product(title, description, image, price, create_date) VALUES(:title, :des, :image, :price, :date)");
    $stat->execute([
        ':title' => $title,
        ':des' => $description,
        ':image' => $imgPath,
        ':price' => $price,
        ':date' => $date,
    ]);
    header('Location:index.php');
} catch (Exception $msg) {}

?>

<html>
  <head>
    <title>create product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <h2 class="p-2">Add Product : </h2>
    <form action="" method="POST" class="border p-2 m-4 w-50" enctype="multipart/form-data">
      <div class="form-group m-3">
      <label for="Title" style="margin-right:50px">Title</label>
      <input type="text" id="Title" class="form-control" name="title" required/>
      </div>
     <div class="form-group m-3">
      <label for="Description" style="margin-right:50px">Description</label>
      <input type="text" id="Description" class="form-control" name="description" required/>
      </div>
      <div class="form-group m-3">
      <label for="Image" style="margin-right:50px">Image</label>
      <input type="file" id="Image" class="m-1" name="image" required/>
      </div>
      <div class="form-group m-3">
      <label for="Price" style="margin-right:50px">Price</label>
      <input type="number" step="any" id="Price" class="form-control" name="price" required/>
      </div>
      <button class="btn btn-primary m-2">Create Product</button>
      <a href="index.php" class="btn btn-secondary m-2">Back to Prodcuts List</a>
    </form>
  </body>
</html>
