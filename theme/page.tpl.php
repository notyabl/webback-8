<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($c['title'] ?? 'Анкета разработчика'); ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <?php
    foreach ($c['#content'] as $content) {
      echo $content;
    }
    ?>
  </div>
  <script src="js/form.js"></script>
</body>
</html>