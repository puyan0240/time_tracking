<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');


    //表示する「年月」を選択
    {
        if (isset($_POST['sel_month']))
            $selectedMonth = $_POST['sel_month'];
        else
            $selectedMonth = date('Y-m');


        //開始月
        $startMonth = date('2023-12');
        //
        $Month = date('Y-m');

        $format = "<option value=\"%s\" %s>%s</option>";
        $strMonth = "";
        while ($Month >= $startMonth) {
            if ($Month == $selectedMonth)
                $strSelected = "selected";
            else
                $strSelected = "";

            $strYYmm = date('Y年m月', strtotime($Month)); //YYYY年mm月 の文字列
            $strMonth .= sprintf($format, $Month, $strSelected, $strYYmm);

            //月:減算
            $date = strtotime($Month);
            $Month = date('Y-m', strtotime('-1 month', $date));
        }
    }


    //表示する担当者を選択 (※管理者権限のみ)
    if ($_SESSION['auth'] == 1) 
    {
        if (isset($_POST['sel_user'])) {
            $selUserId = $_POST['sel_user'];
        } else {
            $selUserId = $_SESSION['user_id'];
        }

        //ユーザー名一覧
        {
            $format = "<option value=\"%s\" %s>%s</option>";
            $strUserSelOpt = "";

            //DB TABLEから読み出し
            $tblName = "account_tbl";
            $ret = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
            if ($ret != FALSE) {
                foreach ($ret as $value) {

                    $strSelected = "";
                    if ($selUserId) {
                        if ($selUserId == $value['user_id']) {
                            $strSelected = "selected";
                        }   
                    }

                    $strUserSelOpt .= sprintf($format, $value['user_id'], $strSelected, $value['user_name']);
                }
            }
        }

        //SELECT文を作成
        {
            $format = "
            <div class=\"control\">
                <div class=\"select is-success is-small\">
                    <select name=\"sel_user\">
                        %s
                    </select>
                </div>
                <button type=\"submit\" class=\"button is-small has-background-grey-lighter\">選択</button>
            </div>";
    
            $strUserSel = sprintf($format, $strUserSelOpt);
        } 
    } else {
        $strUserSel = "";
        $selUserId = $_SESSION['user_id'];
    }


    //一覧表示
    {
        $strTbl = "";
        $dayFormat = "%s-%02d";
        $tableFormat = "
        <tr>
            <td hidden>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>";

        $timeSumTotal = $overtimeTotal = 0;

        for ($day = 1; $day <= 31; $day ++) {
            $strYYYYmmdd = sprintf($dayFormat, $selectedMonth, $day); //YYYY-mm-dd の文字列
            $strmmdd = date('m月d日', strtotime($strYYYYmmdd));  //mm月dd日 の文字列
            $timeSum = $overtime = 0;
            $strSum = $strOvertime = "-----";

            //DB TABLEの 要素名:値 になるよう連想配列を作成
            $whereKeyValue = [];
            $whereKeyValue['date']    = $strYYYYmmdd;
            $whereKeyValue['user_id'] = $selUserId;    

            //DBアクセス
            $tblName = "time_traking_tbl";
            $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
            if ($ret != FALSE) {
                foreach ($ret as $value) {
                    $timeSum += (int)$value['time'];
                    $timeSumTotal += $timeSum;
                }

                //勤務時間
                if ($timeSum > 0) {
                    $hour = (int)($timeSum / 60);
                    $min  = (int)($timeSum % 60);
        
                    $format = "%02d時間 %02d分";
                    $strSum = sprintf($format, $hour, $min);
                }

                //残業時間
                $overtime = $timeSum - (60*8);
                if ($overtime > 0) {
                    $hour = (int)($overtime / 60);
                    $min  = (int)($overtime % 60);
    
                    $strOvertime = sprintf($format, $hour, $min);

                    $overtimeTotal += $overtime;
                }  
            }
            $strTbl .= sprintf($tableFormat, $strYYYYmmdd, $strmmdd, $strSum, $strOvertime);
        }
    }

    //合計
    {
        $strSumTotal = $strOvertimeTotal = "-----";

        //勤務時間
        if ($timeSumTotal > 0)
        {
            {
                $hour = (int)($timeSumTotal / 60);
                $min  = (int)($timeSumTotal % 60);
            
                $format = "%02d時間 %02d分";
                $strSumTotal = sprintf($format, $hour, $min);
            }
    
            //残業時間
            if ($overtimeTotal > 0) {
                $hour = (int)($overtimeTotal / 60);
                $min  = (int)($overtimeTotal % 60);
        
                $strOvertimeTotal = sprintf($format, $hour, $min);
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
        <form action="" method="post">
            <table>
                <tr>
                    <td>
                        <div class="control">
                            <div class="select is-success is-small">
                                <select name="sel_month">
                                    <?php echo $strMonth; ?>
                                </select>
                            </div>
                            <button type="submit" class="button is-small has-background-grey-lighter">選択</button>
                        </div>
                    </td>
                    <td>&emsp;&emsp;&emsp;</td>
                    <td>
                        <?php echo $strUserSel; ?>
                    </td>

                </tr>
            </table>
        </form>
    </div>

    <div class="block ml-6">
        <table class="table" id="list_table">
            <tr>
                <th hidden></th>
                <th></th>
                <th>勤務時間</th>
                <th>残業時間</th>
            </tr>
            <?php echo $strTbl; ?>

        </table>
    </div>

    <div class="block ml-6">
        <table class="table" id="list_table">
            <tr>
                <td>勤務時間合計</td>
                <td><?php echo $strSumTotal;?></td>
            </tr>
            <tr>
                <td>残業時間合計</td>
                <td><?php echo $strOvertimeTotal;?></td>
            </tr>
        </table>
    </div>

    <script>
        let table = document.getElementById("list_table");
        for (let i = 0; i < table.rows.length; i ++) {
            for (let j = 0; j < table.rows[i].cells.length; j ++) {
                table.rows[i].cells[j].id = table.rows[i].cells[0].innerHTML;
                table.rows[i].cells[j].onclick = clicked;
            }
        }

        function clicked(e) {
            location = "time_add.php?date="+e.target.id;
        }
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>