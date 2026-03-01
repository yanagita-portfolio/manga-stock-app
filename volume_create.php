<?php
require 'dbconnect.php';

//title_id取得
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

//登録処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $volume = $_POST['volume'];
    $purchase_type = $_POST['purchase_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $sql = "INSERT INTO manga_volumes 
            (title_id, volume, purchase_type, price, status)
            VALUES 
            (:title_id, :volume, :purchase_type, :price, :status)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title_id' => $title_id,
        ':volume' => $volume,
        ':purchase_type' => $purchase_type,
        ':price' => $price,
        ':status' => $status
    ]);

    // 登録後は巻一覧へ戻る
    header("Location: volume_list.php?title_id=" . $title_id);
    exit;
}
?>

<h2><?php echo htmlspecialchars($title['title']); ?> 巻登録</h2>

<form method="post">

巻数：
<input type="number" name="volume" required>
<br><br>

購入区分：
<input type="radio" name="purchase_type" value="new" required>新品
<input type="radio" name="purchase_type" value="used">中古
<br><br>

価格：
<input type="number" name="price">
<br><br>

所持状況：
<input type="radio" name="status" value="owned" required>所持
<input type="radio" name="status" value="not_owned">未所持
<br><br>

<button type="submit">登録</button>

</form>

<a href="volume_list.php?title_id=<?php echo $title_id; ?>">← 戻る</a>