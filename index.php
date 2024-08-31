<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter風アプリ</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php
            session_start();
            //db接続
            try {
                $pdo = new PDO('mysql:dbname=twiiterdb;host=localhost;port=8889;charset=utf8', 'root', 'root');
            } catch (PDOException $e) {
                echo 'DB接続エラー: ' . $e->getMessage();
                exit; 
            }
            try {
                //データを取得
                $records  = $pdo->query('SELECT * FROM tweets ORDER BY id DESC'); 
                
                    
                    
            } catch (PDOException $e) {
                echo 'クエリエラー: ' . $e->getMessage();
            }

            if (isset($_POST['logout'])) {
                $_SESSION['username'] = '';
                header("Location:./index.php");
                exit();

            }

        ?>
        <?php if(isset($_SESSION['username']) && $_SESSION['username']!==''): ?>
            <h2>ツイッター風アプリ</h2>
            <p><?php echo($_SESSION['username']) ?> ログイン済み</p>
            <form action="index.php" method="post">
                <button type="submit" name="logout">ログアウト</button>
            </form>
        <main>
            <form action="index.php" method="post">
                <textarea id="tweetText" name="tweetText" placeholder="今どうしてる？"></textarea>
                <input type="submit" value="ツイートする">
            </form>
            <?php if(isset($_POST['tweetText'])){
            $tweetText = htmlspecialchars($_POST['tweetText']);
            $date_time = new DateTime(); 
            $date_time_disp = $date_time->format("Y-m-d H:i");


            try {
                //データを挿入
                $records2  = $pdo->query("INSERT INTO tweets(id,username,text,date) VALUES(NULL,'{$_SESSION['username']}','{$tweetText}','{$date_time_disp}')");
                header("Location:./index.php");
                exit();
            } catch (PDOException $e) {
                echo 'クエリエラー: ' . $e->getMessage();
            }
        } ?>
            <?php if (isset($records2)): ?>
                <p>投稿しました<p>
                <div class="tweet-list">
                <p><?php echo $_SESSION['username'].'：'.$tweetText.'<br>'.$date_time_disp ?></p>
                </div>
            <?php endif ?>
            <div class="tweet-list">
                <!-- ツイートがここに表示されます -->
                <?php foreach ($records as $record): ?>
                    <p><?php echo $record['username'].'：'.$record['text'].'<br>'.$record['date'] ?></p>
                <?php endforeach ?>
            
            </div>
        </main>
        <script src="script.js"></script>
        <?php else: ?>
            <p>ログインしてください</p>
            <a href="login.php">ログイン</a>
        <?php endif ?>
       

    </div>

</body>
</html>
