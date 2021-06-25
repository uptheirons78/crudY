<?php

require_once __DIR__ . '/../../database.php';
include_once __DIR__ . '/../../functions.php';
// Create $id variable
$id = $_GET['id'] ?? null;
// If $id is not set (not there in the query string)
// Redirects to the home page
if (!$id) {
  header('Location: index.php');
  exit;
}

// Fetch the product with the $id
$query = 'SELECT * FROM products WHERE id = ' . $id;
$statement = $pdo->prepare($query);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

// Array to store errors
$errors = [];

// Set the variables equal to date stored inside the fetched product associative array
$title = $product['title'];
$price = $product['price'];
$description = $product['description'];

// Check if the request method is POST
// only if it is insert data into database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../../validate_product.php';

  // Only if errors array is empty insert in the database
  if (empty($errors)) {

    $updateQuery = "
      UPDATE products
      SET
      title = :title,
      image = :image,
      description = :description,
      price = :price
      WHERE id = :id
    ";

    $statement = $pdo->prepare($updateQuery);

    $statement->bindValue(':title', $title);
    $statement->bindValue(':image', $imagePath);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':id', $id);

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
<h1>Update Product: <b style="color: purple;"><?php echo $product['title'] ?></b></h1>
<?php include_once __DIR__ . '/../../views/products/form.php' ?>
<?php include_once __DIR__ . '/../../views/partials/footer.php' ?>