<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    $ver = $device_name = "";
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


    //機種削除ボタンは管理者権限のみ表示
    $strDelBtn = "";
    if ($_SESSION['auth'] == 1) {
        $strDelBtn =
        "<a href=\"work_del_confirm.php?work_id=".$work_id."\">
            <span class=\"button has-text-light has-background-danger ml-5\">作業項目削除</span>
        </a>";
    }


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

    <div class="block ml-6">
        <a href="work_edit.php?work_id=<?php echo $work_id;?>">
            <span class="button has-background-grey-lighter">編集</span>
        </a>
        <?php echo $strDelBtn; ?>
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>