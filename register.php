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
        <h1>新規登録</h1>
        <form action="register.php" method="post">
        <p>ユーザーネーム</p>
        <input id="username" type="text" name="username">
        <p>パスワード</p>
        <input id="password" type="password" name="password">
        <p> </p>
        <input type="submit" value="登録">
        </form>
        
        <?php
        
        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            try {
                $exist=FALSE;
                //データを挿入
                $records  = $pdo->query("SELECT username FROM users"); 
                //foreach ($records as $record){
                //    $re = $record;
                //}
                foreach ($records as $rec){
                    if($rec['username'] === $username ){
                        $exist=TRUE;
                    }
                }
                if ($exist===TRUE){
                    echo 'このユーザーネームは使えません ';
                }else {
                    $insert  = $pdo->query("INSERT INTO users(username,password) VALUES('{$username}','{$password}')");
                    echo '登録完了'; 
                }

            } catch (PDOException $e) {
                echo 'クエリエラー: ' . $e->getMessage();
            }
        }      
        ?>
        <?php if(isset($insert)): 
            header("Location:./login.php");
            exit();
        endif ?>
    </div>
</body>
</html>