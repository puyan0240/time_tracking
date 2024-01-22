<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    $format = "
        <div class=\"field\">
            <label class=\"label is-small\">結果表示</label>
            <div class=\"control\">
                <div class=\"select is-success\">
                    <select name=\"result\">
                        <option value=\"0\" selected>-----</option>
                        <option value=\"1\">対象</option>
                    </select>
                </div>
            </div>
        </div>";

    if ($_SESSION['auth']) {
        $strResultSel = $format;
    } else {
        $strResultSel = "";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>
    <div class="block ml-6 mr-6">
        <form action="work_add_done.php" method="POST">
            <div class="field">
                <label class="label is-small">作業番号 (4桁) ※必須</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="4" name="work_id" required>
                </div>
            </div>
            <div class="field">
                <label class="label is-small">作業名 ※必須</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="32" name="work_name" required>
                </div>
            </div>
            <?php echo $strResultSel; ?>
            <div class="field">
                <label class="label is-small">コメント</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="255" name="comment">
                </div>
            </div>
            <br>
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