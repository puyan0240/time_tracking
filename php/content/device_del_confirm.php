<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');
    
    $device_id = $ver = $device_name = "";
    $idx = (int)$_GET['idx'];

    //DB検索
    {       
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $whereKeyValue = [];
        $whereKeyValue['idx'] = (int)$idx;

        //DBアクセス
        $tblName = "device_tbl";
        $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
        if ($ret != FALSE) {
            foreach ($ret as $value) {
                $device_id   = $value['device_id'];
                $ver         = str_pad($value['ver'], 2, 0, STR_PAD_LEFT); //0埋めの2桁表示
                $device_name = $value['device_name'];
            }
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
        <p>削除しますか？</p>
    </div>

    <div class="block ml-6 mr-6">
        <form action="device_del_done.php" method="post">
            <input type="hidden" name="idx" value="<?php echo $idx;?>">

            <div class="field">
                <p>delete と入力してください</p>
                <div class="control">
                    <input class="input is-sucess" type="text" name="key_word">
                </div>
            </div>
            <div class="field is-grouped">
                <a href="<?php echo $strBack; ?>">
                    <span class="button has-background-grey-lighter">戻る</span>
                </a>
                <div class="control ml-6">
                    <input class="button is-danger" type="submit" value="削除実行">
                </div>
            </div>            
        </form>
    </div>

    <br>
    <div class="block ml-6">
        <table class="table" >
            <tr>
                <td>機種番号</td>
                <td><?php echo $device_id; ?></td>
            </tr>
            <tr>
                <td>Ver</td>
                <td><?php echo $ver; ?></td>
            </tr>
            <tr>
                <td>商品名:</td>
                <td><?php echo $device_name;?></td>
            </tr>
        </table>
    </div>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>