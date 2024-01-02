<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //機種一覧
    {
        $strDevSelOpt = "";
        $format = "<option value=\"%s\">%s</option>";

        //DB TABLEから読み出し
        $tblName = "device_tbl";
        $order = "ORDER BY device_id DESC"; //降順
        $ret = readTbl($tblName, NULL, $order, NULL, NULL);
        if ($ret != false) {
            foreach ($ret as $value) {
                $strDevSelOpt .= sprintf($format, $value['device_id'], $value['device_name']);
            }    
        }
    }

    //作業項目一覧
    {
        $strWrkSelOpt = "";
        $format = "<option value=\"%s\">%s</option>";

        //DB TABLEから読み出し
        $tblName = "work_tbl";
        $ret = readTbl($tblName, NULL, NULL, NULL, NULL);
        if ($ret != false) {
            foreach ($ret as $value) {
                $strWrkSelOpt .= sprintf($format, $value['work_id'], $value['work_name']);
            }    
        }
    }

    //時間
    {
        $strHourSelOpt = "";
        $format = "<option value=\"%s\">%02s</option>";
        for ($i = 0; $i <= 12; $i ++) {
            $strHourSelOpt .= sprintf($format, $i, $i);
        }
    }

    //分
    {
        $strMinSelOpt = "";
        $format = "<option value=\"%s\">%02s</option>";
        for ($i = 0; $i < 60; $i = $i+15) {
            $strMinSelOpt .= sprintf($format, $i, $i);
        }
    }

    //Table
    {
        $strTbl = "";
        $format = "
        <tr>
            <td><label>機種:</label></td>
            <td>
                <select name=\"device_id%02s\">
                    %s
                </select>
            <td>
            <td><label>作業:</label></td>
            <td>
                <select name=\"work_id%02s\">
                    %s
                </select>
            <td>
            <td><label>時間:</label></td>
            <td>
                <select name=\"hour%02s\">
                    %s
                </select>
            <td>
            <td><label>分:</label></td>
            <td>
                <select name=\"min%02s\">
                    %s
                </select>
            <td>
        <tr>
        ";
        for ($i = 0; $i < 12; $i ++) {
            $strTbl .= sprintf($format, $i, $strDevSelOpt, $i, $strWrkSelOpt, $i, $strHourSelOpt, $i, $strMinSelOpt);
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>

    <div class="block ml-6 mr-6">
        <form action="time_add_done.php" method="POST">
  
            <div class="block">
                <table class="table" id="list_table">
                    <?php echo $strTbl; ?>
                </table>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <input class="button has-background-grey-lighter" type="reset" value="取消">
                </div>
                <div class="control">
                    <input class="button is-success ml-4" type="submit" value="登録">
                </div>
            </div>
        </form> 
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>