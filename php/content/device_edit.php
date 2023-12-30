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
        <input type="hidden" name="device_id" value="<?php echo $device_id; ?>">

        <div class="field ml-6 mr-6">
            <label class="label">機種番号 (※編集できません)</label>
            <div class="control">
                <input class="input is-sucess" type="text" name="device_id" required value="<?php echo $device_id;?>" readonly>
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label">Ver</label>
            <div class="control">
                <input class="input is-sucess" type="text" name="ver" required value="<?php echo $ver;?>">
            </div>
        </div>
        <div class="field ml-6 mr-6">
            <label class="label">商品名</label>
            <div class="control">
                <input class="input is-sucess" type="text" name="device_name" required value="<?php echo $device_name;?>">
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