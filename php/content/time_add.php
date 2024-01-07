<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

     //日付
    {
        if (isset($_GET['date']))
            $date = $_GET['date'];
        else
            $date = date('Y-m-d');

        $strDate = date('Y年m月d日', strtotime($date));
    }

    $timeSum = 0;

    $tableFormat = "
    <tr>
        <td>
            <div class=\"select is-primary\">
                <select name=\"device_id%02s\">%s</select>
            </div>
        </td>
        <td>
            <div class=\"select is-primary\">
                <select name=\"work_id%02s\">%s</select>
            </div>
        </td>
        <td>
            <div class=\"select is-primary\">
                <select name=\"hour%02s\">%s</select>
            </div>
        </td>
        <td>
            <div class=\"select is-primary\">
                <select name=\"min%02s\">%s</select>
            </div>
        </td>
    </tr>
    ";


    //select-option:選択肢作成
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


    //既に登録しているデータを表示
    {
        $count = 0;
        $strRetDevSelOpt = $strRetWrkSelOpt = $strRetHourSelOpt = $strRetMinSelOpt = [];

        //DB TABLEの要素名リスト
        $whereKeyName = ['date','user_id'];
        $whereKeyValue = [];
        
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($whereKeyName as $key) {
            if ($key == 'date') {
                $whereKeyValue[$key] = $date;
            } elseif ($key == 'user_id') {
                $whereKeyValue[$key] = (int)($_SESSION['user_id']);
            } else {
                $whereKeyValue[$key] = e($_POST[$key]);
            }
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
                    $timeSum += $time; //合計時間計算用

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

    //勤務時間
    {
        $strSum = $strOvertime = "-----";
        $format = "%02d時間 %02d分";

        //勤務時間
        {
            $hour = (int)($timeSum / 60);
            $min  = (int)($timeSum % 60);

            $strSum = sprintf($format, $hour, $min);
        }

        //残業時間
        $overtime = $timeSum - (60*8);
        if ($overtime > 0) {
            $hour = (int)($overtime / 60);
            $min  = (int)($overtime % 60);
    
            $strOvertime = sprintf($format, $hour, $min);
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
        <label class="label"><?php echo $strDate; ?></label>
        <br>

        <form action="time_add_done.php" method="POST">
  
            <input type="hidden" name="date" value="<?php echo $date;?>">

            <div class="block">
                <table class="table" id="list_table">
                    <thead>
                        <tr>
                            <td align="center">機種</td>
                            <td align="center">作業</td>
                            <td align="center">時間</td>
                            <td align="center">分</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $strTbl; ?>
                    </tbody>
                </table>
            </div>

            <div class="block ml-6">
                <table class="table" id="list_table">
                    <tr>
                        <td>勤務時間</td>
                        <td><?php echo $strSum;?></td>
                    </tr>
                    <tr>
                        <td>残業時間</td>
                        <td><?php echo $strOvertime;?></td>
                    </tr>
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