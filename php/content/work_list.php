<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');


    //一覧表示
    {
        if ($_SESSION['auth']) {
            $strResultTitle = "結果表示";
        } else {
            $strResultTitle = "";
        }

        $strTbl = "";

        //DB TABLEから読み出し
        $tblName = "work_tbl";
        $ret = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
        if ($ret != FALSE) {

            $format = "
            <tr>
                <td>%04d</td>
                <td>%s</td>
                <td>%s</td>
            </tr>";

            //HTML作成
            foreach ($ret as $value) {
                $strTbl .= sprintf($format, $value['work_id'], $value['work_name'], $value['comment']);
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
        <a href="work_add.php">
            <span class="button is-success ml-6">作業項目登録</span>
        </a>
    </div>

    <div class="block ml-6">
        <table class="table" id="list_table">
            <thead>
                <tr>
                    <td>作業番号</td>
                    <td>作業名</td>
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
            location = "work_detail.php?work_id="+e.target.id;
        }
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>