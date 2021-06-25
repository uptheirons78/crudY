<?php
  require_once __DIR__ . '/database.php';
  // set $id variable
  $id = $_POST['id'] ?? null;
  // check if $id exists or not
  if (!$id) {
    header('Location: index.php');
    exit;
  }

  $query = 'DELETE FROM products WHERE id = :id';
  $statement = $pdo->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();

  header('Location: index.php');
?>