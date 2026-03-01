<?php
require 'dbconnect.php';

try {
    $title_id = $_POST['title_id'] ?? null;
    $del = $_POST['del'] ?? [];

    if (!empty($del)) {
        foreach ($del as $delno) {
            $sql = $pdo->prepare('DELETE FROM manga_volumes WHERE id=?');
            $sql->bindParam(1, $delno, PDO::PARAM_INT);
            $sql->execute();
        }
    }
} catch (PDOException $e) {
    echo ('エラーメッセージ：' . $e->getMessage());
    exit;
}

header("location: ./volume_list.php?title_id=" . $_POST['title_id']);

exit;
