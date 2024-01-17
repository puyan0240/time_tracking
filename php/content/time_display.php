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


    //選択肢作成
    {
        //機種、関連機種
        {
            $deviceNameList = [];

            //DB TABLEから読み出し
            $tblName = "device_tbl";
            $order = "ORDER BY device_id DESC , ver ASC "; //機種番号は降順、Verは昇順が良い??
            $ret = readTbl($tblName, NULL, NULL, $order, NULL, NULL);
            if ($ret != FALSE) {
                foreach ($ret as $value) {
                    $deviceNameList[$value['idx']] = $value['device_name'];
                }
            }
        }

        //作業項目
        {
            $workNameList = [];

            //DB TABLEから読み出し
            $tblName = "work_tbl";
            $ret = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
            if ($ret != FALSE) {
                foreach ($ret as $value) {
                    $workNameList[$value['idx']] = $value['work_name'];
                }
            }
        }
    }


    //既に登録しているデータを表示
    {
        $strTbl = "";
        $count = 0;
    
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $whereKeyValue = [];
        $whereKeyValue['date'] = $date;
        $whereKeyValue['user_id'] = (int)($_SESSION['user_id']);

        //DB検索
        $tblName = "time_traking_tbl";
        $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
        if ($ret != FALSE) {
            foreach ($ret as $value) {
                $count ++;

                $strTmp = "<tr>";

                //機種
                $strTmp .= "<td>".$deviceNameList[$value['device_tbl_idx']]."</td>";

                //関連機種
                $strTmp .= "<td>".$deviceNameList[$value['ref_device_tbl_idx']]."</td>";

                //作業
                $strTmp .= "<td>".$workNameList[$value['work_id']]."</td>";

                //時間
                {
                    $time = $value['time'];

                    $hour = (int)($time / 60);
                    $min  = (int)($time % 60);

                    //時間
                    $strTmp .= "<td>".$hour."</td>";
                    //分
                    $strTmp .= "<td>".$min."</td>";
                }

                $strTmp .= "</tr>";
                $strTbl .= $strTmp;
            }
        }
        for ($i = $count; $i < 12; $i ++) {
            $strTbl .= "<tr><td> ----- </td><td> ----- </td><td> ----- </td><td> ----- </td></tr>";
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
                            <td align="center">※設計予定機種</td>
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

    <br>
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

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>