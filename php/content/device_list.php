<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');


    //一覧表示
    {
        $strTbl = "";

        //DB TABLEから読み出し
        $tblName = "device_tbl";
        $order   = "ORDER BY device_id DESC , ver ASC "; //ID降順,Ver昇順
        $ret = readTbl($tblName, NULL, NULL, $order, NULL, NULL);
        if ($ret != FALSE) {

            $format = "
            <tr>
                <td hidden>%d</td>
                <td>%04d</td>
                <td>%02s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>";

            //HTML作成
            foreach ($ret as $value) {
                $strDisplay = "---";
                if ($value['display'] == 1) {
                    $strDisplay = "表示";
                }
                $strTbl .= sprintf($format, $value['idx'], $value['device_id'], $value['ver'], $value['device_name'], $strDisplay, $value['comment']);
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

    <div class="block">
        <a href="device_add.php">
            <span class="button is-success ml-6">機種登録</span>
        </a>
    </div>

    <div class="block ml-6">
        <table class="table" id="list_table">
            <thead>
                <tr>
                    <td hidden></td>
                    <td>機種番号</td>
                    <td>Ver</td>
                    <td>機種名</td>
                    <td>表示</td>
                    <td>コメント</td>
                </tr>
            </thead>
            <tbody>
                <?php echo $strTbl; ?>
            </tbody>
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
            location = "device_detail.php?idx="+e.target.id;
        }
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>