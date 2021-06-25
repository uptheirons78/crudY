<?php

require_once __DIR__ . '/../../database.php';
include_once __DIR__ . '/../../functions.php';

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

  require_once __DIR__ . '/../../validate_product.php';

  // Only if errors array is empty insert in the database
  if (empty($errors)) {

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
<?php include_once __DIR__ . '/../../views/partials/header.php' ?>
<!-- Back Home Button -->
<p>
  <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
</p>
<!-- Back Home Button End -->
<h1>Create New Product</h1>
<?php include_once __DIR__ . '/../../views/products/form.php' ?>
<?php include_once __DIR__ . '/../../views/partials/footer.php' ?>