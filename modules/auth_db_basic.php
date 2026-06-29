<?php
// Авторизация из БД для API.
function auth(&$request, $r) {
  global $db;
  
  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    return array(
      'headers' => array(
        sprintf('WWW-Authenticate: Basic realm="%s"', conf('sitename')),
        'HTTP/1.0 401 Unauthorized'
      ),
      'entity' => json_encode(array('error' => 'Требуется авторизация')),
    );
  }
  
  $login = $_SERVER['PHP_AUTH_USER'];
  $password = $_SERVER['PHP_AUTH_PW'];
  
  $stmt = $db->prepare("SELECT id, login, password_hash FROM users WHERE login = ?");
  $stmt->execute([$login]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if (!$user || !password_verify($password, $user['password_hash'])) {
    return array(
      'headers' => array(
        sprintf('WWW-Authenticate: Basic realm="%s"', conf('sitename')),
        'HTTP/1.0 401 Unauthorized'
      ),
      'entity' => json_encode(array('error' => 'Неверный логин или пароль')),
    );
  }
  
  $request['user'] = $user;
  return NULL;
}