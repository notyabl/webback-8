document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('application-form');
  if (!form) return;

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Очищаем ошибки.
    clearErrors();
    
    // Собираем данные формы.
    const formData = new FormData(form);
    const data = {
      full_name: formData.get('full_name'),
      phone: formData.get('phone'),
      email: formData.get('email'),
      birth_date: formData.get('birth_date'),
      gender: formData.get('gender'),
      biography: formData.get('biography'),
      contract: formData.get('contract'),
      languages: formData.getAll('languages[]'),
    };
    
    // Клиентская валидация.
    const errors = validateForm(data);
    if (Object.keys(errors).length > 0) {
      showErrors(errors);
      return;
    }
    
    // Отправляем через Fetch API.
    fetch('/', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        showResult(`
          <div class="success-box">
            <h3>✅ Регистрация успешна!</h3>
            <p>Сохраните ваши данные для входа:</p>
            <div class="credentials">
              <p><strong>Логин:</strong> ${result.login}</p>
              <p><strong>Пароль:</strong> ${result.password}</p>
            </div>
            <p>Адрес профиля: <a href="${result.profile_url}">${result.profile_url}</a></p>
          </div>
        `);
        form.reset();
      } else {
        showResult(`<div class="error-box"><p> Ошибка: ${result.error}</p></div>`);
      }
    })
    .catch(error => {
      // Фоллбек: если JS не работает, отправляем форму обычно.
      form.submit();
    });
  });
  
  function validateForm(data) {
    const errors = {};
    
    if (!data.full_name || !/^[а-яА-ЯёЁa-zA-Z\s\-]{2,150}$/u.test(data.full_name)) {
      errors.full_name = 'ФИО: только буквы, пробелы и дефисы (2-150 символов)';
    }
    
    if (!data.phone || !/^[\+\d\s\(\)\-]{10,20}$/.test(data.phone)) {
      errors.phone = 'Неверный формат телефона';
    }
    
    if (!data.email || !/^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/.test(data.email)) {
      errors.email = 'Неверный формат email';
    }
    
    if (!data.birth_date) {
      errors.birth_date = 'Укажите дату рождения';
    } else {
      const date = new Date(data.birth_date);
      const age = Math.floor((new Date() - date) / (365.25 * 24 * 60 * 60 * 1000));
      if (age < 18 || age > 120) {
        errors.birth_date = 'Возраст от 18 до 120 лет';
      }
    }
    
    if (!data.gender) {
      errors.gender = 'Выберите пол';
    }
    
    if (!data.languages || data.languages.length === 0) {
      errors.languages = 'Выберите хотя бы один язык';
    }
    
    if (!data.contract) {
      errors.contract = 'Подтвердите ознакомление с контрактом';
    }
    
    return errors;
  }
  
  function showErrors(errors) {
    for (const field in errors) {
      const errorEl = document.getElementById(`error-${field}`);
      if (errorEl) {
        errorEl.textContent = errors[field];
        errorEl.style.display = 'block';
      }
      const input = form.querySelector(`[name="${field}"]`);
      if (input) {
        input.classList.add('error');
      }
    }
  }
  
  function clearErrors() {
    document.querySelectorAll('.error-message').forEach(el => {
      el.textContent = '';
      el.style.display = 'none';
    });
    document.querySelectorAll('.error').forEach(el => {
      el.classList.remove('error');
    });
  }
  
  function showResult(html) {
    const resultEl = document.getElementById('result-message');
    resultEl.innerHTML = html;
    resultEl.style.display = 'block';
    resultEl.scrollIntoView({ behavior: 'smooth' });
  }
});