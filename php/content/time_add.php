<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //機種一覧
    {
        //DB TABLEから読み出し
        $tblName = "device_tbl";
        $device_list = readTbl($tblName, NULL, NULL, NULL, NULL);
    }

    //作業項目一覧
    {
        //DB TABLEから読み出し
        $tblName = "work_tbl";
        $work_list = readTbl($tblName, NULL, NULL, NULL, NULL);
    }


    {
        //時間
        {
            $strHourSelOpt = "";
            $format = "<option value=\"%s\" selected>%02s</option>";
            for ($i = 0; $i <= 12; $i ++) {
                $strHourSelOpt .= sprintf($format, $i, $i);
            }

            $format = 
            "<div class=\"field\">
                <div class=\"control\">
                    <div class=\"select is-success\">
                        <select name=\"hour\">
                            %s
                        </select>
                    </div>
                </div>
            </div>";
            $strHourSel = sprintf($format, $strHourSelOpt);
        }

        //分
        {
            $strMinSelOpt = "";
            $format = "<option value=\"%s\" selected>%02s</option>";
            for ($i = 0; $i < 60; $i = $i+15) {
                $strMinSelOpt .= sprintf($format, $i, $i);
            }

            $format = 
            "<div class=\"field\">
                <div class=\"control\">
                    <div class=\"select is-success\">
                        <select name=\"min\">
                            %s
                        </select>
                    </div>
                </div>
            </div>";
            $strMinSel = sprintf($format, $strMinSelOpt);

        }
    }

    /*
    var_dump($device_list);
    print("\n");
    var_dump($work_list);
    */
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>

    <div class="block ml-6 mr-6">
        <form action="time_add_done.php" method="POST">
  
            <div class="block ml-6">
                <table class="table" id="list_table">
                    <tr>
                        <th>機種</th>
                        <th>作業内容</th>
                        <th>時間</th>
                        <th>分</th>
                    </tr>

                    <?php echo $strHourSel; ?>
                    <?php echo $strMinSel; ?>
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