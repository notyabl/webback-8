<?php
// Подключаем работу с БД
require_once('db.php');

// Обработчик запросов методом GET.
function front_get($request) {
  // Получаем список языков для формы
  $languages = db_query("SELECT name FROM programming_languages ORDER BY name");
  
  $c = array(
    'languages' => $languages,
    'title' => 'Анкета разработчика',
  );
  
  return theme('form', $c);
}

// Обработчик запросов методом POST (фоллбек без JS).
function front_post($request) {
  // Валидация и сохранение данных.
  $errors = validate_application($request['post']);
  
  if (!empty($errors)) {
    // Возвращаем форму с ошибками.
    global $db;
    $languages = db_query("SELECT name FROM programming_languages ORDER BY name");
    $c = array(
      'languages' => $languages,
      'errors' => $errors,
      'values' => $request['post'],
      'title' => 'Анкета разработчика',
    );
    return theme('form', $c);
  }
  
  // Сохраняем данные.
  $result = save_application($request['post']);
  
  if ($result['success']) {
    // Возвращаем JSON с логином и паролем.
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($result);
  }
  else {
    header('Content-Type: application/json; charset=utf-8');
    return json_encode(array('error' => 'Ошибка сохранения'));
  }
}

// Валидация данных заявки.
function validate_application($data) {
  $errors = array();
  
  // ФИО
  if (empty($data['full_name']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]{2,150}$/u', $data['full_name'])) {
    $errors['full_name'] = 'ФИО: только буквы, пробелы и дефисы (2-150 символов)';
  }
  
  // Телефон
  if (empty($data['phone']) || !preg_match('/^[\+\d\s\(\)\-]{10,20}$/', $data['phone'])) {
    $errors['phone'] = 'Неверный формат телефона';
  }
  
  // Email
  if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Неверный формат email';
  }
  
  // Дата рождения
  if (empty($data['birth_date'])) {
    $errors['birth_date'] = 'Укажите дату рождения';
  }
  else {
    $date = DateTime::createFromFormat('Y-m-d', $data['birth_date']);
    if (!$date) {
      $errors['birth_date'] = 'Неверный формат даты';
    }
    else {
      $age = date_diff($date, new DateTime())->y;
      if ($age < 18 || $age > 120) {
        $errors['birth_date'] = 'Возраст от 18 до 120 лет';
      }
    }
  }
  
  // Пол
  if (empty($data['gender']) || !in_array($data['gender'], array('male', 'female'))) {
    $errors['gender'] = 'Выберите пол';
  }
  
  // Языки
  if (empty($data['languages']) || !is_array($data['languages'])) {
    $errors['languages'] = 'Выберите хотя бы один язык';
  }
  
  // Контракт
  if (empty($data['contract'])) {
    $errors['contract'] = 'Подтвердите ознакомление с контрактом';
  }
  
  return $errors;
}

// Сохранение заявки.
function save_application($data) {
  global $db;
  
  try {
    $db->beginTransaction();
    
    // Генерируем логин и пароль.
    $login = 'user_' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < 8; $i++) {
      $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Создаем пользователя.
    $stmt = $db->prepare("INSERT INTO users (login, password_hash, email) VALUES (?, ?, ?)");
    $stmt->execute([$login, $password_hash, $data['email']]);
    $user_id = db_insert_id();
    
    // Создаем заявку.
    $stmt = $db->prepare("INSERT INTO applications (user_id, full_name, phone, email, birth_date, gender, biography, contract_agreed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
      $user_id,
      $data['full_name'],
      $data['phone'],
      $data['email'],
      $data['birth_date'],
      $data['gender'],
      $data['biography'] ?? '',
      isset($data['contract']) ? 1 : 0
    ]);
    $app_id = db_insert_id();
    
    // Сохраняем языки.
    $langStmt = $db->prepare("SELECT id FROM programming_languages WHERE name = ?");
    $insertLang = $db->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
    foreach ($data['languages'] as $lang) {
      $langStmt->execute([$lang]);
      $langData = $langStmt->fetch();
      if ($langData) {
        $insertLang->execute([$app_id, $langData['id']]);
      }
    }
    
    $db->commit();
    
    return array(
      'success' => true,
      'login' => $login,
      'password' => $password,
      'profile_url' => 'http://' . $_SERVER['HTTP_HOST'] . conf('basedir') . 'api/applications/' . $app_id,
    );
  }
  catch (PDOException $e) {
    $db->rollBack();
    return array('success' => false, 'error' => $e->getMessage());
  }
}