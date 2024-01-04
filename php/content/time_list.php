<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');


    //「年」選択肢
    {
        if (isset($_POST['sel_year']))
            $selectedMonth = $_POST['sel_year'];
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

            //月:減算
            $strMonth .= sprintf($format, $Month, $strSelected, $Month);
            $date = strtotime($Month);
            $Month = date('Y-m', strtotime('-1 month', $date));
        }
    }

    //一覧表示
    {
        $strTbl = "";

        //DB TABLEから読み出し
        $tblName = "work_tbl";
        $ret = readTbl($tblName, NULL, NULL, NULL, NULL);
        if ($ret != FALSE) {

            $format = "
            <tr>
                <td>%04d</td>
                <td>%s</td>
                <td>%s</td>
            </tr>";

            //HTML作成
            foreach ($ret as $value) {
                $strTbl .= sprintf($format, $value['work_id'], $value['work_name'], $value['direct']);
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
            <div class="control">
                <div class="select is-success is-small">
                    <select name="sel_year">
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
                <th>作業番号</th>
                <th>作業名</th>
                <th>直接/間接</th>
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
            location = "work_detail.php?work_id="+e.target.id;
        }
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>