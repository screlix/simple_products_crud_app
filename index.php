<?php

$pp = new PDO('mysql:host=localhost;port=3306;dbname=products', 'root', '');
$pp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = $pp->prepare('select * from product order by create_date desc');
$query->execute();
$elements = $query->fetchAll(PDO::FETCH_ASSOC);
$source_file = 'badV';
$destination_path = 'images';
rename($source_file, $destination_path);
//search :
$search = $_GET['search'];
if ($search) {
    $stat = $pp->prepare('select * from product where title=:title');
    $stat->execute([
        ':title' => $search,
    ]);
    $elements = $stat->fetchAll(PDO::FETCH_ASSOC);
}

?>
<html>

<head>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>product crud</title>
</head>

<body>
  <header class="row d-flex w-100 p-2">
    <div class="col">
    <h1 class="p-2">product crud</h1>
    <a href="createP.php" class="btn btn-success shadow-none m-2">Create Product</a>
    </div>
  <form method="get" class="col p-4">
     <div class="input-group w-50" style="float:right">
     <input id="search" name="search" type="search" class="shadow-none form-control rounded w-50" placeholder="Search"/>
       <button type="submit" class="btn btn-primary shadow">
         <i class="fas fa-search"></i>
       </button>
     </div>
  </form>
  </header>
  <div class="container">
  <table class="table m-2">
    <thead class="">
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Image</th>
        <th scope="col">Price</th>
        <th scope="col">Date Created</th>
        <th scope="col">Action</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($elements as $el): ?>
    <tr>
           <td> <?php echo $el['id'] ?></td>
           <td><?php echo $el['title'] ?></td>
           <td><?php echo $el['description'] ?></td>
           <td> <img width="60px" src="<?php echo $el['image'] ?>" alt='img'> </td>
           <td><?php echo $el['price'] ?></td>
            <td><?php echo $el['create_date'] ?></td>
           <td>
             <?php $idd = $el['id']?>

            <a href="delete.php?id=<?php echo $idd ?>" class='btn btn-danger shadow-none'>Delete</a>

            </td>
            <td>
            <a href="Edit.php?id= <?php echo $idd ?> " class='btn btn-primary shadow-none'>Edit</a>
            </td>
     </tr>
        <?php endforeach;?>
    </tbody>
  </table>
  </div>
</body>

</html>