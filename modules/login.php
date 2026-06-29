<?php
require_once('db.php');

// Обработчик GET - показать форму входа
function login_get($request) {
  $c = array(
    'title' => 'Вход в систему - CodeCraft Studio',
    'errors' => array(),
    'values' => array(),
  );
  return theme('login', $c);
}

// Обработчик POST - обработка входа
function login_post($request) {
  global $db;
  
  $login = trim($request['post']['login'] ?? '');
  $password = $request['post']['password'] ?? '';
  $errors = array();
  
  if (empty($login)) {
    $errors['login'] = 'Введите логин';
  }
  
  if (empty($password)) {
    $errors['password'] = 'Введите пароль';
  }
  
  if (!empty($errors)) {
    $c = array(
      'title' => 'Вход в систему - CodeCraft Studio',
      'errors' => $errors,
      'values' => $request['post'],
    );
    return theme('login', $c);
  }
  
  // Ищем пользователя в БД
  $stmt = $db->prepare("SELECT id, login, password_hash, email FROM users WHERE login = ?");
  $stmt->execute([$login]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if (!$user || !password_verify($password, $user['password_hash'])) {
    $c = array(
      'title' => 'Вход в систему - CodeCraft Studio',
      'errors' => array('auth' => 'Неверный логин или пароль'),
      'values' => $request['post'],
    );
    return theme('login', $c);
  }
  
  // Успешный вход - создаем сессию
  session_start();
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['login'] = $user['login'];
  $_SESSION['email'] = $user['email'];
  
  // Редирект на главную
  return redirect('');
}