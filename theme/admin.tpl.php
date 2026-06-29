<div style="max-width:1200px;margin:100px auto 20px;padding:20px;background:white;border-radius:15px;">
<h1 style="color:#667eea;margin-bottom:20px;">👑 Админ-панель</h1>

<?php if (!empty($c['applications'])): ?>
<table style="width:100%;border-collapse:collapse;">
<thead>
<tr style="background:#667eea;color:white;">
<th style="padding:12px;text-align:left;">ID</th>
<th style="padding:12px;text-align:left;">ФИО</th>
<th style="padding:12px;text-align:left;">Телефон</th>
<th style="padding:12px;text-align:left;">Email</th>
<th style="padding:12px;text-align:left;">Языки</th>
<th style="padding:12px;text-align:left;">Контракт</th>
<th style="padding:12px;text-align:left;">Действия</th>
</tr>
</thead>
<tbody>
<?php foreach ($c['applications'] as $app): ?>
<tr style="border-bottom:1px solid #ddd;">
<td style="padding:12px;"><?php echo htmlspecialchars($app['id']); ?></td>
<td style="padding:12px;"><?php echo htmlspecialchars($app['full_name']); ?></td>
<td style="padding:12px;"><?php echo htmlspecialchars($app['phone']); ?></td>
<td style="padding:12px;"><?php echo htmlspecialchars($app['email']); ?></td>
<td style="padding:12px;">
<?php foreach ($app['languages'] as $lang): ?>
<span style="background:#e8f4fd;color:#2196F3;padding:2px 8px;border-radius:12px;font-size:11px;margin:2px;display:inline-block;"><?php echo htmlspecialchars($lang); ?></span>
<?php endforeach; ?>
</td>
<td style="padding:12px;"><?php echo isset($app['contract_agreed']) && $app['contract_agreed'] ? '✅' : '❌'; ?></td>
<td style="padding:12px;">
<form action="admin/<?php echo $app['id']; ?>" method="POST" style="display:inline;">
<button type="submit" style="background:#f44336;color:white;border:none;padding:5px 10px;border-radius:5px;cursor:pointer;" onclick="return confirm('Удалить заявку #<?php echo $app['id']; ?>?')">🗑️ Удалить</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p>Нет данных</p>
<?php endif; ?>
</div>