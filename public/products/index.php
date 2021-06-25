<?php

require_once __DIR__ . '/../../database.php';
// search variable based on query string search parameter
$search = $_GET['search'] ?? '';

// if there is a search
if ($search) {
  // search for products with the searched parameter string
  $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
  $statement->bindValue(':title', "%$search%");
} else {
  // if there is no search, return all the products from the database
  $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include_once __DIR__ . '/../../views/partials/header.php' ?>

<h1>CrudY - Version 2</h1>
<!-- Create Button -->
<p>
  <a href="create.php" class="btn btn-success">Create Product</a>
</p>
<!-- Create Button End -->
<!-- Quick Search -->
<form action="">
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $search ?>">
    <button class="btn btn-outline-secondary" type="submit">Search</button>
  </div>
</form>
<!-- Quick Search End -->
<!-- Table -->
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Created</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $index => $product) : ?>
      <tr>
        <th scope="row"><?php echo $index + 1 ?></th>
        <td><img src="<?php echo $product['image'] ?>" class="thumb-img"></td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
        <td>
          <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
          <form action="delete.php" method="post" style="display:inline-block">
            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<!-- Table End -->

<?php include_once __DIR__ . '/../../views/partials/footer.php' ?>