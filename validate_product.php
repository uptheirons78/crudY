<?php

  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $imagePath = '';

  // Validate title and price
  if (!$title) {
    $errors[] = 'Product title is required';
  }

  if (!$price) {
    $errors[] = 'Product price is required';
  }

  // if there is no images folder, create it
  if (!is_dir(__DIR__ . '/public/images')) {
    mkdir(__DIR__ . '/public/images');
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
        unlink(__DIR__ . '/public/' . $product['image']);
        // remove directory
        rmdir(__DIR__ . '/public/' . $dirname);
      }

      // create the image path
      $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
      // create directory for the image
      mkdir(dirname(__DIR__ . '/public/' . $imagePath));
      // move it from temp folder and save it inside test.jpg
      move_uploaded_file($image['tmp_name'], __DIR__ . '/public/' . $imagePath);
    }
  }