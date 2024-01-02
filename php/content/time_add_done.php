<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $date = date('y-m-d');
    var_dump($date);

    $result = "登録が失敗しました。";

    //var_dump($_POST);


    //登録
    {
        //Inputキーリスト
        $InputName = ['device_id','work_id','hour','min']; 

        //DB TABLEの要素名リスト
        $keyName = ['date','user_id','device_id','work_id','time'];
        $keyValue = [];
    
        //print($keyName[0]);
        //rint($keyName[2]);

        $format = "%s%02s";
        for ($i = 0; $i < 12; $i ++) {
            $strDevId = sprintf($format, $InputName[0], $i);
            $strWrkId = sprintf($format, $InputName[1], $i);
            $strHour  = sprintf($format, $InputName[2], $i);
            $strMin   = sprintf($format, $InputName[3], $i);

            print($strTmp);

            print($_POST[$strTmp]);
        
        }
    /*
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($keyName as $key) {
            if ($key == 'user_id') {
                $keyValue[$key] = (int)e($_POST[$key]);
            } elseif ($key == 'auth') {
                $keyValue[$key] = (int)e($_POST[$key]);
            } elseif ($key == 'type') {
                //$keyValue[$key] = (int)e($_POST[$key]);
                $keyValue[$key] = 0;
            } elseif ($key == 'passwd') {
                $keyValue[$key] = $passwd_hash;
            } else {
                $keyValue[$key] = e($_POST[$key]);
            }
        }
        
        //DB TABLEへ書き込み
        $tblName = "account_tbl";
        if (writeTbl($tblName, $keyValue) == TRUE) {
            $result = "登録しました。";
        } else {
            $result = "登録が失敗しました。";
        }    
    */
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
        <a href="account_list.php">アカウント管理へ</a>
    </div>
<!--
    <script>
        setTimeout(function() {
            window.location.href = "time_add.php";
        }, 2*1000);
    </script>
    -->
    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>