<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($c['title']); ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }
    .login-box {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }
    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 2rem;
    }
    .form-group {
      margin-bottom: 1.5rem;
    }
    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
      color: #555;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      border: 2px solid #ddd;
      border-radius: 0.5rem;
      font-size: 1rem;
      box-sizing: border-box;
    }
    input:focus {
      outline: none;
      border-color: #667eea;
    }
    button {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 0.5rem;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      opacity: 0.9;
    }
    .error {
      background: #fee;
      color: #c00;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
      border-left: 4px solid #c00;
    }
    .back-link {
      text-align: center;
      margin-top: 1rem;
    }
    .back-link a {
      color: #667eea;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h1>🔐 Вход</h1>
    
    <?php if (!empty($c['errors']['auth'])): ?>
      <div class="error">⚠️ <?php echo htmlspecialchars($c['errors']['auth']); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
      <div class="form-group">
        <label for="login">Логин</label>
        <input type="text" id="login" name="login" 
               value="<?php echo htmlspecialchars($c['values']['login'] ?? ''); ?>" 
               required autofocus>
        <?php if (!empty($c['errors']['login'])): ?>
          <div style="color:red;font-size:0.85rem;"><?php echo htmlspecialchars($c['errors']['login']); ?></div>
        <?php endif; ?>
      </div>
      
      <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        <?php if (!empty($c['errors']['password'])): ?>
          <div style="color:red;font-size:0.85rem;"><?php echo htmlspecialchars($c['errors']['password']); ?></div>
        <?php endif; ?>
      </div>
      
      <button type="submit">Войти</button>
    </form>
    
    <div class="back-link">
      <a href="/">← На главную</a>
    </div>
  </div>
</body>
</html>