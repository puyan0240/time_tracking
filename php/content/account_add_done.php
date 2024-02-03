<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $input_ok = false;

    //数値確認
    {
        if (is_numeric($_POST['user_id']) != true) {
            $result = "社員番号は数値で入力してください。";
        } elseif (mb_strlen($_POST['user_id']) != 5) {
            $result = "社員番号は5桁の範囲で入力してください。";
        } else {
            $user_id = e($_POST['user_id']);
            $input_ok = true;
        }
    }

    //２重登録の確認
    if ($input_ok == true)
    {
        //DB検索
        {
            //DB TABLEの要素名リスト
            $whereKeyName = ['user_id'];
            $whereKeyValue = [];
        
            //DB TABLEの 要素名:値 になるよう連想配列を作成
            foreach ($whereKeyName as $key) {
                if ($key == 'user_id')
                    $whereKeyValue[$key] = (int)$user_id;
                else
                    $whereKeyValue[$key] = e($_POST[$key]);
            }

            //DBアクセス
            $tblName = "account_tbl";
            $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
            if ($ret != FALSE) {
                $result = "社員番号:".$user_id." は、既に登録されています。";
                $input_ok = false;
            }
        }
    }

    //初期のパスワードはユーザー名とします。
    if ($input_ok == true) {
        //パスワードを暗号化する
        $passwd_hash = password_hash($user_id, PASSWORD_DEFAULT);
    }

    //登録
    if ($input_ok == true) {
        
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $keyValue = [];
        $keyValue['user_id']   = (int)e($_POST['user_id']);
        $keyValue['passwd']    = $passwd_hash;
        $keyValue['user_name'] = e($_POST['user_name']);
        $keyValue['auth']      = (int)e($_POST['auth']);
        $keyValue['category']  = (int)e($_POST['category']);

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
        }, 1*1000);
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>