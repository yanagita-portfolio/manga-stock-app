<?php
require 'dbconnect.php';
// 入力されているタイトルを全て読み込む
	$sql = "SELECT * FROM manga_titles ORDER BY created_at DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(); 
  $titles = $stmt ->fetchAll();
?>

<h2>漫画タイトル一覧</h2>

<a href="title_create.php">新規登録へ</a>
<br><br>

<ul>
<?php foreach ($titles as $title): ?>
    <li>
        <a href="volume_list.php?title_id=<?php echo $title['id']; ?>">
            <?php echo htmlspecialchars($title['title']); ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
