<?php
require 'dbconnect.php';

//URLからtitle_id取得
$title_id = $_GET['title_id'] ?? null;

if (!$title_id) {
	echo "不正なアクセスです";
	exit;
}

//タイトル取得
$sql = "SELECT * FROM manga_titles WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $title_id]);
$title = $stmt->fetch();

if (!$title) {
	echo "タイトルが存在しません";
	exit;
}

//巻データ取得
$sql = "SELECT * FROM manga_volumes WHERE title_id = :title_id ORDER BY volume ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':title_id' => $title_id]);
$volumes = $stmt->fetchAll();
?>

<h2><?php echo htmlspecialchars($title['title']); ?> 巻一覧</h2>

<a href="volume_create.php?title_id=<?php echo $title_id; ?>">
	巻を追加へ
</a>

<br><br>
<form method="POST" action="volume_del.php">
	<input type="hidden" name="title_id" value="<?php echo $title_id; ?>">
	<table border="1" cellpadding="5">
		<tr>
			<th>巻数</th>
			<th>購入区分</th>
			<th>価格</th>
			<th>所持状況</th>
			<th></th>
			<th>削除</th>
		</tr>

		<?php foreach ($volumes as $volume):
			// purchase_typeの表示替え
			$purchaseLabels = [
				'new' => '新品',
				'used' => '中古'
			];
			$purchase_type = $purchaseLabels[$volume['purchase_type']] ?? '';

			$statusLabels = [
				'owned' => '所持',
				'not_owned' => '未所持'
			];
			$status = $statusLabels[$volume['status']] ?? '';
		?>
			<tr>
				<td><?php echo $volume['volume']; ?>巻</td>
				<td><?php echo $purchase_type; ?></td>
				<td><?php echo $volume['price']; ?>円</td>
				<td><?php echo $status; ?></td>
				<td><a href="volume_edit.php?id=<?php echo $volume['id']; ?>"><button type="button">編集</button></a></td>
				<td class="cen"><input type="checkbox" name="del[]" value="<?php echo ($volume['id']); ?>"></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<p><input type="submit" value="削除"></p>
</form>

<a href="title_list.php">← タイトル一覧へ戻る</a>