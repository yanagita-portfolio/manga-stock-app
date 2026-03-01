<?php
require 'dbconnect.php';

//id取得
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "不正なアクセスです";
    exit;
}

//巻データ取得
$sql = "SELECT * FROM manga_volumes WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$volume = $stmt->fetch();

if (!$volume) {
    echo "データが存在しません";
    exit;
}

//更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $volume_no = $_POST['volume'];
    $purchase_type = $_POST['purchase_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $sql = "UPDATE manga_volumes
            SET volume = :volume,
                purchase_type = :purchase_type,
                price = :price,
                status = :status
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':volume' => $volume_no,
        ':purchase_type' => $purchase_type,
        ':price' => $price,
        ':status' => $status,
        ':id' => $id
    ]);

    // 更新後は一覧へ戻る
    header("Location: volume_list.php?title_id=" . $volume['title_id']);
    exit;
}
?>

<h2>巻編集</h2>

<form method="post">

巻数：
<input type="number" name="volume"
    value="<?= htmlspecialchars($volume['volume']); ?>" required>
<br><br>

購入区分：
<label>
<input type="radio" name="purchase_type" value="new"
<?= $volume['purchase_type'] === 'new' ? 'checked' : '' ?>>
新品
</label>

<label>
<input type="radio" name="purchase_type" value="used"
<?= $volume['purchase_type'] === 'used' ? 'checked' : '' ?>>
中古
</label>
<br><br>

価格：
<input type="number" name="price"
    value="<?= htmlspecialchars($volume['price']); ?>">
<br><br>

所持状況：
<label>
<input type="radio" name="status" value="owned"
<?= $volume['status'] === 'owned' ? 'checked' : '' ?>>
所持
</label>

<label>
<input type="radio" name="status" value="not_owned"
<?= $volume['status'] === 'not_owned' ? 'checked' : '' ?>>
未所持
</label>
<br><br>

<button type="submit">更新</button>

</form>

<br>
<a href="volume_list.php?title_id=<?= $volume['title_id']; ?>">← 戻る</a>