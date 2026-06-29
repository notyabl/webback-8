<?php
include('./settings.php');
// Выключаем отображение ошибок после отладки.
ini_set('display_errors', DISPLAY_ERRORS);
// Папки со скриптами и модулями.
ini_set('include_path', INCLUDE_PATH);
include('init.php');

// Определяем метод запроса
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST' && !empty($_POST['method'])) {
  $method = strtoupper($_POST['method']);
}

$request = array(
  'url' => isset($_GET['q']) ? $_GET['q'] : '',
  'method' => strtolower($method),
  'get' => !empty($_GET) ? $_GET : array(),
  'post' => !empty($_POST) ? $_POST : array(),
  'Content-Type' => 'text/html',
);

// Читаем JSON тело для PUT/POST запросов
if ($method == 'PUT' || $method == 'DELETE') {
  $raw = file_get_contents('php://input');
  $request['json'] = json_decode($raw, true);
}

$response = init($request, $urlconf);

if (!empty($response['headers'])) {
  foreach ($response['headers'] as $key => $value) {
    if (is_string($key)) {
      header(sprintf('%s: %s', $key, $value));
    }
    else {
      header($value);
    }
  }
}

if (!empty($response['entity'])) {
  print($response['entity']);
}