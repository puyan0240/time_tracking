<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    $device_id = $ver = $device_name = $display = $comment = "";
    $idx = (int)$_GET['idx'];

    //DB検索
    {       
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $whereKeyValue = [];
        $whereKeyValue['idx'] = (int)$idx;

        //DBアクセス
        $tblName = "device_tbl";
        $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
        if ($ret != FALSE) {
            foreach ($ret as $value) {
                $device_id   = $value['device_id'];
                $ver         = str_pad($value['ver'], 2, 0, STR_PAD_LEFT); //0埋めの2桁表示
                $device_name = $value['device_name'];
                $display     = "---";
                if ($value['display'] == 1) {
                    $display = "表示";
                }
                $comment     = $value['comment'];
            }
        }
    }


    //機種削除ボタンは管理者権限のみ表示
    $strDelBtn = "";
    if ($_SESSION['auth'] == 1) {
        $strDelBtn =
        "<a href=\"device_del_confirm.php?idx=".$idx."\">
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
        <table class="table">
            <tr>
                <td>機種番号</td>
                <td><?php echo $device_id; ?></td>
            </tr>
            <tr>
                <td>Ver</td>
                <td><?php echo $ver; ?></td>
            </tr>
            <tr>
                <td>機種名</td>
                <td><?php echo $device_name;?></td>
            </tr>
            <tr>
                <td>表示</td>
                <td><?php echo $display;?></td>
            </tr>
            <tr>
                <td>コメント</td>
                <td><?php echo $comment;?></td>
            </tr>
        </table>
    </div>

    <div class="block ml-6">
        <a href="device_edit.php?idx=<?php echo $idx;?>">
            <span class="button has-background-grey-lighter">編集</span>
        </a>
        <?php echo $strDelBtn; ?>
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>