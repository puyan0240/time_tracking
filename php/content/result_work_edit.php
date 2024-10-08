<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    //DBを一旦すべて無効にしてから、指定したものを有効にする
    if (isset($_POST['bt_submit'])) {
        //DB TABLEから読み出し
        $tblName = "work_tbl";
        $workList = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
        if ($workList != FALSE) {

            //一旦すべて無効化
            foreach ($workList as $work) {
                $paramKeyValue = $elementKeyValue = [];
                $paramKeyValue['work_id'] = $work['work_id'];
                $elementKeyValue['result'] = 0;

                //DB更新
                $tblName = "work_tbl";
                updateTbl($tblName, $elementKeyValue, $paramKeyValue);
            }

            //指定したものを有効化
            if (isset($_POST['work_list'])) {
                foreach ($_POST['work_list'] as $value) {
                    $paramKeyValue = $elementKeyValue = [];
                    $paramKeyValue['work_id'] = $value;
                    $elementKeyValue['result'] = 1;

                    //DB更新
                    $tblName = "work_tbl";
                    updateTbl($tblName, $elementKeyValue, $paramKeyValue);
                }
            }
        }      
    }

     
    //HTML作成
    {
        $format = "
            <div class=\"control\">
                <label class=\"is-checkbox is-rounded\">
                    <input type=\"checkbox\" name=\"work_list[]\" value=\"%s\" %s>
                    <span>%s</span>
                </label>
            </div>";

        $strCheckBoxTbl = "";

        //DB TABLEから読み出し
        $tblName = "work_tbl";
        $workList = readTbl($tblName, NULL, NULL, NULL, NULL, NULL);
        if ($workList != FALSE) {

            $group = -1;
            foreach ($workList as $work) {
                if ($group == -1) { //初回
                    $group = (int)($work['work_id'] / 1000);

                    $strCheckBoxTbl .= "<tr><td>";
                } else {
                    if ($group != (int)($work['work_id'] / 1000)) {
                        $group = (int)($work['work_id'] / 1000);

                        $strCheckBoxTbl .= "</td></tr><tr><td>"; //別の行に
                    } else {
                        $strCheckBoxTbl .= "</td><td>"; //他のセルに
                    }
                }

                if ($work['result'] == 1) {
                    $strChecked = "checked";
                } else {
                    $strChecked = "";
                }
                $strCheckBoxTbl .= sprintf($format, $work['work_id'], $strChecked, $work['work_name']);
            }
            $strCheckBoxTbl .= "</td></tr>";
        }
    }

    //戻り先
    $strBack = $_SERVER['HTTP_REFERER'];
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>
 
    <div class="block ml-6">
        <a href="result.php"><p>戻る</p></a>
    </div>

    <div class="block ml-6">
        <form action="result_work_edit.php" method="POST">
            <table class="table">
                <?php echo $strCheckBoxTbl; ?>
            </table>

            <div class="field is-grouped">
                <div class="control">
                    <input class="button has-background-grey-lighter" type="reset" value="取消">
                </div>
                <div class="control">
                    <input class="button is-success ml-4" type="submit" name="bt_submit" value="登録">
                </div>
            </div>
        </form>        
    </div>



</body>
</html>