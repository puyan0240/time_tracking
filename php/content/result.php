<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    //分析結果
    $strTimeSum = $strManhoursSum = "-----";
    $strResultTbl = "";

    //管理開始年
    $startYear = 2023;

    $selStartYear = $selStartMonth = $selStartDay = 0;
    $selEndYear = $selEndMonth = $selEndDay = 0;
    $selRefDeviceId = $selUserId = 0;

    //指定確認
    if (isset($_POST['btn']))
    {
        //期間
        if (isset($_POST['start_year'])) {
            $selStartYear = (int)e($_POST['start_year']);
        }
        if (isset($_POST['start_month'])) {
            $selStartMonth = (int)e($_POST['start_month']);
        }
        if (isset($_POST['start_day'])) {
            $selStartDay = (int)e($_POST['start_day']);
        }
        if (isset($_POST['end_year'])) {
            $selEndYear = (int)e($_POST['end_year']);
        }
        if (isset($_POST['end_month'])) {
            $selEndMonth = (int)e($_POST['end_month']);
        }
        if (isset($_POST['end_day'])) {
            $selEndDay = (int)e($_POST['end_day']);
        }

        //機種
        if (isset($_POST['ref_device'])) {
            $selRefDeviceId = (int)e($_POST['ref_device']);
        }

        //担当
        if (isset($_POST['user'])) {
            $selUserId = (int)e($_POST['user']);
        }
    }


    //select-option:選択肢作成
    {
        //開始年
        {
            //現在の年
            $Year = (int)date('Y');

            $strStartYearSelOpt = "";
            $format = "<option value=\"%s\" %s>%s年</option>";
            while ($Year >= $startYear) {
                if ($Year == $selStartYear)
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strStartYearSelOpt .= sprintf($format, $Year, $strSelected, $Year);
                $Year --;
            }
        }

        //開始月
        {
            $strStartMonthSelOpt = "";
            $format = "<option value=\"%s\" %s>%02s月</option>";
            for ($i = 1; $i <= 12; $i ++) {
                if ($i == $selStartMonth)
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strStartMonthSelOpt .= sprintf($format, $i, $strSelected, $i);
            }
        }

        //開始日
        {
            $strStartDaySelOpt = "";
            $format = "<option value=\"%s\" %s>%02s日</option>";
            for ($i = 1; $i <= 31; $i ++) {
                if ($i == $selStartDay)
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strStartDaySelOpt .= sprintf($format, $i, $strSelected, $i);
            }
        }

        //終了年
        {
            //現在の年
            $Year = (int)date('Y');

            $strEndYearSelOpt = "";
            $format = "<option value=\"%s\" %s>%s年</option>";
            while ($Year >= $startYear) {
                if ($Year == $selEndYear)
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strEndYearSelOpt .= sprintf($format, $Year, $strSelected, $Year);
                $Year --;
            }
        }

        //終了月
        {
            $strEndMonthSelOpt = "";
            $format = "<option value=\"%s\" %s>%02s月</option>";
            for ($i = 1; $i <= 12; $i ++) {
                if ($i == $selEndMonth)
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strEndMonthSelOpt .= sprintf($format, $i, $strSelected, $i);
            }
        }

        //開始日
        {
            $strEndDaySelOpt = "";
            $format = "<option value=\"%s\" %s>%02s日</option>";
            for ($i = 1; $i <= 31; $i ++) {
                if ($i == $selEndDay)
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strEndDaySelOpt .= sprintf($format, $i, $strSelected, $i);
            }
        }

        //機種一覧
        {
            $strDeviceSelOpt = "";
            $format = "<option value=\"%d\" %s>%s</option>";

            //選択肢:なし
            {
                if ($selRefDeviceId == "none")
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strDeviceSelOpt .= sprintf($format, "none", $strSelected, "指定しない"); 
            }

            //DB TABLEから読み出し
            $tblName = "device_tbl";
            $order   = "ORDER BY device_id ASC , ver ASC "; //昇順
            $ret = readTbl($tblName, NULL, NULL, $order, NULL, NULL);
            if ($ret != FALSE) {
                foreach ($ret as $value) {

                    $strSelected = "";
                    if ($selRefDeviceId != "none") {
                        if ($value['idx'] == $selRefDeviceId) {
                            $strSelected = "selected";
                        }    
                    } 
    
                    $strDeviceSelOpt .= sprintf($format, $value['idx'], $strSelected, $value['device_name']);
                }
            }
        }

        //担当者一覧
        {
            $strUserSelOpt = "";
            $format = "<option value=\"%d\" %s>%s</option>";

            //選択肢:なし
            {
                if ($selUserId == "none")
                    $strSelected = "selected";
                else
                    $strSelected = "";

                $strUserSelOpt .= sprintf($format, "none", $strSelected, "指定しない"); 
            }

            //DB TABLEから読み出し
            $tblName = "account_tbl";
            $nameList = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
            if ($nameList != FALSE) {
                foreach ($nameList as $value) {

                    $strSelected = "";
                    if ($selUserId != "none") {
                        if ($value['user_id'] == $selUserId) {
                            $strSelected = "selected";
                        }    
                    } 
    
                    $strUserSelOpt .= sprintf($format, $value['user_id'], $strSelected, $value['user_name']);
                }
            }
        }
    }


    //分析/////////////////////////////////////////////////////////////////////////////////////////////
    if (isset($_POST['btn']))
    {
        //機種一覧表示
        {
            //DB TABLEから読み出し
            $tblName = "device_tbl";
            $deviceList = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
        }

        //作業内容一覧
        {
            //DB TABLEから読み出し
            $tblName = "work_tbl";
            $workList = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
        }

        //TABLEヘッダ作成
        {
            $strResultTbl = "<tr><td> 担当者 </td><td> 商品名 </td>";
            $format = "<td> %s </td>";
            foreach ($workList as $value) {
                if ($value['result'] == 0) {
                    continue; //結果表示しない項目
                }

                $strResultTbl .= sprintf($format, $value['work_name']);
            }
            $strResultTbl .= "</tr>";
        }

        //日程の範囲指定
        {
            $format = "%d-%02d-%02d";
            $strStart = sprintf($format, $selStartYear, $selStartMonth, $selStartDay);
            $strEnd   = sprintf($format, $selEndYear, $selEndMonth, $selEndDay);
            
            $format = "date BETWEEN '%s' AND '%s'";
            $between = sprintf($format, $strStart, $strEnd);
        }


        $timeTotal = $dayTotal = 0;

        //担当者毎に検索
        foreach ($nameList as $name) {
            $dayTotalByName = [];

            if ($selUserId) {
                if ($selUserId != $name['user_id']) {
                    continue;
                }
            }
            $whereKeyValue['user_id'] = $name['user_id'];

            //機種毎に検索
            foreach ($deviceList as $device) {
                if ($selRefDeviceId) {
                    if ($selRefDeviceId != $device['idx']) {
                        continue;
                    } else {
                        $whereKeyValue['ref_device_tbl_idx'] = $device['idx'];
                    }
                } else {
                    $whereKeyValue['device_tbl_idx'] = $device['idx'];
                }

                //DBアクセス
                {
                    $tblName = "time_traking_tbl";
                    $count   = "idx"; //時間で昇順
                    $ret = getNumberOfEntryTbl($tblName, $count, $whereKeyValue, $between);
                    if ($ret == 0) { //登録なし
                        continue;
                    } else { //登録あり->DB取得
                        $order = "ORDER BY date ASC"; //時間で昇順
                        $ret = readTbl($tblName, $whereKeyValue, $between, $order, NULL, NULL);
                        if ($ret != FALSE) {

                            //結果を格納(時間)
                            $timeSum = $daySum = [];
                            foreach ($ret as $value) {
                                if (isset($timeSum[$value['device_tbl_idx']][$value['work_id']]) == false) {
                                    $timeSum[$value['device_tbl_idx']][$value['work_id']] = 0;
                                }
                                $timeSum[$value['device_tbl_idx']][$value['work_id']] += $value['time'];
                                $timeTotal += $value['time'];

                                if (isset($daySum[$value['device_tbl_idx']][$value['work_id']]) == false) {
                                    $daySum[$value['device_tbl_idx']][$value['work_id']] = 0;
                                }
                                $daySum[$value['device_tbl_idx']][$value['work_id']] ++;

                                if (isset($dayTotalByName[$value['date']]) == false) {
                                    $dayTotalByName[$value['date']] = 1;
                                }
                            }

                            //HTML出力文
                            foreach ($deviceList as $device) {
                                $strTmp = "<tr>";
                                $strTmp .= "<td>".$name['user_name']."</td>";
                                $strTmp .= "<td>".$device['device_name']."</td>";

                                $count = 0;
                                foreach ($workList as $work) {
                                    if ($work['result'] == 0) {
                                        continue; //結果表示しない項目
                                    }

                                    if (isset($timeSum[$device['idx']][$work['work_id']])) {
                                        $count ++;

                                        $hour = (int)($timeSum[$device['idx']][$work['work_id']] / 60);
                                        $min  = (int)($timeSum[$device['idx']][$work['work_id']] % 60);
                                        $day  = $daySum[$device['idx']][$work['work_id']];
                                        
                                        $format = "<td> %dh %02dm (%dd)</td>";
                                        $strTmp .= sprintf($format, $hour, $min, $day);
                                    } else {
                                        $strTmp .= "<td> ----- </td>";
                                    }
                                }
                                if ($count == 0) {
                                    $strTmp = ""; //全作業項目が未登録の場合はスキップ
                                } else {
                                    $strTmp .= "</tr>";
                                    $strResultTbl .= $strTmp;
                                }
                            }
                        }
                    }
                }
            }

            //担当者毎の工数を加算
            {
                $dayTotal += count($dayTotalByName);
            }
        }

        //合計
        if ($timeTotal > 0) {
            //時間
            {
                $hour = (int)($timeTotal / 60);
                $min  = (int)($timeTotal % 60);

                $format = "<div class=\"block ml-6\"><p>%02d 時間 %02d 分</p></div>";
                $strTimeSum = sprintf($format, $hour, $min); 
            }

            //工数
            {
                $format = "<div class=\"block ml-6\"><p>%d 人月</p></div>";
                $strManhoursSum = sprintf($format, $dayTotal);
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

    <div class="block ml-6">
        <form action="result.php" method="POST">
            <table class="table">
                <tr>
                    <td>
                        <div class="is-size-6">
                            <p>期間（開始）</p>
                        </div>
                    </td>
                    <td>
                        <div class="select is-primary is-small">
                            <select name="start_year"><?php echo $strStartYearSelOpt;?></select>
                        </div>
                    </td>
                    <td>
                        <div class="select is-primary is-small">
                            <select name="start_month"><?php echo $strStartMonthSelOpt;?></select>
                        </div>
                    </td>
                    <td>
                        <div class="select is-primary is-small">
                            <select name="start_day"><?php echo $strStartDaySelOpt;?></select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="is-size-6">
                            <p>期間（終了）</p>
                        </div>
                    </td>
                    <td>
                        <div class="select is-primary is-small">
                            <select name="end_year"><?php echo $strEndYearSelOpt;?></select>
                        </div>
                    </td>
                    <td>
                        <div class="select is-primary is-small">
                            <select name="end_month"><?php echo $strEndMonthSelOpt;?></select>
                        </div>
                    </td>
                    <td>
                        <div class="select is-primary is-small">
                            <select name="end_day"><?php echo $strEndDaySelOpt;?></select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="is-size-6">
                            <p>設計予定機種名</p>
                        </div>
                    </td>
                    <td colspan="8">
                        <div class="select is-primary is-small">
                            <select name="ref_device"><?php echo $strDeviceSelOpt;?></select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="is-size-6">
                            <p>担当者</p>
                        </div>
                    </td>
                    <td colspan="8">
                        <div class="select is-primary is-small">
                            <select name="user"><?php echo $strUserSelOpt;?></select>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="field is-grouped">
<!---
                <div class="control">
                    <input class="button has-background-grey-lighter" type="reset" value="取消">
                </div>
--->
                <div class="control">
                    <input class="button is-success ml-4" type="submit" name="btn" value="表示">
                </div>
            </div>
        </form>

        <hr>

        <table class="table">
            <tr>
                <td>時間合計</td>
                <td><?php echo $strTimeSum;?></td>
            </tr>
            <tr>
                <td>工数合計</td>
                <td><?php echo $strManhoursSum;?></td>
            </tr>
        </table>

        <table class="table">
            <?php echo $strResultTbl;?>
        </table>

    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>