<h1>👑 Админ-панель</h1>

<?php if (!empty($c['applications'])): ?>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Дата рождения</th>
        <th>Пол</th>
        <th>Языки</th>
        <th>Контракт</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($c['applications'] as $app): ?>
        <tr>
          <td><?php echo htmlspecialchars($app['id']); ?></td>
          <td><?php echo htmlspecialchars($app['full_name']); ?></td>
          <td><?php echo htmlspecialchars($app['phone']); ?></td>
          <td><?php echo htmlspecialchars($app['email']); ?></td>
          <td><?php echo htmlspecialchars($app['birth_date']); ?></td>
          <td><?php echo $app['gender'] == 'male' ? 'М' : 'Ж'; ?></td>
          <td>
            <?php foreach ($app['languages'] as $lang): ?>
              <span style="background:#e8f4fd; color:#2196F3; padding:2px 8px; border-radius:12px; font-size:11px; display:inline-block; margin:2px;"><?php echo htmlspecialchars($lang); ?></span>
            <?php endforeach; ?>
          </td>
          <td><?php echo isset($app['contract_agreed']) && $app['contract_agreed'] ? '✅' : '❌'; ?></td>
          <td>
            <form action="/admin/<?php echo $app['id']; ?>" method="POST" style="display:inline;">
              <button type="submit" style="background:#f44336; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;" onclick="return confirm('Удалить заявку #<?php echo $app['id']; ?>?')">🗑️ Удалить</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <p>Нет данных</p>
<?php endif; ?>