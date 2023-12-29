<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

   
    $user_id = $auth = $type = 0;
    $passwd = $user_name = "";

    $user_id = $_GET['user_id'];

    //DB検索
    $tblName = "account_tbl";
    $where   = "user_id='".$user_id."'";
    $ret = readTbl($tblName, $where, NULL, NULL, NULL);
    if ($ret != FALSE) {
        foreach ($ret as $value) {
            $user_name = $value['user_name'];
            $auth      = $value['auth'];
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

    <div class="block ml-6">
        <a href="branch.php?account_edit_type=edit&account_idx=<?php echo $account_idx;?>">
            <span class="button has-background-grey-lighter">編集</span>
        </a>
<!---
        <a href="branch.php?account_edit_type=passwd_clr&account_idx=<?php echo $account_idx;?>">
            <span class="button has-text-light has-background-danger ml-5">パスワード初期化</span>
        </a>
---> 
        <a href="branch.php?account_edit_type=clr&account_idx=<?php echo $account_idx;?>">
            <span class="button has-text-light has-background-danger ml-5">アカウント削除</span>
        </a> 
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>