<?php
// REST API для заявок.

// GET /api/applications/{id} - получение данных заявки.
function api_get($request, $id = NULL) {
  global $db;
  
  if ($id) {
    // Получаем заявку по ID.
    $stmt = $db->prepare("SELECT * FROM applications WHERE id = ?");
    $stmt->execute([$id]);
    $app = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$app) {
      return array(
        'headers' => array('HTTP/1.1 404 Not Found', 'Content-Type: application/json'),
        'entity' => json_encode(array('error' => 'Заявка не найдена')),
      );
    }
    
    // Получаем языки.
    $langStmt = $db->prepare("SELECT pl.name FROM application_languages al JOIN programming_languages pl ON al.language_id = pl.id WHERE al.application_id = ?");
    $langStmt->execute([$id]);
    $app['languages'] = $langStmt->fetchAll(PDO::FETCH_COLUMN);
    
    return array(
      'headers' => array('Content-Type: application/json'),
      'entity' => json_encode($app, JSON_UNESCAPED_UNICODE),
    );
  }
  
  return not_found();
}

// POST /api/applications - создание новой заявки.
function api_post($request) {
  // Читаем JSON или form-data.
  $data = !empty($request['json']) ? $request['json'] : $request['post'];
  
  // Валидация.
  $errors = validate_application($data);
  if (!empty($errors)) {
    return array(
      'headers' => array('HTTP/1.1 400 Bad Request', 'Content-Type: application/json'),
      'entity' => json_encode(array('errors' => $errors), JSON_UNESCAPED_UNICODE),
    );
  }
  
  // Сохранение.
  $result = save_application($data);
  
  if ($result['success']) {
    return array(
      'headers' => array('Content-Type: application/json'),
      'entity' => json_encode($result, JSON_UNESCAPED_UNICODE),
    );
  }
  else {
    return array(
      'headers' => array('HTTP/1.1 500 Internal Server Error', 'Content-Type: application/json'),
      'entity' => json_encode(array('error' => $result['error']), JSON_UNESCAPED_UNICODE),
    );
  }
}

// PUT /api/applications/{id} - обновление заявки (требует авторизации).
function api_put($request, $id) {
  global $db;
  
  // Пользователь уже авторизован через auth_db_basic.
  $user = $request['user'];
  
  // Проверяем, что заявка принадлежит пользователю.
  $stmt = $db->prepare("SELECT * FROM applications WHERE id = ? AND user_id = ?");
  $stmt->execute([$id, $user['id']]);
  $app = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if (!$app) {
    return array(
      'headers' => array('HTTP/1.1 404 Not Found', 'Content-Type: application/json'),
      'entity' => json_encode(array('error' => 'Заявка не найдена')),
    );
  }
  
  // Читаем данные.
  $data = !empty($request['json']) ? $request['json'] : $request['post'];
  
  // Валидация.
  $errors = validate_application($data);
  if (!empty($errors)) {
    return array(
      'headers' => array('HTTP/1.1 400 Bad Request', 'Content-Type: application/json'),
      'entity' => json_encode(array('errors' => $errors), JSON_UNESCAPED_UNICODE),
    );
  }
  
  try {
    $db->beginTransaction();
    
    // Обновляем заявку.
    $stmt = $db->prepare("UPDATE applications SET full_name=?, phone=?, email=?, birth_date=?, gender=?, biography=?, contract_agreed=? WHERE id=? AND user_id=?");
    $stmt->execute([
      $data['full_name'],
      $data['phone'],
      $data['email'],
      $data['birth_date'],
      $data['gender'],
      $data['biography'] ?? '',
      isset($data['contract']) ? 1 : 0,
      $id,
      $user['id']
    ]);
    
    // Удаляем старые языки.
    $db->prepare("DELETE FROM application_languages WHERE application_id = ?")->execute([$id]);
    
    // Вставляем новые языки.
    $langStmt = $db->prepare("SELECT id FROM programming_languages WHERE name = ?");
    $insertLang = $db->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
    foreach ($data['languages'] as $lang) {
      $langStmt->execute([$lang]);
      $langData = $langStmt->fetch();
      if ($langData) {
        $insertLang->execute([$id, $langData['id']]);
      }
    }
    
    $db->commit();
    
    return array(
      'headers' => array('Content-Type: application/json'),
      'entity' => json_encode(array('success' => true, 'message' => 'Данные обновлены'), JSON_UNESCAPED_UNICODE),
    );
  }
  catch (PDOException $e) {
    $db->rollBack();
    return array(
      'headers' => array('HTTP/1.1 500 Internal Server Error', 'Content-Type: application/json'),
      'entity' => json_encode(array('error' => $e->getMessage()), JSON_UNESCAPED_UNICODE),
    );
  }
}