<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

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
        $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL);
        if ($ret != FALSE) {
            foreach ($ret as $value) {
                $work_name = $value['work_name'];
                $direct    = $value['direct'];
            }
        }

        //select option の初期値
        {
            $selectedTbl = ["",""];
            $selectedTbl[$direct] = "selected";
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

    <form action="work_edit_done.php" method="post">
        <input type="hidden" name="device_id" value="<?php echo $device_id; ?>">

        <div class="field ml-6 mr-6">
            <label class="label">作業番号 (※編集不可)</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="4" name="work_id" required value="<?php echo $work_id;?>" readonly>
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label">作業名</label>
            <div class="control">
                <input class="input is-sucess" type="text" maxlength="32"  name="work_name" required value="<?php echo $work_name;?>">
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label">直接/間接</label>
            <div class="control">
                <div class="select is-success">
                    <select name="direct">
                        <option value="0" <?php echo $selectedTbl[0];?>>直接</option>
                        <option value="1" <?php echo $selectedTbl[1];?>>間接</option>
                    </select>
                </div>
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