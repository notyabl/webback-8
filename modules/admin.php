<?php
// Подключаем работу с БД
require_once('db.php');

// Обработчик запросов методом GET.
function admin_get($request) {
  global $db;
  
  // Получаем все заявки из БД
  $applications = db_query("SELECT * FROM applications ORDER BY id DESC");
  
  // Получаем языки для каждой заявки
  foreach ($applications as &$app) {
    $stmt = $db->prepare("SELECT pl.name FROM application_languages al JOIN programming_languages pl ON al.language_id = pl.id WHERE al.application_id = ?");
    $stmt->execute([$app['id']]);
    $app['languages'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
  }
  
  return theme('admin', ['applications' => $applications]);
}

// Обработчик запросов методом POST.
function admin_post($request, $id = null) {
  global $db;
  
  if ($id) {
    $id = (int)$id;
    // Удаляем заявку
    $db->prepare("DELETE FROM application_languages WHERE application_id = ?")->execute([$id]);
    $db->prepare("DELETE FROM applications WHERE id = ?")->execute([$id]);
  }
  
  return redirect('admin');
}