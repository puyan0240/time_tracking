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
        <form action="account_add_done.php" method="POST">
            <div class="field">
                <label class="label is-small">社員番号</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="5" name="user_id" required>
                </div>
            </div>
            <div class="field">
                <label class="label is-small">名前</label>
                <div class="control">
                    <input class="input is-sucess" type="text" maxlength="32" name="user_name" required>
                </div>
            </div>
            <div class="field">
                <label class="label is-small">区分</label>
                <div class="control">
                    <div class="select is-success">
                        <select name="category">
                            <option value="0" selected>その他</option>
                            <option value="1">ハード</option>
                            <option value="2">ソフト</option>
                            <option value="3">検証</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label is-small">権限</label>
                <div class="control">
                    <div class="select is-success">
                        <select name="auth">
                            <option value="0" selected>一般</option>
                            <option value="1">管理者</option>
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