<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    $device_id = $ver = $device_name = $comment = "";
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
                $comment     = $value['comment'];
            }
        }
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

    <form action="device_edit_done.php" method="post">
        <input type="hidden" name="idx" value="<?php echo $idx; ?>">

        <div class="field ml-6 mr-6">
            <label class="label">機種番号 (※編集不可)</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="4" name="device_id" required value="<?php echo $device_id;?>" readonly>
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label">Ver (※編集不可)</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="2" name="ver" required value="<?php echo $ver;?>" readonly>
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label">機種名 ※必須</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="32"  name="device_name" required value="<?php echo $device_name;?>">
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label">コメント</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="255"  name="comment" value="<?php echo $comment;?>">
            </div>
        </div>
        <br>
        <div class="field is-grouped ml-6">
            <div class="control">
                <input class="button has-background-grey-lighter" type="button" onclick="location ='<?php echo $strBack; ?>'" value="戻る">
            </div>
            <div class="control">
                <input class="button is-success ml-4" type="submit" value="更新">
            </div>
        </div>
    </form>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>