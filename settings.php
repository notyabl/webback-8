<?php
// Выключаем отображение ошибок после отладки.
define('DISPLAY_ERRORS', 1);
// Папки со скриптами и модулями.
define('INCLUDE_PATH', './scripts' . PATH_SEPARATOR . './modules');

$conf = array(
  'sitename' => 'CodeCraft Studio',
  'theme' => './theme',
  'charset' => 'UTF-8',
  'clean_urls' => TRUE,
  'display_errors' => 1,
  'date_format' => 'Y.m.d',
  'date_format_2' => 'Y.m.d H:i',
  'date_format_3' => 'd.m.Y',
  'basedir' => '/',
  'login' => 'admin',
  'password' => '123',
  'admin_mail' => 'student@kubsu.ru',
  // Настройки БД
  'db_host' => 'localhost',
  'db_name' => 'u82291',
  'db_user' => 'u82291',
  'db_psw' => '7595792',
);

// Определения ресурсов для диспатчера.
$urlconf = array(
  '' => array('module' => 'front'),
  '/^api\/applications$/' => array('module' => 'api'),
  '/^api\/applications\/(\d+)$/' => array('module' => 'api'),
  '/^admin$/' => array('module' => 'admin', 'auth' => 'auth_basic'),
  '/^admin\/(\d+)$/' => array('module' => 'admin', 'auth' => 'auth_basic'),
);

// Отрубаем кеш.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
// Выдаем кодировку.
header('Content-Type: text/html; charset=' . $conf['charset']);
?>