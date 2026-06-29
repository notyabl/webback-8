<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($c['title'] ?? 'Анкета разработчика - CodeCraft Studio'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* ========== RESET & BASE ========== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: #f0f4f8;
      color: #1a202c;
      line-height: 1.6;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    /* ========== CONTAINER ========== */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

   /* ===== NAVIGATION (исправленная) ===== */
.navbar {
  background: rgba(15, 23, 42, 0.92);
  backdrop-filter: blur(12px);
  position: fixed;
  width: 100%;
  top: 0;
  z-index: 1000;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.nav-inner {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;  /* ← логотип слева, меню справа */
  align-items: center;
  padding: 0.9rem 0;
  gap: 0.5rem 1.5rem;
}

.logo {
  font-size: 1.7rem;
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.5px;
  white-space: nowrap;
}

.logo span {
  color: #3b82f6;
}

.nav-links {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  list-style: none;
  margin: 0;
  padding: 0;
  align-items: center;
}

.nav-links a {
  color: #e2e8f0;
  font-weight: 600;           /* ← чуть жирнее */
  font-size: 1.05rem;         /* ← чуть больше */
  padding: 0.4rem 0.2rem;
  transition: color 0.25s;
  position: relative;
  white-space: nowrap;
}

.nav-links a::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 0;
  height: 2px;
  background: #3b82f6;
  transition: width 0.25s;
}

.nav-links a:hover {
  color: #fff;
}

.nav-links a:hover::after {
  width: 100%;
}

/* ===== АДАПТИВНОСТЬ ===== */
@media (max-width: 768px) {
  .nav-inner {
    justify-content: center;   /* на узких экранах всё по центру */
    gap: 0.8rem;
    padding: 0.7rem 0;
  }
  .logo {
    font-size: 1.5rem;
  }
  .nav-links {
    gap: 1.2rem;
  }
  .nav-links a {
    font-size: 0.95rem;
  }
}

@media (max-width: 480px) {
  .nav-links {
    gap: 0.8rem;
  }
  .nav-links a {
    font-size: 0.85rem;
  }
  .logo {
    font-size: 1.3rem;
  }
}

    /* ========== HERO ========== */
    .hero {
      margin-top: 70px;
      background: linear-gradient(145deg, #0b1a33, #1a3a7a, #2563eb);
      color: #fff;
      padding: 6rem 0;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
    }

    .hero-content {
      position: relative;
      z-index: 1;
      max-width: 720px;
      margin: 0 auto;
    }

    .hero-badge {
      display: inline-block;
      background: rgba(59, 130, 246, 0.18);
      border: 1px solid rgba(59, 130, 246, 0.25);
      padding: 0.4rem 1.2rem;
      border-radius: 999px;
      font-size: 0.85rem;
      font-weight: 500;
      letter-spacing: 0.3px;
      margin-bottom: 1.8rem;
    }

    .hero h1 {
      font-size: 3.2rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 1.2rem;
      letter-spacing: -0.02em;
    }

    .hero p {
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 2.2rem;
      max-width: 560px;
      margin-left: auto;
      margin-right: auto;
    }

    .btn-primary {
      display: inline-block;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: #fff;
      padding: 1rem 2.8rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 1.05rem;
      transition: transform 0.2s, box-shadow 0.2s;
      border: none;
      cursor: pointer;
      box-shadow: 0 8px 24px rgba(59, 130, 246, 0.35);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 14px 32px rgba(59, 130, 246, 0.45);
    }

    /* ========== SERVICES ========== */
    .services {
      padding: 5rem 0;
      background: #fff;
    }

    .section-title {
      text-align: center;
      margin-bottom: 3.5rem;
    }

    .section-title h2 {
      font-size: 2.4rem;
      font-weight: 700;
      color: #0f172a;
      letter-spacing: -0.02em;
    }

    .section-title p {
      color: #64748b;
      font-size: 1.1rem;
      margin-top: 0.5rem;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
    }

    .service-card {
      background: #f8fafc;
      padding: 2.2rem 1.8rem;
      border-radius: 1.2rem;
      text-align: center;
      transition: transform 0.25s, box-shadow 0.25s;
      border: 1px solid #e9edf2;
    }

    .service-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 32px rgba(0, 0, 0, 0.06);
    }

    .service-icon {
      width: 60px;
      height: 60px;
      margin: 0 auto 1.2rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.6rem;
      font-weight: 700;
    }

    .service-card h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.7rem;
      color: #0f172a;
    }

    .service-card p {
      color: #64748b;
      font-size: 0.95rem;
      line-height: 1.5;
    }

    /* ========== FORM SECTION ========== */
    .form-section {
      padding: 4rem 0;
      max-width: 780px;
      margin: 0 auto;
    }

    .form-card {
      background: #ffffff;
      border-radius: 2rem;
      padding: 3rem 3.5rem;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.07);
      border: 1px solid #eef2f6;
    }

    .form-header {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .form-header h2 {
      font-size: 2rem;
      font-weight: 700;
      color: #0f172a;
    }

    .form-header p {
      color: #64748b;
      margin-top: 0.3rem;
    }

    /* ошибки и сообщения */
    .result-message {
      margin-bottom: 2rem;
      padding: 1.2rem 1.5rem;
      border-radius: 1rem;
      display: none;
    }

    .result-message.error-box {
      display: block;
      background: #fef2f2;
      border-left: 4px solid #ef4444;
      color: #991b1b;
    }

    .result-message.success-box {
      display: block;
      background: #dcfce7;
      border-left: 4px solid #22c55e;
      color: #166534;
    }

    .result-message ul {
      padding-left: 1.5rem;
      margin: 0.5rem 0 0;
    }

    .form-group {
      margin-bottom: 1.8rem;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      font-size: 0.95rem;
      color: #1e293b;
      margin-bottom: 0.4rem;
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
      border-radius: 0.75rem;
      font-size: 1rem;
      font-family: inherit;
      transition: border-color 0.2s, box-shadow 0.2s;
      background: #fafcff;
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

    .hint {
      font-size: 0.8rem;
      color: #94a3b8;
      margin-top: 0.25rem;
    }

    .error-message {
      color: #ef4444;
      font-size: 0.85rem;
      margin-top: 0.3rem;
      display: none;
    }

    .radio-group,
    .checkbox-group {
      display: flex;
      gap: 1.8rem;
      flex-wrap: wrap;
      align-items: center;
    }

    .radio-label,
    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      font-weight: 400;
      font-size: 0.95rem;
    }

    .radio-label input,
    .checkbox-label input {
      width: auto;
      accent-color: #3b82f6;
    }

    select[multiple] {
      height: 160px;
    }

    .btn-submit {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: #fff;
      border: none;
      border-radius: 60px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 0.5rem;
      box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25);
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 32px rgba(59, 130, 246, 0.35);
    }

    /* ========== FEATURES ========== */
    .features {
      background: #f8fafc;
      padding: 5rem 0;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .feature-card {
      background: #fff;
      padding: 2rem 1.8rem;
      border-radius: 1.2rem;
      text-align: center;
      border: 1px solid #eef2f6;
      transition: transform 0.2s;
    }

    .feature-card:hover {
      transform: translateY(-4px);
    }

    .feature-number {
      font-size: 2.2rem;
      font-weight: 800;
      color: #3b82f6;
      margin-bottom: 0.8rem;
    }

    .feature-card h3 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.6rem;
      color: #0f172a;
    }

    .feature-card p {
      color: #64748b;
      font-size: 0.9rem;
      line-height: 1.5;
    }

    /* ========== FOOTER ========== */
    .footer {
      background: #0f172a;
      color: #e2e8f0;
      padding: 3rem 0 2rem;
      text-align: center;
    }

    .footer-links {
      display: flex;
      justify-content: center;
      gap: 2.5rem;
      flex-wrap: wrap;
      margin-bottom: 2rem;
    }

    .footer-links a {
      color: #cbd5e1;
      transition: color 0.2s;
    }

    .footer-links a:hover {
      color: #3b82f6;
    }

    .footer p {
      opacity: 0.7;
      font-size: 0.9rem;
      margin-bottom: 0.3rem;
    }
  </style>
</head>
<body>

<!-- ===== NAVIGATION ===== -->
<nav class="navbar">
  <div class="container nav-inner">
    <a href="#top" class="logo">Code<span>Craft</span></a>
    <ul class="nav-links">
      <li><a href="#services">Услуги</a></li>
      <li><a href="#form">Анкета</a></li>
      <li><a href="#features">Поддержка</a></li>
      <li><a href="/webback-8/admin">Админка</a></li>
    </ul>
  </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero" id="top">
  <div class="container hero-content">
    <div class="hero-badge">🚀 Профессиональная веб-разработка</div>
    <h1>13 лет совершенствуем компетенции в разработке!</h1>
    <p>Разрабатываем и оптимизируем модули, расширяем функциональность сайтов, обновляем дизайн</p>
    <a href="#form" class="btn-primary">Стать клиентом</a>
  </div>
</section>

<!-- ===== SERVICES ===== -->
<section class="services" id="services">
  <div class="container">
    <div class="section-title">
      <h2>Наши услуги</h2>
      <p>Полный спектр услуг по разработке, поддержке и продвижению сайтов</p>
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
        <p>Миграция, импорт контента и интерфейс, мониторинг безопасности</p>
      </div>
      <div class="service-card">
        <div class="service-icon">⚡</div>
        <h3>Оптимизация скорости</h3>
        <p>Веб-маркетинг, консультации и работы по SEO, ускорение сайтов</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== FORM SECTION ===== -->
<section class="form-section" id="form">
  <div class="form-card">
    <div class="form-header">
      <h2>📝 Анкета разработчика</h2>
      <p>Заполните форму для регистрации в системе поддержки</p>
    </div>

    <?php if (!empty($c['errors'])): ?>
      <div class="result-message error-box">
        <strong>⚠️ Ошибки в форме:</strong>
        <ul>
          <?php foreach ($c['errors'] as $field => $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form id="application-form" action="/" method="POST" novalidate>
      <!-- ФИО -->
      <div class="form-group">
        <label for="full_name">ФИО <span>*</span></label>
        <input type="text" id="full_name" name="full_name"
               value="<?php echo htmlspecialchars($c['values']['full_name'] ?? ''); ?>"
               required maxlength="150" pattern="[а-яА-ЯёЁa-zA-Z\s\-]+">
        <div class="hint">Только буквы, пробелы и дефисы. От 2 до 150 символов.</div>
        <div class="error-message" id="error-full_name"></div>
      </div>

      <!-- Телефон -->
      <div class="form-group">
        <label for="phone">Телефон <span>*</span></label>
        <input type="tel" id="phone" name="phone"
               value="<?php echo htmlspecialchars($c['values']['phone'] ?? ''); ?>"
               required pattern="[\+\d\s\(\)\-]{10,20}">
        <div class="hint">Формат: +7 (123) 456-78-90 (10-20 символов)</div>
        <div class="error-message" id="error-phone"></div>
      </div>

      <!-- E-mail -->
      <div class="form-group">
        <label for="email">E-mail <span>*</span></label>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($c['values']['email'] ?? ''); ?>"
               required>
        <div class="hint">Пример: user@domain.com</div>
        <div class="error-message" id="error-email"></div>
      </div>

      <!-- Дата рождения -->
      <div class="form-group">
        <label for="birth_date">Дата рождения <span>*</span></label>
        <input type="date" id="birth_date" name="birth_date"
               value="<?php echo htmlspecialchars($c['values']['birth_date'] ?? ''); ?>"
               required>
        <div class="hint">Возраст должен быть от 18 до 120 лет</div>
        <div class="error-message" id="error-birth_date"></div>
      </div>

      <!-- Пол -->
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

      <!-- Языки -->
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

      <!-- Биография -->
      <div class="form-group">
        <label for="biography">Биография</label>
        <textarea id="biography" name="biography" rows="5"
                  maxlength="5000"><?php echo htmlspecialchars($c['values']['biography'] ?? ''); ?></textarea>
        <div class="hint">Необязательно. Максимум 5000 символов.</div>
      </div>

      <!-- Согласие -->
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
  </div>
</section>

<!-- ===== FEATURES ===== -->
<section class="features" id="features">
  <div class="container">
    <div class="section-title">
      <h2>Поддержка от CodeCraft</h2>
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
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
  <div class="container">
    <div class="footer-links">
      <a href="#services">Услуги</a>
      <a href="#form">Анкета</a>
      <a href="#features">Поддержка</a>
      <a href="/webback-8/admin">Админ-панель</a>
    </div>
    <p>&copy; <?php echo date('Y'); ?> CodeCraft Studio. Все права защищены.</p>
    <p>Профессиональная веб-разработка и поддержка</p>
  </div>
</footer>

<script src="js/form.js"></script>
</body>
</html>