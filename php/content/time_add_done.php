<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    //登録
    {
        for ($i = 0; $i < 12; $i ++) {

            //Inputキーリスト
            $InputName = ['device_id','work_id','hour','min'];
            $inputValue = [];

            //Input値を取り出す
            for ($j = 0; $j < 4; $j ++) {
                $format = "%s%02s";
                $strTmp = sprintf($format, $InputName[$j], $i);

                $inputValue[] = $_POST[$strTmp];
            }

            //作業時間が登録されている場合はDBへ登録する
            if (($inputValue[2] != 0) || ($inputValue[3] != 0)) {

                //DB TABLEの要素名リスト
                $keyName = ['date','user_id','device_id','work_id','time'];
                $keyValue = [];

                //DB TABLEの 要素名:値 になるよう連想配列を作成
                foreach ($keyName as $key) {
                    if ($key == 'date') {
                        $keyValue[$key] = date('y-m-d');
                    } elseif ($key == 'user_id') {
                        $keyValue[$key] = (int)$_SESSION['user_id'];
                    } elseif ($key == 'device_id') {
                        $keyValue[$key] = (int)($inputValue[0]);
                    } elseif ($key == 'work_id') {
                        $keyValue[$key] = (int)($inputValue[1]);
                    } elseif ($key == 'time') { //時間
                        $time = (int)($inputValue[2]) * 60;
                        $time += (int)($inputValue[3]);

                        $keyValue[$key] = $time;
                    } else {
                    }
                }

                //DB TABLEへ書き込み
                $tblName = "time_traking_tbl";
                if (writeTbl($tblName, $keyValue) == TRUE) {
                    $result = "登録しました。";
                } else {
                    $result = "登録が失敗しました。";
                }    
            }
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
        <a href="time_add.php">時間登録へ</a>
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