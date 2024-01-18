<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $result = "削除できませんでした。";

    if ($_POST['key_word'] == "delete") { //削除用キーワード[delete]
        
        //DB TABLEの要素名リスト
        $paramKeyName = ['work_id'];
        $paramKeyValue = [];

        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($paramKeyName as $key) {
            $paramKeyValue[$key] = e($_POST[$key]);
        }

        //DB TBLを更新
        $tblName = "work_tbl";
        if (deleteTbl($tblName, $paramKeyValue) == TRUE) {
            $result = "削除しました。";
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
        <p><?php echo $result; ?></p>
    </div>
    <div class="block ml-6">
        <a href="work_list.php">作業項目へ</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "work_list.php";
        }, 1*1000);
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>