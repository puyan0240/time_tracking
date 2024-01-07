<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $result = "削除できませんでした。";

    if ($_POST['key_word'] == "delete") { //削除用キーワード[delete]

        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $paramKeyValue = [];
        $paramKeyValue['idx'] = (int)$_POST['idx'];

        //DB TBLを更新
        $tblName = "device_tbl";
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
        <a href="device_list.php">機種管理</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "device_list.php";
        }, 2*1000);
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>