<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $input_ok = false;

    //数値確認(機種番号)
    {
        if (is_numeric($_POST['device_id']) != true) {
            $result = "機種番号は数値で入力してください。";
        } elseif (mb_strlen($_POST['device_id']) != 4) {
            $result = "機種番号は4桁の範囲で入力してください。";
        } else {
            $device_id = e($_POST['device_id']);
            $input_ok = true;
        }
    }

    //数値確認(Ver)
    if ($input_ok == true)
    {
        if (is_numeric($_POST['ver']) != true) {
            $result = "Verは数値で入力してください。";
            $input_ok = false;
        } elseif (mb_strlen($_POST['ver']) != 2) {
            $result = "Verは2桁の範囲で入力してください。";
            $input_ok = false;
        } else {
            $ver = e($_POST['ver']);
        }
    }

    //２重登録の確認
    if ($input_ok == true)
    {    
        //DB検索
        $tblName = "device_tbl";
        $where   = "device_id='".$device_id."'"." and "."ver='".$ver."'";
        $ret = readTbl($tblName, $where, NULL, NULL, NULL);
        if ($ret != FALSE) {
            $result = "機種番号:".$device_id." Ver:".$ver."は、既に登録されています。";
            $input_ok = false;
        }
    }

    //登録
    if ($input_ok == true) {

        //DB TABLEの要素名リスト
        $keyName = ['device_id','ver','device_name'];
        $keyValue = [];
    
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($keyName as $key) {
            if ($key == 'ver') {
                $keyValue[$key] = (int)e($_POST[$key]);
            } else {
                $keyValue[$key] = e($_POST[$key]);
            }
        }
        
        //DB TABLEへ書き込み
        $tblName = "device_tbl";
        if (writeTbl($tblName, $keyValue) == TRUE) {
            $result = "登録しました。";
        } else {
            $result = "登録が失敗しました。";
        }    
    }
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <?php echo $strHeader; ?>
    <br>
    <br>
    <div class="block ml-6">
        <p><?php echo $result; ?></p>
    </div>
    <div class="block ml-6">
        <a href="device_list.php">機種管理へ</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "device_list.php";
        }, 2*1000);
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>