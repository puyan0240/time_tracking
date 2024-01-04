<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');


    //「年」選択肢
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

            $strMonth .= sprintf($format, $Month, $strSelected, $Month);

            //月:減算
            $date = strtotime($Month);
            $Month = date('Y-m', strtotime('-1 month', $date));
        }
    }

    //一覧表示
    {
        $strTbl = "";
        $dayFormat = "%s-%02d";
        $tableFormat = "
        <tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>";

        for ($day = 1; $day <= 31; $day ++) {
            $strYYYYmmdd = sprintf($dayFormat, $selectedMonth, $day); //YYYY-mm-dd の文字列
            $strmmdd = date('m月d日', strtotime($strYYYYmmdd));  //mm月dd日 の文字列
            $timeSum = $overtime = 0;
            $strSum = $strOvertime = "-----";

            //DB TABLEの 要素名:値 になるよう連想配列を作成
            $whereKeyValue = [];
            $whereKeyValue['date']    = $strYYYYmmdd;
            $whereKeyValue['user_id'] = $_SESSION['user_id'];

            //DBアクセス
            $tblName = "time_traking_tbl";
            $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL);
            if ($ret != FALSE) {
                foreach ($ret as $value) {
                    $timeSum += (int)$value['time'];
                }

                //勤務時間
                if ($timeSum > 0) {
                    $hour = (int)($timeSum / 60);
                    $min  = (int)($timeSum % 60);
        
                    $format = "%d時間 %d分";
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
            $strTbl .= sprintf($tableFormat, $strmmdd, $strSum, $strOvertime);
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
            <div class="control">
                <div class="select is-success is-small">
                    <select name="sel_month">
                        <?php echo $strMonth; ?>
                    </select>
                </div>
                <button type="submit" class="button is-small has-background-grey-lighter">選択</button>
            </div>
        </form>
    </div>

    <div class="block ml-6">
        <table class="table" id="list_table">
            <tr>
                <th>年/月/日</th>
                <th>勤務時間</th>
                <th>残業時間</th>
            </tr>
            <?php echo $strTbl; ?>

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