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

        $inputArray = [];
        $inputName = ['device_tbl_idx', 'ref_device_tbl_idx', 'work_id','hour','min'];
    
        //POST値を取得
        for ($i = 0; $i < 12; $i ++) {

            //Inputキーリスト
            $value = [];

            //Input値を取り出す
            foreach ($inputName as $name) {
                $format = "%s%02s";
                $strTmp = sprintf($format, $name, $i);
                if (isset($_POST[$strTmp])) {
                    $value[$name] = $_POST[$strTmp];
                }
            }

            $inputArray[$i] = $value;
        }

        //同じ機種&作業なら纏める
        for ($i = 0; $i < 12; $i ++) {
            if (($inputArray[$i]['hour'] == 0) && ($inputArray[$i]['min'] == 0)) {
                continue; //登録なし
            } else {
                for ($j = $i+1; $j < 12; $j ++) {
                    if (($inputArray[$j]['hour'] == 0) && ($inputArray[$j]['min'] == 0)) {
                        continue; //登録なし
                    } else {
                        if ($inputArray[$i]['device_tbl_idx'] != $inputArray[$j]['device_tbl_idx']) {
                            continue; //違う
                        }
                        if ($inputArray[$i]['ref_device_tbl_idx'] != $inputArray[$j]['ref_device_tbl_idx']) {
                            continue; //違う
                        }
                        if ($inputArray[$i]['work_id'] != $inputArray[$j]['work_id']) {
                            continue; //違う
                        }

                        //纏める
                        $inputArray[$i]['hour'] += $inputArray[$j]['hour'];
                        $inputArray[$j]['hour'] = 0;

                        $inputArray[$i]['min']  += $inputArray[$j]['min']; 
                        $inputArray[$j]['min']  = 0;
                    }
                }
            }
        }

        foreach ($inputArray as $value) {
            if (($value['hour'] == 0) && ($value['min'] == 0)) {
                continue; //登録なし
            } else {
                //DB TABLEの 要素名:値 になるよう連想配列を作成
                $keyValue = [];
                $keyValue['date'] = $date;
                $keyValue['user_id'] = (int)$_SESSION['user_id'];
                $keyValue['device_tbl_idx'] = (int)($value['device_tbl_idx']);
                $keyValue['ref_device_tbl_idx'] = (int)($value['ref_device_tbl_idx']);
                $keyValue['work_id'] = (int)($value['work_id']);
                
                $time = (int)($value['hour']) * 60;
                $time += (int)($value['min']);
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
        }, 1*1000);
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>