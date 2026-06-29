<?php
require_once('db.php');

function profile_get($request) {
  global $db;
  
  session_start();
  
  // Проверяем авторизацию
  if (!isset($_SESSION['user_id'])) {
    return redirect('login');
  }
  
  $user_id = $_SESSION['user_id'];
  
  // Получаем данные пользователя
  $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if (!$user) {
    return redirect('logout');
  }
  
  // Получаем последнюю заявку пользователя
  $stmt = $db->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY id DESC LIMIT 1");
  $stmt->execute([$user_id]);
  $application = $stmt->fetch(PDO::FETCH_ASSOC);
  
  // Получаем языки
  $languages = array();
  if ($application) {
    $stmt = $db->prepare("SELECT pl.name FROM application_languages al JOIN programming_languages pl ON al.language_id = pl.id WHERE al.application_id = ?");
    $stmt->execute([$application['id']]);
    $languages = $stmt->fetchAll(PDO::FETCH_COLUMN);
  }
  
  $c = array(
    'title' => 'Личный кабинет - CodeCraft Studio',
    'user' => $user,
    'application' => $application,
    'languages' => $languages,
    'errors' => array(),
    'success' => '',
  );
  
  return theme('profile', $c);
}

function profile_post($request) {
  global $db;
  
  session_start();
  
  if (!isset($_SESSION['user_id'])) {
    return redirect('login');
  }
  
  $user_id = $_SESSION['user_id'];
  $errors = array();
  
  // Валидация
  $email = trim($request['post']['email'] ?? '');
  $full_name = trim($request['post']['full_name'] ?? '');
  $phone = trim($request['post']['phone'] ?? '');
  $birth_date = $request['post']['birth_date'] ?? '';
  $gender = $request['post']['gender'] ?? '';
  $biography = trim($request['post']['biography'] ?? '');
  
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Введите корректный email';
  }
  
  if (empty($full_name) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]{2,150}$/u', $full_name)) {
    $errors['full_name'] = 'ФИО: только буквы, пробелы и дефисы (2-150 символов)';
  }
  
  if (empty($phone) || !preg_match('/^[\+\d\s\(\)\-]{10,20}$/', $phone)) {
    $errors['phone'] = 'Неверный формат телефона';
  }
  
  if (empty($birth_date)) {
    $errors['birth_date'] = 'Укажите дату рождения';
  }
  
  if (empty($gender) || !in_array($gender, array('male', 'female'))) {
    $errors['gender'] = 'Выберите пол';
  }
  
  if (!empty($errors)) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $db->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$user_id]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $languages = array();
    if ($application) {
      $stmt = $db->prepare("SELECT pl.name FROM application_languages al JOIN programming_languages pl ON al.language_id = pl.id WHERE al.application_id = ?");
      $stmt->execute([$application['id']]);
      $languages = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    $c = array(
      'title' => 'Личный кабинет - CodeCraft Studio',
      'user' => $user,
      'application' => $application,
      'languages' => $languages,
      'errors' => $errors,
      'success' => '',
    );
    
    return theme('profile', $c);
  }
  
  // Обновляем данные
  try {
    $db->beginTransaction();
    
    // Обновляем email пользователя
    db_command("UPDATE users SET email = ? WHERE id = ?", $email, $user_id);
    
    // Получаем или создаем заявку
    $stmt = $db->prepare("SELECT id FROM applications WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$user_id]);
    $app = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($app) {
      // Обновляем существующую заявку
      db_command("UPDATE applications SET full_name=?, phone=?, email=?, birth_date=?, gender=?, biography=? WHERE id=?",
        $full_name, $phone, $email, $birth_date, $gender, $biography, $app['id']);
      $app_id = $app['id'];
      
      // Удаляем старые языки
      db_command("DELETE FROM application_languages WHERE application_id = ?", $app_id);
    } else {
      // Создаем новую заявку
      db_command("INSERT INTO applications (user_id, full_name, phone, email, birth_date, gender, biography, contract_agreed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        $user_id, $full_name, $phone, $email, $birth_date, $gender, $biography, 1);
      $app_id = db_insert_id();
    }
    
    // Сохраняем языки (если пришли из формы)
    if (!empty($request['post']['languages']) && is_array($request['post']['languages'])) {
      foreach ($request['post']['languages'] as $lang) {
        $lang_id = db_result("SELECT id FROM programming_languages WHERE name = ?", $lang);
        if ($lang_id) {
          db_command("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)", 
            $app_id, $lang_id);
        }
      }
    }
    
    $db->commit();
    
    // Перезагружаем страницу с сообщением об успехе
    $_SESSION['profile_success'] = 'Данные успешно обновлены!';
    return redirect('profile');
    
  } catch (PDOException $e) {
    $db->rollBack();
    
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $db->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$user_id]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $languages = array();
    if ($application) {
      $stmt = $db->prepare("SELECT pl.name FROM application_languages al JOIN programming_languages pl ON al.language_id = pl.id WHERE al.application_id = ?");
      $stmt->execute([$application['id']]);
      $languages = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    $c = array(
      'title' => 'Личный кабинет - CodeCraft Studio',
      'user' => $user,
      'application' => $application,
      'languages' => $languages,
      'errors' => array('db' => 'Ошибка сохранения: ' . $e->getMessage()),
      'success' => '',
    );
    
    return theme('profile', $c);
  }
}
?>