<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require_once 'ffRand.php';
// var_dump($_FILES);

$id = $_GET['id'];
if (!$id) {
    header('Location:index.php');
    exit;
}

//filling the input fields
try {
    $stat = $pdo->prepare("select * from product where id=:id");
    $stat->execute([
        ':id' => $id,
    ]);
    $els = $stat->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // var_dump($els);
    // echo '</pre>';
    $els = $els[0];
    //image dir making
    $img = $_FILES['image'];
    $imgPath = $els['image'];
    if ($img && $img['tmp_name']) {
        $imgPath = 'images/' . randomString() . '/' . $img['name'];
        mkdir(dirname($imgPath), 0777, true);
        move_uploaded_file($img['tmp_name'], $imgPath);
        if ($els['image']) {
            unlink($els['image']);
        }

    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // second part :
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $imgPath;
        $price = $_POST['price'];
        $stat = $pdo->prepare("UPDATE product SET title=:title, description=:description, image=:image, price=:price where id=:id");
        $stat->execute([
            ':title' => $title,
            ':description' => $description,
            ':image' => $imgPath,
            ':price' => $price,
            ':id' => $id,
        ]);
        // header('Location : index.php');
        // exit;
    }
} catch (Exception $msg) {}

// $myfiles = array_diff(scandir($image), array('.', '..'));
// echo $myfiles[0];
?>

<html>
  <head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  </head>
  <body>
    <h1 class="m-3">
    Edit Product <strong> <?php echo $els['title'] ?> </strong>
    <img class="m-3" width="140" src="<?php echo $imgPath ?>" alt="">
    </h1>
    <form action="" method="POST" style="margin:2rem;padding:1rem" class="bg-light border w-50" enctype="multipart/form-data">
    <div class="form-group m-3">
      <label for="Title" style="margin-right:50px">Title</label>       <input type="text" id="Title" class="form-control" name="title" value="<?php echo $els['title'] ?>" />
      </div>
     <div class="form-group m-3">
      <label for="Description" style="margin-right:50px">Description</label>
      <input type="text" id="Description" class="form-control" name="description" value="<?php echo $els['description'] ?>" />
      </div>
      <div class="form-group m-3">
      <label class="form-label" for="Image" style="margin-right:50px">Image</label>
      <input type="file" id="Image" class="form-control m-1" name="image" />
      </div>
      <div class="form-group m-3">
      <label for="Price" style="margin-right:50px">Price</label>
      <input type="number" step="any" id="Price" class="form-control" name="price" value="<?php echo $els['price'] ?>" />
      </div>
      <input type="text" name="id" value="<?php echo $id ?>" class="d-none"/>
      <input type="text" name="img" value="<?php echo $imgPath ?>" class="d-none"/>
      <div class="">
      <a href="index.php" style="float:right" class="m-2 btn btn-warning">Cancel</a>
      <a href="index.php" style="float:right" class="m-2 btn btn-info">Back to Products</a>
      <button type="submit" style="float:right" class="m-2 btn btn-primary">Save</button>
      <div style="clear:both"></div>
      </div>
    </form>
  </body>
</html>
