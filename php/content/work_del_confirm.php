<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');
    
    $work_name = $direct = "";
    $work_id = $_GET['work_id'];

    //DB検索
    $tblName = "work_tbl";
    $where   = "work_id='".$work_id."'";
    $ret = readTbl($tblName, $where, NULL, NULL, NULL);
    if ($ret != FALSE) {
        foreach ($ret as $value) {
            $work_name = $value['work_name'];
            $direct    = $value['direct'];
        }
    }

    //直接/間接の表示
    if ($direct == 0)
        $direct = "直接";
    else
        $direct = "間接";


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
        <form action="work_del_done.php" method="post">
            <input type="hidden" name="work_id" value="<?php echo $work_id;?>">

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
                <td>作業番号</td>
                <td><?php echo $work_id; ?></td>
            </tr>
            <tr>
                <td>作業名</td>
                <td><?php echo $work_name; ?></td>
            </tr>
            <tr>
                <td>直接/間接</td>
                <td><?php echo $direct;?></td>
            </tr>
        </table>
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>