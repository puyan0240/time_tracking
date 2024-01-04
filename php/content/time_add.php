<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');


    $tableFormat = "
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


    //選択肢作成
    {
        //機種
        {
            $strDevSelOpt = "";
            $format = "<option value=\"%s\">%s</option>";

            //DB TABLEから読み出し
            $tblName = "device_tbl";
            $order = "ORDER BY device_id DESC"; //降順
            $deviceList = readTbl($tblName, NULL, $order, NULL, NULL);
            if ($deviceList != false) {
                foreach ($deviceList as $value) {
                    $strDevSelOpt .= sprintf($format, $value['device_id'], $value['device_name']);
                }    
            }
        }

        //作業項目
        {
            $strWrkSelOpt = "";
            $format = "<option value=\"%s\">%s</option>";

            //DB TABLEから読み出し
            $tblName = "work_tbl";
            $workList = readTbl($tblName, NULL, NULL, NULL, NULL);
            if ($workList != false) {
                foreach ($workList as $value) {
                    $strWrkSelOpt .= sprintf($format, $value['work_id'], $value['work_name']);
                }    
            }
        }

        //選択肢:時間
        {
            $strHourSelOpt = "";
            $format = "<option value=\"%s\">%02s</option>";
            for ($i = 0; $i <= 12; $i ++) {
                $strHourSelOpt .= sprintf($format, $i, $i);
            }
        }

        //選択肢:分
        {
            $strMinSelOpt = "";
            $format = "<option value=\"%s\">%02s</option>";
            for ($i = 0; $i < 60; $i = $i+15) {
                $strMinSelOpt .= sprintf($format, $i, $i);
            }
        }
    }


    //本日の登録一覧
    {
        $count = 0;
        $strRetDevSelOpt = $strRetWrkSelOpt = $strRetHourSelOpt = $strRetMinSelOpt = [];

        //DB TABLEの要素名リスト
        $whereKeyName = ['date'];
        $whereKeyValue = [];
        
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($whereKeyName as $key) {
            if ($key == 'date')
                $whereKeyValue[$key] = date('y-m-d');
            else
                $whereKeyValue[$key] = e($_POST[$key]);
        }

        //DB検索
        $tblName = "time_traking_tbl";
        $retList = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL);
        if ($retList != FALSE) {
            foreach ($retList as $retValue) {
                $count ++;

                //機種一覧
                {
                    $format = "<option value=\"%s\" %s>%s</option>";

                    if ($deviceList != false) {
                        $strTmp = "";
                        foreach ($deviceList as $value) {
                            $strSel = "";
                            if ($retValue['device_id'] == $value['device_id'])
                                $strSel = "selected";
                            
                            $strTmp .= sprintf($format, $value['device_id'], $strSel, $value['device_name']);
                        }
                        $strRetDevSelOpt[] = $strTmp;
                    }
                }

                //作業項目一覧
                {
                    $format = "<option value=\"%s\" %s>%s</option>";

                    if ($workList != false) {
                        $strTmp = "";
                        foreach ($workList as $value) {
                            $strSel = "";
                            if ($retValue['work_id'] == $value['work_id'])
                                $strSel = "selected";

                            $strTmp .= sprintf($format, $value['work_id'], $strSel, $value['work_name']);
                        }
                        $strRetWrkSelOpt[] = $strTmp;
                    }
                }

                //時間、分
                {
                    $time = (int)($retValue['time']);
                    $hour = (int)($time / 60);
                    $min  = (int)($time % 60);

                    //時間
                    {
                        $format = "<option value=\"%s\" %s>%02s</option>";
                        $strTmp = "";
                        for ($i = 0; $i <= 12; $i ++) {
                            $strSel = "";
                            if ($hour == $i)
                                $strSel = "selected";
                            $strTmp .= sprintf($format, $i, $strSel, $i);
                        }
                        $strRetHourSelOpt[] = $strTmp;
                    }
                    //分
                    {
                        $format = "<option value=\"%s\" %s>%02s</option>";
                        $strTmp = "";
                        for ($i = 0; $i < 60; $i = $i+15) {
                            $strSel = "";
                            if ($min == $i)
                                $strSel = "selected";
                            $strTmp .= sprintf($format, $i, $strSel, $i);
                        }
                        $strRetMinSelOpt[] = $strTmp;
                    }

                }
            }
        }
    }


    //Table作成
    {
        $strTbl = "";
    
        for ($i = 0; $i < 12; $i ++) {
            if ($i < $count) {
                $strTbl .= sprintf($tableFormat, $i, $strRetDevSelOpt[$i], $i, $strRetWrkSelOpt[$i], $i, $strRetHourSelOpt[$i], $i, $strRetMinSelOpt[$i]);
            } else {
                $strTbl .= sprintf($tableFormat, $i, $strDevSelOpt, $i, $strWrkSelOpt, $i, $strHourSelOpt, $i, $strMinSelOpt);
            }
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