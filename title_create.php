<?php
require 'dbconnect.php';
// 登録ボタンが押されたとき
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];

    if (!empty($title)) {

        $sql = "INSERT INTO manga_titles (title) VALUES (:title)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':title' => $title]);

        header("Location: title_list.php");
        exit;
    }
}
?>

<h2>新規漫画登録</h2>
<form method="post">
  タイトル：<input type="text" name="title" required><br><br>
  <button type="submit">登録</button>
</form>
