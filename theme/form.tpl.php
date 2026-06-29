<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($c['title'] ?? 'Анкета разработчика - Drupal Support'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      line-height: 1.6;
      color: #1a202c;
      background: #f7fafc;
    }

    /* Navigation */
    .navbar {
      background: rgba(15, 23, 42, 0.95);
      backdrop-filter: blur(10px);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      color: white;
      text-decoration: none;
    }

    .logo span {
      color: #3b82f6;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      list-style: none;
    }

    .nav-links a {
      color: #e2e8f0;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #3b82f6;
    }

    /* Hero Section */
    .hero {
      margin-top: 70px;
      background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #3b82f6 100%);
      color: white;
      padding: 6rem 2rem;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      opacity: 0.1;
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      line-height: 1.2;
    }

    .hero p {
      font-size: 1.25rem;
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    .hero-badge {
      display: inline-block;
      background: rgba(59, 130, 246, 0.2);
      border: 1px solid rgba(59, 130, 246, 0.3);
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      font-size: 0.875rem;
      margin-bottom: 1.5rem;
    }

    /* Services Section */
    .services {
      padding: 5rem 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-title {
      text-align: center;
      margin-bottom: 3rem;
    }

    .section-title h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #0f172a;
    }

    .section-title p {
      color: #64748b;
      font-size: 1.125rem;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      margin-bottom: 4rem;
    }

    .service-card {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      text-align: center;
    }

    .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .service-icon {
      width: 64px;
      height: 64px;
      margin: 0 auto 1.5rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      border-radius: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
    }

    .service-card h3 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #0f172a;
    }

    .service-card p {
      color: #64748b;
      line-height: 1.6;
    }

    /* Form Section */
    .form-section {
      background: white;
      padding: 4rem 2rem;
      margin: 4rem auto;
      max-width: 900px;
      border-radius: 1.5rem;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .form-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .form-header h2 {
      font-size: 2rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 0.5rem;
    }

    .form-header p {
      color: #64748b;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #334155;
    }

    .form-group label span {
      color: #ef4444;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 2px solid #e2e8f0;
      border-radius: 0.5rem;
      font-size: 1rem;
      transition: border-color 0.3s, box-shadow 0.3s;
      font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group input.error,
    .form-group select.error {
      border-color: #ef4444;
      background-color: #fef2f2;
    }

    .hint {
      font-size: 0.875rem;
      color: #64748b;
      margin-top: 0.25rem;
    }

    .error-message {
      color: #ef4444;
      font-size: 0.875rem;
      margin-top: 0.25rem;
      display: none;
    }

    .radio-group,
    .checkbox-group {
      display: flex;
      gap: 1.5rem;
      flex-wrap: wrap;
    }

    .radio-label,
    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      font-weight: 400;
    }

    .radio-label input,
    .checkbox-label input {
      width: auto;
    }

    select[multiple] {
      height: 150px;
    }

    .btn-submit {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      border: none;
      border-radius: 0.5rem;
      font-size: 1.125rem;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }

    .result-message {
      margin-top: 2rem;
      padding: 1.5rem;
      border-radius: 0.5rem;
      display: none;
    }

    .success-box {
      background: #dcfce7;
      border-left: 4px solid #22c55e;
      color: #166534;
    }

    .error-box {
      background: #fef2f2;
      border-left: 4px solid #ef4444;
      color: #991b1b;
    }

    .credentials {
      background: white;
      padding: 1rem;
      border-radius: 0.5rem;
      margin: 1rem 0;
      font-family: monospace;
    }

    /* Features Section */
    .features {
      padding: 5rem 2rem;
      background: #f1f5f9;
    }

    .features-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
    }

    .feature-card {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      text-align: center;
    }

    .feature-number {
      font-size: 2.5rem;
      font-weight: 700;
      color: #3b82f6;
      margin-bottom: 1rem;
    }

    .feature-card h3 {
      font-size: 1.125rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
      color: #0f172a;
    }

    .feature-card p {
      color: #64748b;
      line-height: 1.6;
    }

    /* Footer */
    .footer {
      background: #0f172a;
      color: white;
      padding: 3rem 2rem 1rem;
      text-align: center;
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer p {
      opacity: 0.8;
      margin-bottom: 1rem;
    }

    .footer-links {
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }

    .footer-links a {
      color: white;
      text-decoration: none;
      opacity: 0.8;
      transition: opacity 0.3s;
    }

    .footer-links a:hover {
      opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2rem;
      }

      .nav-links {
        display: none;
      }

      .section-title h2 {
        font-size: 1.75rem;
      }

      .form-section {
        padding: 2rem 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="/" class="logo">Drupal<span>-Coder</span></a>
      <ul class="nav-links">
        <li><a href="#services">Услуги</a></li>
        <li><a href="#form">Анкета</a></li>
        <li><a href="#features">Поддержка</a></li>
        <li><a href="/admin">Админка</a></li>
      </ul>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <div class="hero-badge">🚀 Профессиональная Drupal поддержка</div>
      <h1>13 лет совершенствуем компетенции в Drupal поддержке!</h1>
      <p>Разрабатываем и оптимизируем модули, расширяем функциональность сайтов, обновляем дизайн</p>
      <a href="#form" class="btn-submit" style="display: inline-block; width: auto; padding: 1rem 2rem;">Стать клиентом</a>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services" id="services">
    <div class="section-title">
      <h2>Наши услуги</h2>
      <p>Полный спектр услуг по разработке, поддержке и продвижению Drupal-сайтов</p>
    </div>
    <div class="services-grid">
      <div class="service-card">
        <div class="service-icon">+</div>
        <h3>Добавление информации на сайт</h3>
        <p>Разработка новых модулей сайта, расширение функциональности, создание новых разделов</p>
      </div>
      <div class="service-card">
        <div class="service-icon">&lt;/&gt;</div>
        <h3>Разработка модулей</h3>
        <p>Интеграция с CRM, 1С, платежными системами и любыми веб-сервисами</p>
      </div>
      <div class="service-card">
        <div class="service-icon">🛡️</div>
        <h3>Аудит безопасности</h3>
        <p>Миграция, импорт контента и апгрейд Drupal, мониторинг безопасности</p>
      </div>
      <div class="service-card">
        <div class="service-icon">⚡</div>
        <h3>Оптимизация скорости</h3>
        <p>Веб-маркетинг, консультации и работы по SEO, ускорение Drupal-сайтов</p>
      </div>
    </div>
  </section>

  <!-- Form Section -->
  <section class="form-section" id="form">
    <div class="form-header">
      <h2>📝 Анкета разработчика</h2>
      <p>Заполните форму для регистрации в системе поддержки</p>
    </div>

    <?php if (!empty($c['errors'])): ?>
      <div class="result-message error-box" style="display: block;">
        <h3>⚠️ Ошибки в форме:</h3>
        <ul style="margin: 1rem 0; padding-left: 1.5rem;">
          <?php foreach ($c['errors'] as $field => $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form id="application-form" action="/" method="POST" novalidate>
      <div class="form-group">
        <label for="full_name">ФИО <span>*</span></label>
        <input type="text" id="full_name" name="full_name" 
               value="<?php echo htmlspecialchars($c['values']['full_name'] ?? ''); ?>" 
               required maxlength="150" pattern="[а-яА-ЯёЁa-zA-Z\s\-]+">
        <div class="hint">Только буквы, пробелы и дефисы. От 2 до 150 символов.</div>
        <div class="error-message" id="error-full_name"></div>
      </div>

      <div class="form-group">
        <label for="phone">Телефон <span>*</span></label>
        <input type="tel" id="phone" name="phone" 
               value="<?php echo htmlspecialchars($c['values']['phone'] ?? ''); ?>" 
               required pattern="[\+\d\s\(\)\-]{10,20}">
        <div class="hint">Формат: +7 (123) 456-78-90 (10-20 символов)</div>
        <div class="error-message" id="error-phone"></div>
      </div>

      <div class="form-group">
        <label for="email">E-mail <span>*</span></label>
        <input type="email" id="email" name="email" 
               value="<?php echo htmlspecialchars($c['values']['email'] ?? ''); ?>" 
               required>
        <div class="hint">Пример: user@domain.com</div>
        <div class="error-message" id="error-email"></div>
      </div>

      <div class="form-group">
        <label for="birth_date">Дата рождения <span>*</span></label>
        <input type="date" id="birth_date" name="birth_date" 
               value="<?php echo htmlspecialchars($c['values']['birth_date'] ?? ''); ?>" 
               required>
        <div class="hint">Возраст должен быть от 18 до 120 лет</div>
        <div class="error-message" id="error-birth_date"></div>
      </div>

      <div class="form-group">
        <label>Пол <span>*</span></label>
        <div class="radio-group">
          <label class="radio-label">
            <input type="radio" name="gender" value="male" 
                   <?php echo ($c['values']['gender'] ?? '') == 'male' ? 'checked' : ''; ?> required>
            <span>Мужской</span>
          </label>
          <label class="radio-label">
            <input type="radio" name="gender" value="female" 
                   <?php echo ($c['values']['gender'] ?? '') == 'female' ? 'checked' : ''; ?>>
            <span>Женский</span>
          </label>
        </div>
        <div class="error-message" id="error-gender"></div>
      </div>

      <div class="form-group">
        <label for="languages">Любимые языки программирования <span>*</span></label>
        <select id="languages" name="languages[]" multiple required>
          <?php foreach ($c['languages'] as $lang): ?>
            <option value="<?php echo htmlspecialchars($lang['name']); ?>"
              <?php echo in_array($lang['name'], $c['values']['languages'] ?? []) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($lang['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <div class="hint">Удерживайте Ctrl (Cmd на Mac) для множественного выбора</div>
        <div class="error-message" id="error-languages"></div>
      </div>

      <div class="form-group">
        <label for="biography">Биография</label>
        <textarea id="biography" name="biography" rows="5" 
                  maxlength="5000"><?php echo htmlspecialchars($c['values']['biography'] ?? ''); ?></textarea>
        <div class="hint">Необязательно. Максимум 5000 символов.</div>
      </div>

      <div class="form-group checkbox-group">
        <label class="checkbox-label">
          <input type="checkbox" name="contract" value="1" 
                 <?php echo !empty($c['values']['contract']) ? 'checked' : ''; ?> required>
          <span>Я ознакомлен(а) с контрактом и согласен(на) с условиями <span>*</span></span>
        </label>
        <div class="error-message" id="error-contract" style="width: 100%;"></div>
      </div>

      <button type="submit" class="btn-submit">💾 Отправить заявку</button>
    </form>

    <div id="result-message" class="result-message"></div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <div class="section-title">
      <h2>Поддержка от Drupal-coder</h2>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-number">01</div>
        <h3>Постановка задач по Email</h3>
        <p>Удобная и привычная модель постановки задач, при которой задачи фиксируются и никогда не теряются.</p>
      </div>
      <div class="feature-card">
        <div class="feature-number">02</div>
        <h3>Система Helpdesk - отчетность</h3>
        <p>Возможность посмотреть все заявки в работе и отработанные часы в личном кабинете через браузер.</p>
      </div>
      <div class="feature-card">
        <div class="feature-number">03</div>
        <h3>Расширенная техподдержка</h3>
        <p>Возможность организации расширенной техподдержки с 6:00 до 22:00 без выходных.</p>
      </div>
      <div class="feature-card">
        <div class="feature-number">04</div>
        <h3>Персональный менеджер</h3>
        <p>Ваш менеджер всегда в курсе текущего состояния проекта и готов ответить на любые вопросы.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-links">
        <a href="#">О нас</a>
        <a href="#">Услуги</a>
        <a href="#">Тарифы</a>
        <a href="#">Контакты</a>
        <a href="/admin">Админ-панель</a>
      </div>
      <p>&copy; <?php echo date('Y'); ?> Drupal-Coder. Все права защищены.</p>
      <p>Профессиональная поддержка и разработка на Drupal</p>
    </div>
  </footer>

  <script src="js/form.js"></script>
</body>
</html>