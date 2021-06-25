<?php require_once __DIR__ . '/database.php' ?>
<?php

  $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
  $statement->execute();
  $products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include_once __DIR__ . '/view/partials/header.php' ?>

  <h1>CrudY - Version 1</h1>
  <!-- Create Button -->
  <p>
    <a href="create.php" class="btn btn-success">Create Product</a>
  </p>
  <!-- Create Button End -->
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
      <?php foreach($products as $index => $product): ?>
      <tr>
        <th scope="row"><?php echo $index + 1 ?></th>
        <td><img src="<?php echo $product['image'] ?>" class="thumb-img"></td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
        <td>
          <button class="btn btn-sm btn-outline-primary">Edit</button>
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

<?php include_once __DIR__ . '/view/partials/footer.php' ?>