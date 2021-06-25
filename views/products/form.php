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
  <?php if ($product['image']) : ?>
    <img class="update-img" src="<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>">
  <?php endif; ?>
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