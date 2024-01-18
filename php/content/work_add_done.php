<?php
    // Header部分共通
    require_once(dirname(__FILE__).'/./header/header.php');

    //e()用
    require_once(dirname(__FILE__).'/./common/Encode.php');


    $input_ok = false;

    //数値確認
    {
        if (is_numeric($_POST['work_id']) != true) {
            $result = "作業番号は数値で入力してください。";
        } elseif (mb_strlen($_POST['work_id']) != 4) {
            $result = "作業番号は4桁の範囲で入力してください。";
        } else {
            $work_id = e($_POST['work_id']);
            $input_ok = true;
        }
    }

    //２重登録の確認
    if ($input_ok == true)
    {      
        $work_id = e($_POST['work_id']);

        //DB検索
        {
            //DB TABLEの要素名リスト
            $whereKeyName = ['work_id'];
            $whereKeyValue = [];
        
            //DB TABLEの 要素名:値 になるよう連想配列を作成
            foreach ($whereKeyName as $key) {
                if ($key == 'work_id')
                    $whereKeyValue[$key] = (int)$work_id;
                else
                    $whereKeyValue[$key] = e($_POST[$key]);
            }

            //DBアクセス
            $tblName = "work_tbl";
            $ret = readTbl($tblName, $whereKeyValue, NULL, NULL, NULL, NULL);
            if ($ret != FALSE) {
                $result = "作業番号:".$work_id." は、既に登録されています。";
                $input_ok = false;
            }
        }
    }

    //登録
    if ($input_ok == true) {

        //DB TABLEの要素名リスト
        $keyName = ['work_id','work_name','direct','job_type'];
        $keyValue = [];
    
        //DB TABLEの 要素名:値 になるよう連想配列を作成
        foreach ($keyName as $key) {
            if (($key == 'work_id') || ($key == 'direct')) {
                $keyValue[$key] = (int)e($_POST[$key]);
            } elseif ($key == 'job_type') {
                $keyValue[$key] = 0;
            } else {
                $keyValue[$key] = e($_POST[$key]);
            }
        }
        
        //DB TABLEへ書き込み
        $tblName = "work_tbl";
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