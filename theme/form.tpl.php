<div class="form-wrapper">
  <h1>📝 Анкета разработчика</h1>
  <p class="subtitle">Заполните форму для регистрации</p>

  <?php if (!empty($c['errors'])): ?>
    <div class="alert alert-error">
      <h3> Ошибки в форме:</h3>
      <ul>
        <?php foreach ($c['errors'] as $field => $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form id="application-form" action="/" method="POST" novalidate>
    <div class="form-group">
      <label for="full_name">ФИО *</label>
      <input type="text" id="full_name" name="full_name" 
             value="<?php echo htmlspecialchars($c['values']['full_name'] ?? ''); ?>" 
             required maxlength="150" pattern="[а-яА-ЯёЁa-zA-Z\s\-]+">
      <span class="hint">Только буквы, пробелы и дефисы. От 2 до 150 символов.</span>
      <span class="error-message" id="error-full_name"></span>
    </div>

    <div class="form-group">
      <label for="phone">Телефон *</label>
      <input type="tel" id="phone" name="phone" 
             value="<?php echo htmlspecialchars($c['values']['phone'] ?? ''); ?>" 
             required pattern="[\+\d\s\(\)\-]{10,20}">
      <span class="hint">Формат: +7 (123) 456-78-90 (10-20 символов)</span>
      <span class="error-message" id="error-phone"></span>
    </div>

    <div class="form-group">
      <label for="email">E-mail *</label>
      <input type="email" id="email" name="email" 
             value="<?php echo htmlspecialchars($c['values']['email'] ?? ''); ?>" 
             required>
      <span class="hint">Пример: user@domain.com</span>
      <span class="error-message" id="error-email"></span>
    </div>

    <div class="form-group">
      <label for="birth_date">Дата рождения *</label>
      <input type="date" id="birth_date" name="birth_date" 
             value="<?php echo htmlspecialchars($c['values']['birth_date'] ?? ''); ?>" 
             required>
      <span class="hint">Возраст должен быть от 18 до 120 лет</span>
      <span class="error-message" id="error-birth_date"></span>
    </div>

    <div class="form-group">
      <label>Пол *</label>
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
      <span class="error-message" id="error-gender"></span>
    </div>

    <div class="form-group">
      <label for="languages">Любимые языки программирования *</label>
      <select id="languages" name="languages[]" multiple required>
        <?php foreach ($c['languages'] as $lang): ?>
          <option value="<?php echo htmlspecialchars($lang['name']); ?>"
            <?php echo in_array($lang['name'], $c['values']['languages'] ?? []) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($lang['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <span class="hint">Удерживайте Ctrl (Cmd на Mac) для множественного выбора</span>
      <span class="error-message" id="error-languages"></span>
    </div>

    <div class="form-group">
      <label for="biography">Биография</label>
      <textarea id="biography" name="biography" rows="5" 
                maxlength="5000"><?php echo htmlspecialchars($c['values']['biography'] ?? ''); ?></textarea>
      <span class="hint">Необязательно. Максимум 5000 символов.</span>
    </div>

    <div class="form-group checkbox-group">
      <label class="checkbox-label">
        <input type="checkbox" name="contract" value="1" 
               <?php echo !empty($c['values']['contract']) ? 'checked' : ''; ?> required>
        <span>Я ознакомлен(а) с контрактом и согласен(на) с условиями *</span>
      </label>
      <span class="error-message" id="error-contract"></span>
    </div>

    <button type="submit" class="btn-submit">💾 Сохранить</button>
  </form>

  <div id="result-message" class="result-message" style="display: none;"></div>
</div>