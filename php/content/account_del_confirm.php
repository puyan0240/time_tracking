<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');
    

    $user_id = $auth = $type = 0;
    $passwd = $user_name = "";

    $user_id = $_GET['user_id'];

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
            foreach ($ret as $value) {
                $user_name = $value['user_name'];
                $auth      = $value['auth'];
            }
        }
    }

    //アカウント権限の表示
    if ($auth == 0)
        $auth = "一般";
    else
        $auth = "管理者";


    //戻り先
    $strBack = $_SERVER['HTTP_REFERER'];
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>
    <div class="block ml-6">
        <p>削除しますか？</p>
    </div>

    <div class="block ml-6 mr-6">
        <form action="account_del_done.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">

            <div class="field">
                <p>delete と入力してください</p>
                <div class="control">
                    <input class="input is-sucess" type="text" name="key_word">
                </div>
            </div>
            <div class="field is-grouped">
                <a href="<?php echo $strBack; ?>">
                    <span class="button has-background-grey-lighter">戻る</span>
                </a>
                <div class="control ml-6">
                    <input class="button is-danger" type="submit" value="削除実行">
                </div>
            </div>            
        </form>
    </div>

    <br>
    <div class="block ml-6">
        <table class="table" >
            <tr>
                <td>社員番号</td>
                <td><?php echo $user_id; ?></td>
            </tr>
            <tr>
                <td>名前</td>
                <td><?php echo $user_name; ?></td>
            </tr>
            <tr>
                <td>権限:</td>
                <td><?php echo $auth;?></td>
            </tr>
        </table>
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>