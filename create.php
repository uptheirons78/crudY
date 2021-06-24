<?php include_once __DIR__ . '/database.php' ?>
<?php include_once __DIR__ . '/functions.php' ?>
<?php

// Array to store errors
$errors = [];

$title = '';
$price = '';
$description = '';

// Check if the request method is POST
// only if it is insert data into database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  // Validate title and price
  if (!$title) {
    $errors[] = 'Product title is required';
  }

  if (!$price) {
    $errors[] = 'Product price is required';
  }

  // if there is no images folder, create it
  if (!is_dir('images')) {
    mkdir('images');
  }

  // Only if errors array is empty insert in the database
  if (empty($errors)) {

    // if image is uploaded store inside a variable, set to null if not uploaded
    $image = $_FILES['image'] ?? null;
    // imagePath variable (to avoid db issues)
    $imagePath = '';
    // if there is an image and it has a tmp_name
    if ($image && $image['tmp_name']) {
      // create the image path
      $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
      // create directory for the image
      mkdir(dirname($imagePath));
      // move it from temp folder and save it inside test.jpg
      move_uploaded_file($image['tmp_name'], $imagePath);
    }



    $statement = $pdo->prepare("
        INSERT INTO products (title, image, description, price, create_date)
        VALUES (:title, :image, :description, :price, :date)
      ");

    $statement->bindValue(':title', $title);
    $statement->bindValue(':image', $imagePath);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':date', date('Y-m-d H:i:s'));

    $statement->execute();

    // Redirect to home page
    header('Location: index.php');
  }
}

?>
<?php include_once __DIR__ . '/view/partials/header.php' ?>

<h1>Create New Product</h1>
<!-- ERROR BANNER -->
<?php if (!empty($errors)) : ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $error) : ?>
      <div><?php echo $error ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<!-- ERROR BANNER END -->
<!-- FORM -->
<form action="" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label>Product Image</label><br>
    <input type="file" name="image">
  </div>
  <div class="mb-3">
    <label>Product Title</label>
    <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
  </div>
  <div class="mb-3">
    <label>Product Description</label>
    <textarea class="form-control" name="description"><?php echo $description ?></textarea>
  </div>
  <div class="mb-3">
    <label>Product Price</label>
    <input type="number" step=".01" class="form-control" name="price" value="<?php echo $price ?>">
  </div>
  <button type="submit" class="btn btn-primary">Create</button>
</form>
<!-- FORM END -->

<?php include_once __DIR__ . '/view/partials/footer.php' ?>