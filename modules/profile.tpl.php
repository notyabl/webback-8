<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($c['title']); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding: 20px;
    }
    .container {
      max-width: 900px;
      margin: 0 auto;
    }
    .profile-card {
      background: white;
      border-radius: 1.5rem;
      padding: 3rem;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .profile-header {
      text-align: center;
      margin-bottom: 2.5rem;
      padding-bottom: 2rem;
      border-bottom: 2px solid #e2e8f0;
    }
    .profile-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 0.5rem;
    }
    .profile-header p {
      color: #64748b;
      font-size: 1.1rem;
    }
    .success-message {
      background: #dcfce7;
      border-left: 4px solid #22c55e;
      color: #166534;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 2rem;
    }
    .error-message {
      background: #fef2f2;
      border-left: 4px solid #ef4444;
      color: #991b1b;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 2rem;
    }
    .form-section {
      margin-bottom: 2.5rem;
    }
    .form-section h2 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #0f172a;
      margin-bottom: 1.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 1px solid #e2e8f0;
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
    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 2px solid #e2e8f0;
      border-radius: 0.75rem;
      font-size: 1rem;
      font-family: inherit;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
    }
    .form-group input.error,
    .form-group select.error {
      border-color: #ef4444;
      background: #fef2f2;
    }
    .error-text {
      color: #ef4444;
      font-size: 0.85rem;
      margin-top: 0.3rem;
    }
    .hint {
      font-size: 0.8rem;
      color: #94a3b8;
      margin-top: 0.25rem;
    }
    .radio-group {
      display: flex;
      gap: 1.5rem;
    }
    .radio-label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      font-weight: 400;
    }
    .radio-label input {
      width: auto;
    }
    select[multiple] {
      height: 150px;
    }
    .btn-save {
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
    }
    .btn-save:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
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
    .user-info {
      background: #f8fafc;
      padding: 1.5rem;
      border-radius: 0.75rem;
      margin-bottom: 2rem;
    }
    .user-info p {
      margin-bottom: 0.5rem;
      color: #475569;
    }
    .user-info strong {
      color: #0f172a;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="profile-card">
      <div class="profile-header">
        <h1>👤 Личный кабинет</h1>
        <p>Управление вашей информацией</p>
      </div>

      <?php if (!empty($_SESSION['profile_success'])): ?>
        <div class="success-message">
          ✅ <?php echo htmlspecialchars($_SESSION['profile_success']); ?>
        </div>
        <?php unset($_SESSION['profile_success']); ?>
      <?php endif; ?>

      <?php if (!empty($c['errors']['db'])): ?>
        <div class="error-message">
          ⚠️ <?php echo htmlspecialchars($c['errors']['db']); ?>
        </div>
      <?php endif; ?>

      <div class="user-info">
        <p><strong>Логин:</strong> <?php echo htmlspecialchars($c['user']['login']); ?></p>
        <p><strong>ID пользователя:</strong> <?php echo htmlspecialchars($c['user']['id']); ?></p>
        <?php if ($c['application']): ?>
        <p><strong>ID заявки:</strong> <?php echo htmlspecialchars($c['application']['id']); ?></p>
        <p><strong>Дата регистрации:</strong> <?php echo date('d.m.Y H:i', strtotime($c['application']['created_at'])); ?></p>
        <?php endif; ?>
      </div>

      <form method="POST" action="">
        <div class="form-section">
          <h2>📋 Основная информация</h2>
          
          <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email"
                   value="<?php echo htmlspecialchars($c['user']['email'] ?? ''); ?>"
                   required>
            <?php if (!empty($c['errors']['email'])): ?>
              <div class="error-text"><?php echo htmlspecialchars($c['errors']['email']); ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="full_name">ФИО *</label>
            <input type="text" id="full_name" name="full_name"
                   value="<?php echo htmlspecialchars($c['application']['full_name'] ?? ''); ?>"
                   required maxlength="150" pattern="[а-яА-ЯёЁa-zA-Z\s\-]+">
            <div class="hint">Только буквы, пробелы и дефисы. От 2 до 150 символов.</div>
            <?php if (!empty($c['errors']['full_name'])): ?>
              <div class="error-text"><?php echo htmlspecialchars($c['errors']['full_name']); ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="phone">Телефон *</label>
            <input type="tel" id="phone" name="phone"
                   value="<?php echo htmlspecialchars($c['application']['phone'] ?? ''); ?>"
                   required pattern="[\+\d\s\(\)\-]{10,20}">
            <div class="hint">Формат: +7 (123) 456-78-90 (10-20 символов)</div>
            <?php if (!empty($c['errors']['phone'])): ?>
              <div class="error-text"><?php echo htmlspecialchars($c['errors']['phone']); ?></div>
            <?php endif; ?>
          </div>
        </div>

        <div class="form-section">
          <h2>📅 Дополнительные данные</h2>
          
          <div class="form-group">
            <label for="birth_date">Дата рождения *</label>
            <input type="date" id="birth_date" name="birth_date"
                   value="<?php echo htmlspecialchars($c['application']['birth_date'] ?? ''); ?>"
                   required>
            <?php if (!empty($c['errors']['birth_date'])): ?>
              <div class="error-text"><?php echo htmlspecialchars($c['errors']['birth_date']); ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label>Пол *</label>
            <div class="radio-group">
              <label class="radio-label">
                <input type="radio" name="gender" value="male"
                       <?php echo ($c['application']['gender'] ?? '') == 'male' ? 'checked' : ''; ?> required>
                <span>Мужской</span>
              </label>
              <label class="radio-label">
                <input type="radio" name="gender" value="female"
                       <?php echo ($c['application']['gender'] ?? '') == 'female' ? 'checked' : ''; ?>>
                <span>Женский</span>
              </label>
            </div>
            <?php if (!empty($c['errors']['gender'])): ?>
              <div class="error-text"><?php echo htmlspecialchars($c['errors']['gender']); ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="languages">Любимые языки программирования</label>
            <select id="languages" name="languages[]" multiple>
              <?php 
              $all_languages = db_query("SELECT name FROM programming_languages ORDER BY name");
              foreach ($all_languages as $lang): 
              ?>
                <option value="<?php echo htmlspecialchars($lang['name']); ?>"
                  <?php echo in_array($lang['name'], $c['languages']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($lang['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="hint">Удерживайте Ctrl (Cmd на Mac) для множественного выбора</div>
          </div>

          <div class="form-group">
            <label for="biography">Биография</label>
            <textarea id="biography" name="biography" rows="5"
                      maxlength="5000"><?php echo htmlspecialchars($c['application']['biography'] ?? ''); ?></textarea>
            <div class="hint">Необязательно. Максимум 5000 символов.</div>
          </div>
        </div>

        <button type="submit" class="btn-save">💾 Сохранить изменения</button>
      </form>

      <div class="back-link">
        <a href="./">← Вернуться на главную</a>
      </div>
    </div>
  </div>
</body>
</html>