# 漫画在庫管理アプリ（manga-stock-app）

## ■ 概要
PHP（PDO）とMySQLを用いて開発した漫画在庫管理アプリです。  
タイトル単位で管理し、各巻の購入状態や価格を登録・編集・削除できるCRUDアプリケーションです。

データベース設計から画面実装まで一貫して行い、
「安全にデータを扱うWebアプリケーションの基礎を理解すること」を目的に制作しました。

---

## ■ 制作背景
PHP基礎学習後、単なる文法理解で終わらせず、

- データベース設計
- セキュアなデータ処理
- 実用性を意識したUI設計
を意識したアプリケーションを一から構築することを目標に開発しました。

---

## ■ 使用技術
- PHP
- MySQL
- PDO
- HTML
- Git / GitHub

---

## ■ 主な機能

### 【タイトル管理】
- タイトル登録（CREATE）
- タイトル一覧表示（READ）

### 【巻管理】
- 巻登録（CREATE）
- 巻一覧表示（READ）
- 巻編集（UPDATE）
- 巻削除（DELETE）

---

## ■ 工夫した点（アピールポイント）

### ① SQLインジェクション対策
PDOのプリペアドステートメントを使用し、安全にSQLを実行。

### ② XSS対策
出力時にhtmlspecialcharsを使用。

### ③ 不正アクセス制御
GETパラメータ未指定時のアクセス制御を実装。

### ④ データと表示の分離
purchase_type（new / used）を日本語表示へ変換するラベル処理を実装。

```php
$purchaseLabels = [
    'new' => '新品',
    'used' => '中古'
];

---

## ■ データベース設計
本アプリは以下の2テーブル構成です。
manga_title（タイトル管理）
manga_volumes（巻管理）
manga_title と manga_volumes は
1対多（1タイトルに複数巻） のリレーション構造です。

### ● manga_title
| カラム名       | 型        | 説明    |
| ---------- | -------- | ----- |
| id         | INT      | 主キー   |
| title      | VARCHAR  | タイトル名 |
| created_at | DATETIME | 作成日時  |

### ● manga_volumes
| カラム名          | 型        | 説明         |
| ------------- | -------- | ---------- |
| id            | INT      | 主キー        |
| title_id      | INT      | 外部キー       |
| volume        | INT      | 巻数         |
| purchase_type | VARCHAR  | new / used |
| price         | INT      | 価格         |
| status        | VARCHAR  | 所持状況       |
| created_at    | DATETIME | 作成日時       |

---

## ■ 今後の改善予定
- デザイン改善（Bootstrap導入）
- MVC構造へのリファクタリング
- バリデーション強化
- デプロイ対応

---

## ■ 開発環境
- XAMPP
- Windows
- GitHub管理
