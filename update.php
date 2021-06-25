<?php require_once __DIR__ . '/database.php' ?>
<?php include_once __DIR__ . '/functions.php' ?>
<?php

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
    // imagePath variable
    $imagePath = $product['image'];

    // if there is an image and it has a tmp_name
    if ($image && $image['tmp_name']) {

      // if the product has already an image
      if ($product['image']) {
        // get dirname
        $dirname = dirname($product['image']);
        // remove the image
        unlink($product['image']);
        // remove directory
        rmdir($dirname);
      }

      // create the image path
      $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
      // create directory for the image
      mkdir(dirname($imagePath));
      // move it from temp folder and save it inside test.jpg
      move_uploaded_file($image['tmp_name'], $imagePath);
    }

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
<?php include_once __DIR__ . '/views/partials/header.php' ?>

<!-- Back Home Button -->
<p>
  <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
</p>
<!-- Back Home Button End -->
<h1>Update Product: <b style="color: purple;"><?php echo $product['title'] ?></b></h1>
<?php include_once __DIR__ . '/views/products/form.php' ?>
<?php include_once __DIR__ . '/views/partials/footer.php' ?>