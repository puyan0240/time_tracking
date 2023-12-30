<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');
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
                <label class="label">作業番号 (4桁)</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="4" name="work_id" required>
                </div>
            </div>
            <div class="field">
                <label class="label">作業名</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="32" name="work_name" required>
                </div>
            </div>
            <div class="field">
                <label class="label">直接/間接</label>
                <div class="control">
                    <div class="select is-success">
                        <select name="direct">
                            <option value="0" selected>直接</option>
                            <option value="1">間接</option>
                        </select>
                    </div>
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