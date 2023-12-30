<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    $ver = $device_name = "";
    $device_id = $_GET['device_id'];

    //DB検索
    $tblName = "device_tbl";
    $where   = "device_id='".$device_id."'";
    $ret = readTbl($tblName, $where, NULL, NULL, NULL);
    if ($ret != FALSE) {
        foreach ($ret as $value) {
            $ver         = $value['ver'];
            $device_name = $value['device_name'];
        }
    }


    //機種削除ボタンは管理者権限のみ表示
    $strDelBtn = "";
    if ($_SESSION['auth'] == 1) {
        $strDelBtn =
        "<a href=\"device_del_confirm.php?device_id=".$device_id."\">
            <span class=\"button has-text-light has-background-danger ml-5\">機種削除</span>
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
                <td>機種番号</td>
                <td><?php echo $device_id; ?></td>
            </tr>
            <tr>
                <td>Ver</td>
                <td><?php echo $ver; ?></td>
            </tr>
            <tr>
                <td>商品名:</td>
                <td><?php echo $device_name;?></td>
            </tr>
        </table>
    </div>

    <div class="block ml-6">
        <a href="device_edit.php?device_id=<?php echo $device_id;?>">
            <span class="button has-background-grey-lighter">編集</span>
        </a>
        <?php echo $strDelBtn; ?>
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>