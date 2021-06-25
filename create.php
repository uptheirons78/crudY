<?php require_once __DIR__ . '/database.php' ?>
<?php include_once __DIR__ . '/functions.php' ?>
<?php

// Array to store errors
$errors = [];

$title = '';
$price = '';
$description = '';
$product = [
  'image' => ''
];

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
<?php include_once __DIR__ . '/views/partials/header.php' ?>
<!-- Back Home Button -->
<p>
  <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
</p>
<!-- Back Home Button End -->
<h1>Create New Product</h1>
<?php include_once __DIR__ . '/views/products/form.php' ?>
<?php include_once __DIR__ . '/views/partials/footer.php' ?>