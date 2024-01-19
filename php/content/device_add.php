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
        <form action="device_add_done.php" method="POST">
            <div class="field">
                <label class="label">機種番号 ※必須</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="4" name="device_id" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Ver ※必須</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="2" name="ver" required>
                </div>
            </div>
            <div class="field">
                <label class="label">機種名 ※必須</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="32" name="device_name" required>
                </div>
            </div>
            <div class="field">
                <label class="label">コメント</label>
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