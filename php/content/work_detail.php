<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $work_name = $direct = "";
    $work_id = $_GET['work_id'];

    //DB検索
    {
        //DB TABLEの要素名リスト
        $whereKeyName = ['work_id'];
        $whereKeyValue = [];
        
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($whereKeyName as $key) {
            if ($key == 'work_id')
                $whereKeyValue[$key] = (int)$work_id;
            else
                $whereKeyValue[$key] = e($_POST[$key]);
        }

        //DBアクセス
        $tblName = "work_tbl";
        $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
        if ($ret != FALSE) {
            foreach ($ret as $value) {
                $work_name = $value['work_name'];
                $result    = $value['result'];
            }
        }
    }

    //直接/間接の表示
    if ($result == 0)
        $result = "-----";
    else
        $result = "対象";


    //結果表示は管理者権限のみ表示
    $strResultTbl = "";
    if ($_SESSION['auth']) {
        $format = "
            <tr>
                <td>結果表示</td>
                <td>%s</td>
            </tr>";

        if ($result) {
            $result = "対象";
        } else {
            $result = "-----";
        }

        $strResultTbl = sprintf($format, $result);
    }


    //機種削除ボタンは管理者権限のみ表示
    $strDelBtn = "";
    if ($_SESSION['auth']) {
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
            <?php echo $strResultTbl; ?>
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