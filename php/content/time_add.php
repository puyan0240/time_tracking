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
        <form action="history_add_confirm.php" method="POST">
            <div class="field">
                <label class="label">日付</label>
                <div class="control">
                    <input class="input is-sucess" type="text" name="date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="field">
                <label class="label">マシン名</label>
                <div class="control">
                    <div class="select is-success">
                        <select name="item_idx">
                            <?php echo $strSelectItem; ?>

                        </select>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-narrow">
                    <label class="label">1回目</label>
                </div>
                <div class="column is-narrow">
                    <input class="input is-sucess" type="text" name="weight_1" required value="">
                </div>
                <div class="column is-narrow">kg</div>
                <div class="column is-narrow">
                    <input class="input is-sucess" type="text" name="count_1" required value="">
                </div>
                <div class="column is-narrow">回</div>
            </div>

            <div class="columns">
                <div class="column is-narrow">
                    <label class="label">2回目</label>
                </div>
                <div class="column is-narrow">
                    <input class="input is-sucess" type="text" name="weight_2" value="">
                </div>
                <div class="column is-narrow">kg</div>
                <div class="column is-narrow">
                    <input class="input is-sucess" type="text" name="count_2" value="">
                </div>
                <div class="column is-narrow">回</div>
            </div>

            <div class="columns">
                <div class="column is-narrow">
                    <label class="label">3回目</label>
                </div>
                <div class="column is-narrow">
                    <input class="input is-sucess" type="text" name="weight_3" value="">
                </div>
                <div class="column is-narrow">kg</div>
                <div class="column is-narrow">
                    <input class="input is-sucess" type="text" name="count_3" value="">
                </div>
                <div class="column is-narrow">回</div>
            </div>

            <br>
            <div class="field is-grouped">
                <div class="control">
                    <input class="button has-background-grey-lighter" type="reset" value="取消">
                </div>
                <div class="control">
                    <input class="button is-success ml-4" type="submit" value="登録確認">
                </div>
            </div>
        </form> 
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>