<?php
require_once('db.php');

// Обработчик запросов методом GET.
function front_get($request) {
  // Получаем список языков для формы.
  $languages = db_query("SELECT name FROM programming_languages ORDER BY name");
  
  $c = array(
    'languages' => $languages,
    'title' => 'Анкета разработчика - CodeCraft Studio',
    'values' => array(),
    'errors' => array(),
  );
  
  return theme('form', $c);
}

// Обработчик запросов методом POST.
function front_post($request) {
  // Проверяем, пришел ли JSON
  $isJson = false;
  if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $isJson = true;
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
  } else {
    $data = !empty($request['post']) ? $request['post'] : array();
  }
  
  // Валидация
  $errors = validate_application($data);
  
  if (!empty($errors)) {
    if ($isJson) {
      return array(
        'headers' => array(
          'Content-Type' => 'application/json; charset=utf-8',
          'HTTP/1.1 400 Bad Request'
        ),
        'entity' => json_encode(array('errors' => $errors)),
      );
    } else {
      $languages = db_query("SELECT name FROM programming_languages ORDER BY name");
      $c = array(
        'languages' => $languages,
        'errors' => $errors,
        'values' => $data,
        'title' => 'Анкета разработчика - CodeCraft Studio',
      );
      return theme('form', $c);
    }
  }
  
  // Сохранение данных
  $result = save_application($data);
  
  if ($result['success']) {
    if ($isJson) {
      return array(
        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
        'entity' => json_encode($result),
      );
    } else {
      // Фоллбек - показываем результат в HTML
      return '<div style="background:#dcfce7;padding:2rem;border-radius:1rem;margin:2rem auto;max-width:600px;">
        <h2 style="color:#166534;">✅ Регистрация успешна!</h2>
        <p>Сохраните ваши данные для входа:</p>
        <div style="background:white;padding:1rem;border-radius:0.5rem;margin:1rem 0;font-family:monospace;">
          <p><strong>🔑 Логин:</strong> ' . htmlspecialchars($result['login']) . '</p>
          <p><strong>🔒 Пароль:</strong> ' . htmlspecialchars($result['password']) . '</p>
        </div>
        <p>📍 Адрес профиля: <a href="' . htmlspecialchars($result['profile_url']) . '">' . htmlspecialchars($result['profile_url']) . '</a></p>
      </div>';
    }
  } else {
    if ($isJson) {
      return array(
        'headers' => array(
          'Content-Type' => 'application/json; charset=utf-8',
          'HTTP/1.1 500 Internal Server Error'
        ),
        'entity' => json_encode(array('error' => $result['error'])),
      );
    } else {
      return '<div style="background:#fef2f2;padding:2rem;border-radius:1rem;margin:2rem auto;max-width:600px;">
        <h2 style="color:#991b1b;">❌ Ошибка</h2>
        <p>' . htmlspecialchars($result['error']) . '</p>
      </div>';
    }
  }
}

function validate_application($data) {
  $errors = array();
  
  if (empty($data['full_name']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]{2,150}$/u', $data['full_name'])) {
    $errors['full_name'] = 'ФИО: только буквы, пробелы и дефисы (2-150 символов)';
  }
  
  if (empty($data['phone']) || !preg_match('/^[\+\d\s\(\)\-]{10,20}$/', $data['phone'])) {
    $errors['phone'] = 'Неверный формат телефона';
  }
  
  if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Неверный формат email';
  }
  
  if (empty($data['birth_date'])) {
    $errors['birth_date'] = 'Укажите дату рождения';
  } else {
    $date = DateTime::createFromFormat('Y-m-d', $data['birth_date']);
    if (!$date) {
      $errors['birth_date'] = 'Неверный формат даты';
    } else {
      $age = date_diff($date, new DateTime())->y;
      if ($age < 18 || $age > 120) {
        $errors['birth_date'] = 'Возраст от 18 до 120 лет';
      }
    }
  }
  
  if (empty($data['gender']) || !in_array($data['gender'], array('male', 'female'))) {
    $errors['gender'] = 'Выберите пол';
  }
  
  if (empty($data['languages']) || !is_array($data['languages'])) {
    $errors['languages'] = 'Выберите хотя бы один язык';
  }
  
  if (empty($data['contract'])) {
    $errors['contract'] = 'Подтвердите ознакомление с контрактом';
  }
  
  return $errors;
}

function save_application($data) {
  global $db;
  
  try {
    $db->beginTransaction();
    
    // Генерируем логин и пароль
    $login = 'user_' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < 8; $i++) {
      $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Создаем пользователя
    db_command("INSERT INTO users (login, password_hash, email) VALUES (?, ?, ?)", 
      $login, $password_hash, $data['email']);
    $user_id = db_insert_id();
    
    // Создаем заявку
    db_command("INSERT INTO applications (user_id, full_name, phone, email, birth_date, gender, biography, contract_agreed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
      $user_id, $data['full_name'], $data['phone'], $data['email'], $data['birth_date'], 
      $data['gender'], $data['biography'] ?? '', isset($data['contract']) ? 1 : 0);
    $app_id = db_insert_id();
    
    // Сохраняем языки
    foreach ($data['languages'] as $lang) {
      $lang_id = db_result("SELECT id FROM programming_languages WHERE name = ?", $lang);
      if ($lang_id) {
        db_command("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)", 
          $app_id, $lang_id);
      }
    }
    
    $db->commit();
    
    return array(
      'success' => true,
      'login' => $login,
      'password' => $password,
      'profile_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/webback-8/api/applications/' . $app_id,
    );
  }
  catch (PDOException $e) {
    $db->rollBack();
    return array('success' => false, 'error' => $e->getMessage());
  }
}
?>