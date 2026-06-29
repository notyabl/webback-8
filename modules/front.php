<?php
require_once('db.php');

function front_get($request) {
  $languages = db_query("SELECT name FROM programming_languages ORDER BY name");
  $c = array(
    'languages' => $languages,
    'title' => 'Анкета разработчика - CodeCraft Studio',
    'values' => array(),
    'errors' => array(),
  );
  return theme('form', $c);
}

function front_post($request) {
  $errors = validate_application($request['post']);
  
  if (!empty($errors)) {
    $languages = db_query("SELECT name FROM programming_languages ORDER BY name");
    $c = array(
      'languages' => $languages,
      'errors' => $errors,
      'values' => $request['post'],
      'title' => 'Анкета разработчика - CodeCraft Studio',
    );
    return theme('form', $c);
  }
  
  $result = save_application($request['post']);
  
  if ($result['success']) {
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($result);
  }
  else {
    header('Content-Type: application/json; charset=utf-8');
    return json_encode(array('error' => 'Ошибка сохранения'));
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
    
    $login = 'user_' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < 8; $i++) {
      $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    db_command("INSERT INTO users (login, password_hash, email) VALUES (?, ?, ?)", 
      $login, $password_hash, $data['email']);
    $user_id = db_insert_id();
    
    db_command("INSERT INTO applications (user_id, full_name, phone, email, birth_date, gender, biography, contract_agreed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
      $user_id, $data['full_name'], $data['phone'], $data['email'], $data['birth_date'], 
      $data['gender'], $data['biography'] ?? '', isset($data['contract']) ? 1 : 0);
    $app_id = db_insert_id();
    
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