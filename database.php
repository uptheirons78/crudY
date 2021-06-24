<?php
$dsn = 'mysql:host=localhost;port=80;dbname=products_crud';
$pdo = new PDO($dsn, 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);