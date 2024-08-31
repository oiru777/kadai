<DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Twitter風アプリ</title>
</head>
<body>
    <div>
        <?php
            session_start();
            //db接続
            try {
                $pdo = new PDO('mysql:dbname=twiiterdb;host=localhost;port=8889;charset=utf8', 'root', 'root');
            } catch (PDOException $e) {
                echo 'DB接続エラー: ' . $e->getMessage();
                exit; 
            }
        ?>
        <h1>ログイン</h1>
        <form action="login.php" method="post">
        <p>ユーザーネーム</p>
        <input id="username" type="text" name="username">
        <p>パスワード</p>
        <input id="password" type="password" name="password">
        <p></p>
        <input type="submit" value="ログイン">
        </form>

        <?php
        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            try {
                //データを検索
                $records  = $pdo->query("SELECT * FROM users WHERE username='{$username}' AND password='{$password}'"); 
                $message = 'ユーザーネームまたはパスワードが正しくありません';
                foreach ($records as $record) {
                    if($record!=NULL){
                        $message = 'ログイン成功';
                        echo $record['username'];
                        $_SESSION['username'] = $record['username'];
    
                    } 
                }
                echo $message;
            }
            catch (PDOException $e) {
                echo 'クエリエラー: ' . $e->getMessage();
            }
        }
    
          
        ?>
        <p></p>
        <a href="index.php">ホーム</a>
        <p></p>
        <a href="register.php">新規登録</a>
        
    </div>
</body>
</html>