<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $user_id = $_SESSION['user_id'];
    $date    = e($_POST['date']);


    //当日データを一旦削除する
    {              
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        $whereKeyValue = [];
        $whereKeyValue['date']    = $date;
        $whereKeyValue['user_id'] = (int)$user_id;

        //DBアクセス
        $tblName = "time_traking_tbl";
        deleteTbl($tblName, $whereKeyValue, NULL, NULL, NULL);
    }

    //登録
    {
        $result = "登録しました。";

        for ($i = 0; $i < 12; $i ++) {

            //Inputキーリスト
            $InputName = ['device_tbl_idx','work_id','hour','min'];
            $InputValue = [];

            //Input値を取り出す
            for ($j = 0; $j < 4; $j ++) {
                $format = "%s%02s";
                $strTmp = sprintf($format, $InputName[$j], $i);

                $InputValue[] = $_POST[$strTmp];
            }

            //作業時間が登録されている場合はDBへ登録する
            if (($InputValue[2] == 0) && ($InputValue[3] == 0)) {
                continue; //登録なし
            } else {
                //DB TABLEの 要素名:値 になるよう連想配列を作成
                $keyValue = [];
                $keyValue['date'] = $date;
                $keyValue['user_id'] = (int)$_SESSION['user_id'];
                $keyValue['device_tbl_idx'] = (int)($InputValue[0]);
                $keyValue['work_id'] = (int)($InputValue[1]);
                $keyValue['ref_device_tbl_idx'] = 0; //

                $time = (int)($InputValue[2]) * 60;
                $time += (int)($InputValue[3]);
                $keyValue['time'] = $time;


                //DB TABLEへ書き込み
                $tblName = "time_traking_tbl";
                if (writeTbl($tblName, $keyValue) == TRUE) {
                    ;
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

    <script>
        setTimeout(function() {
            window.location.href = "time_add.php";
        }, 2*1000);
    </script>
    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>