<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($c['title'] ?? 'Вход в систему'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .login-card {
      background: white;
      padding: 3rem;
      border-radius: 1.5rem;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      max-width: 450px;
      width: 100%;
    }
    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    .login-header h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 0.5rem;
    }
    .login-header p {
      color: #64748b;
    }
    .form-group {
      margin-bottom: 1.5rem;
    }
    .form-group label {
      display: block;
      font-weight: 600;
      font-size: 0.95rem;
      color: #1e293b;
      margin-bottom: 0.4rem;
    }
    .form-group input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 2px solid #e2e8f0;
      border-radius: 0.75rem;
      font-size: 1rem;
      font-family: inherit;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
    }
    .btn-login {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      border: none;
      border-radius: 0.75rem;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 0.5rem;
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }
    .error-message {
      background: #fef2f2;
      border-left: 4px solid #ef4444;
      color: #991b1b;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 1.5rem;
    }
    .back-link {
      text-align: center;
      margin-top: 1.5rem;
    }
    .back-link a {
      color: #3b82f6;
      text-decoration: none;
      font-weight: 500;
    }
    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-header">
      <h1>🔐 Вход в систему</h1>
      <p>Введите ваш логин и пароль</p>
    </div>

    <?php if (!empty($c['errors']['auth'])): ?>
      <div class="error-message">
        ⚠️ <?php echo htmlspecialchars($c['errors']['auth']); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="login">Логин</label>
        <input type="text" id="login" name="login" 
               value="<?php echo htmlspecialchars($c['values']['login'] ?? ''); ?>" 
               required autofocus>
        <?php if (!empty($c['errors']['login'])): ?>
          <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.3rem;">
            <?php echo htmlspecialchars($c['errors']['login']); ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        <?php if (!empty($c['errors']['password'])): ?>
          <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.3rem;">
            <?php echo htmlspecialchars($c['errors']['password']); ?>
          </div>
        <?php endif; ?>
      </div>

      <button type="submit" class="btn-login">Войти</button>
    </form>

    <div class="back-link">
      <a href="/">← Вернуться на главную</a>
    </div>
  </div>
</body>
</html>