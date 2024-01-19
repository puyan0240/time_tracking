<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');
    

     //日付
    {
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        } else {
            $date = date('Y-m-d');
        }

        $strTmp = date('Y年 m月 d日', strtotime($date));

        //曜日表示
        $week = ['日','月','火','水','木','金','土'];
        $dayOfWeek = $week[date('w', strtotime($date))];
        $strTmp .= " (".$dayOfWeek.")";
        if (($dayOfWeek == '土') || ($dayOfWeek == '日')) { //土日は赤色文字
            $strClass = 'class="label has-text-danger"';
        } else {
            $strClass = 'class="label"';
        }

        //HTML
        $format = '<label %s>%s</label>';
        $strDate = sprintf($format, $strClass, $strTmp);

    }

    //担当者指定
    {
        if (isset($_GET['user_id'])) {
            $selUserId = $_GET['user_id'];
        } else {
            $selUserId = 0;
        }
    }

    //他人の一覧を見る場合は閲覧モードで
    if ($selUserId) {
        if ($selUserId != $_SESSION['user_id']) { //他人
            $strLocation = 'Location:time_display.php'.'?date='.$date.'&user_id='.$selUserId;
            header($strLocation);
            exit();    
        }
    }


    $timeSum = 0;

    $tableFormat = "
    <tr>
        <td>
            <div class=\"select is-primary is-small\">
                <select name=\"device_tbl_idx%02s\">%s</select>
            </div>
        </td>
        <td>
            <div class=\"select is-primary is-small\">
                <select name=\"ref_device_tbl_idx%02s\">%s</select>
            </div>
        </td>
        <td>
            <div class=\"select is-primary is-small\">
                <select name=\"work_id%02s\">%s</select>
            </div>
        </td>
        <td>
            <div class=\"select is-primary is-small\">
                <select name=\"hour%02s\">%s</select>
            </div>
        </td>
        <td>
            <div class=\"select is-primary is-small\">
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
            $order = "ORDER BY device_id DESC , ver ASC "; //機種番号は降順、Verは昇順が良い??
            $deviceList = readTbl($tblName, NULL, NULL, $order, NULL, NULL);
            if ($deviceList != false) {
                foreach ($deviceList as $value) {
                    $strDevSelOpt .= sprintf($format, $value['idx'], $value['device_name']);
                }    
            }
        }

        //関連機種
        {
            $format = "<option value=\"%s\">%s</option>";
            $strRefDevSelOpt = sprintf($format, "none", "なし");

            if ($deviceList != false) {
                foreach ($deviceList as $value) {
                    $strRefDevSelOpt .= sprintf($format, $value['idx'], $value['device_name']);
                }    
            }
        }

        //作業項目
        {
            $strWrkSelOpt = "";
            $format = "<option value=\"%s\">%s</option>";

            //DB TABLEから読み出し
            $tblName = "work_tbl";
            $workList = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
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
        $strRetDevSelOpt = $strRetRefDevSelOpt = $strRetWrkSelOpt = $strRetHourSelOpt = $strRetMinSelOpt = [];

        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $whereKeyValue = [];
        $whereKeyValue['date'] = $date;
        $whereKeyValue['user_id'] = (int)($_SESSION['user_id']);

        //DB検索
        $tblName = "time_traking_tbl";
        $retList = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
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
                            if ($retValue['device_tbl_idx'] == $value['idx'])
                                $strSel = "selected";
                            
                            $strTmp .= sprintf($format, $value['idx'], $strSel, $value['device_name']);
                        }
                        $strRetDevSelOpt[] = $strTmp;
                    }
                }

                //関連機種一覧
                {
                    $format = "<option value=\"%s\" %s>%s</option>";
                    $strTmp = sprintf($format, "none", "", "なし");

                    if ($deviceList != false) {
                        foreach ($deviceList as $value) {
                            $strSel = "";
                            if ($retValue['ref_device_tbl_idx'] == $value['idx'])
                                $strSel = "selected";
                            
                            $strTmp .= sprintf($format, $value['idx'], $strSel, $value['device_name']);
                        }
                        $strRetRefDevSelOpt[] = $strTmp;
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
        if ($timeSum > 0)
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
                $strTbl .= sprintf($tableFormat, 
                                    $i, $strRetDevSelOpt[$i],
                                    $i, $strRetRefDevSelOpt[$i],
                                    $i, $strRetWrkSelOpt[$i], 
                                    $i, $strRetHourSelOpt[$i], 
                                    $i, $strRetMinSelOpt[$i]);
            } else {
                $strTbl .= sprintf($tableFormat, 
                                    $i, $strDevSelOpt,
                                    $i, $strRefDevSelOpt, 
                                    $i, $strWrkSelOpt, 
                                    $i, $strHourSelOpt, 
                                    $i, $strMinSelOpt);
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
        <div class="block">
            <table class="table my-0">
                <tr>
                    <td><?php echo $strDate; ?></td>
                </tr>
            </table>
            <table class="table">
                <tr>
                    <td>&ensp;</td>
                    <td>勤務時間:</td>
                    <td><?php echo $strSum;?></td>
                    <td>&ensp;</td>
                    <td>残業時間:</td>
                    <td><?php echo $strOvertime;?></td>
                </tr>
            </table>
        </div>

        <form action="time_add_done.php" method="POST">
  
            <input type="hidden" name="date" value="<?php echo $date;?>">

            <div class="block">
                <table class="table">
                    <thead>
                        <tr>
                            <td align="center">機種名</td>
                            <td align="center">※設計予定機種名</td>
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