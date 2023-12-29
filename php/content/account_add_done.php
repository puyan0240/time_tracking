<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    //２重登録の確認
    {
        $errFlag = FALSE;      
        $user_id = e($_POST['user_id']);

        //DB検索
        $tblName = "account_tbl";
        $where   = "user_id='".$user_id."'";
        $ret = readTbl($tblName, $where, NULL, NULL, NULL);
        if ($ret != FALSE) {
            $errFlag = TRUE;
            $result = "社員番号:".$user_id." は、既に登録されています。";
        }
    }

    //初期のパスワードはユーザー名とします。
    if ($errFlag == FALSE) {
        //パスワードを暗号化する
        $passwd_hash = password_hash($user_id, PASSWORD_DEFAULT);
    }

    //登録
    if ($errFlag == FALSE) {

        //DB TABLEの要素名リスト
        $keyName = ['user_id','passwd','user_name','auth','type'];
        $keyValue = [];
    
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($keyName as $key) {
            if ($key == 'user_id') {
                $keyValue[$key] = (int)e($_POST[$key]);
            } elseif ($key == 'auth') {
                $keyValue[$key] = (int)e($_POST[$key]);
            } elseif ($key == 'type') {
                //$keyValue[$key] = (int)e($_POST[$key]);
                $keyValue[$key] = 0;
            } elseif ($key == 'passwd') {
                $keyValue[$key] = $passwd_hash;
            } else {
                $keyValue[$key] = e($_POST[$key]);
            }
        }
        
        //DB TABLEへ書き込み
        $tblName = "account_tbl";
        if (writeTbl($tblName, $keyValue) == TRUE) {
            $result = "登録しました。";
        } else {
            $result = "登録が失敗しました。";
        }    
    }
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>
    <br>
    <div class="block ml-6">
        <p><?php echo $result; ?></p>
    </div>
    <div class="block ml-6">
        <a href="account_list.php">アカウント管理へ</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "account_list.php";
        }, 2*1000);
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>