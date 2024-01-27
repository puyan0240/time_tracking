<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    $work_name = $result = $comment = "";
    $work_id = $_GET['work_id'];

    //DB検索
    {
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $whereKeyValue = [];
        $whereKeyValue['work_id'] = (int)$work_id;  

        //DBアクセス
        $tblName = "work_tbl";
        $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
        if ($ret != FALSE) {
            foreach ($ret as $value) {
                $work_name = $value['work_name'];
                $comment   = $value['comment'];
            }
        }

        //select option の初期値
        {
            $selectedTbl = ["",""];
            $selectedTbl[$result] = "selected";
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>

    <form action="work_edit_done.php" method="post">
        <input type="hidden" name="device_id" value="<?php echo $device_id; ?>">

        <div class="field ml-6 mr-6">
            <label class="label is-small">作業番号 (※編集不可)</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="4" name="work_id" required value="<?php echo $work_id;?>" readonly>
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label is-small">作業名 ※必須</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="32"  name="work_name" required value="<?php echo $work_name;?>">
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label is-small">コメント</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="32"  name="comment" value="<?php echo $comment;?>">
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