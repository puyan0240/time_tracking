<?php

#-----------------------------------------------------------
# DBアクセス関数
#-----------------------------------------------------------
function getDb() : PDO {
    //環境変数(.env)からユーザーIDとパスワード取得
    {
        require dirname(__FILE__).'/../vendor/autoload.php'; //vendorディレクトリの階層を指定する
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/..'); //.envの階層を指定する
        $dotenv->load();

        $dbName = $_ENV['DB_NAME'];     //DB名
        $host   = $_ENV['DB_HOST'];     //ホスト
        $user   = $_ENV['USER_ID'];     //ユーザー名
        $passwd = $_ENV['USER_PASS'];   //ユーザーパスワード
    }

   //データベースへのアクセス
    try
    {
        $format = 'mysql:dbname=%s; host=%s; charset=utf8';
        $dsn = sprintf($format, $dbName, $host);

        $db = new PDO($dsn, $user, $passwd);
        return $db;
    }
    catch (PDOException $e)
    {
        echo "接続エラー:".$e->getMessage();
        return null;
    }
}


#-----------------------------------------------------------
# TBLから取得 (SELECT)
#-----------------------------------------------------------
function readTbl($tblName, $whereKeyValue, $order, $joinTblName, $on) {

    $result = FALSE;
    $outValue = [];
    $strParam = "";

    //DB接続
    $db = getDb();
    if ($db != null) {

        if ($whereKeyValue != NULL) { //検索条件あり
            //引数の連想配列は、テーブルの 要素名:値 になっている
            $count = 0;
            foreach ($whereKeyValue as $key => $value) {
                if ($count != 0)
                    $strParam .= " AND "; //複数の場合はAND条件で繋ぐ
                $strParam .= ($key."=:".$key);

                $count ++;
            }
        }
        else { //全検索
            $strParam = '1';
        }

        //TBLから取得
        try {
            if ($joinTblName == NULL) {
                $format = 'SELECT * FROM %s WHERE %s %s';
                $strSql = sprintf($format, $tblName, $strParam, $order);
            } else {
                $format = 'SELECT * FROM %s JOIN %s ON %s WHERE %s %s';
                $strSql = sprintf($format, $tblName, $joinTblName , $on, $whereKeyValue, $order);
            }            
            //echo $strSql;
            
            $stt = $db->prepare($strSql);

            //削除条件ありの場合はWHEREのバインド設定
            if ($whereKeyValue != NULL) {
                $format = ':%s';
                foreach ($whereKeyValue as $key => $value) {
                    $strBindName = sprintf($format, $key);
                    $stt->bindValue($strBindName, $value);
                }
            }
            $stt->execute();

            $result = TRUE;
        }
        catch (PDOException $e) {

            $result = FALSE;
        }

        //DB切断
        $db = null;

        //取得結果を順番に取り出す
        if ($result == TRUE) {
            while (TRUE) {
                $rec = $stt->fetch(PDO::FETCH_ASSOC); //連想配列で
                if ($rec == FALSE)
                    break; //終了

                $outValue[] = $rec; //連想配列型の2次元配列で結果を格納
            }
            //var_dump($outValue);
        }
    }

    if ($result == TRUE)
        return $outValue;
    else
        return FALSE;
}


#-----------------------------------------------------------
# TBLから条件にあった件数を取得 (SELECT)
#-----------------------------------------------------------
function getNumberOfEntryTbl($tblName, $where, $count) {
 
    //DB接続
    $db = getDb();
    if ($db != null) {

        //TBLから取得
        try {
            $format = 'SELECT COUNT(%s) FROM %s WHERE %s';

            if ($where == NULL)
                $strSql = sprintf($format, $count, $tblName, "1");
            else
                $strSql = sprintf($format, $count, $tblName, $where);
            
            //echo $strSql."<br>";
            
            $stmt = $db->prepare($strSql);
            $stmt->execute();
            $result = $stmt->fetchColumn();
        }
        catch (PDOException $e) {

            $result = FALSE;
        }
        //DB切断
        $db = null;

        return $result;
    }
}



#-----------------------------------------------------------
# テーブルに新規追加 (INSERT INTO)
#-----------------------------------------------------------
function writeTbl($tblName, $keyValue) {

    $result = FALSE;

    //DBアクセス
    $db = getDb();
    if ($db != null) {

        $str_tblElement = "";
        $str_bindName = "";

        //引数の連想配列は、テーブルの 要素名:値 になっている
        foreach ($keyValue as $key => $value) {
            $str_tblElement .= ($key.",");
            $str_bindName .= (":".$key.",");
        }
        $str_tblElement = rtrim($str_tblElement, ",");
        $str_bindName = rtrim($str_bindName, ",");
 
        //SQLのINSERT INTOを行う
        try {
            $format = 'INSERT INTO %s(%s) VALUES(%s)';
            $str_sql = sprintf($format, $tblName, $str_tblElement, $str_bindName);
            $stt = $db->prepare($str_sql);
 
            $format = ':%s';
            foreach ($keyValue as $key => $value) {
                $str_bindName = sprintf($format, $key);
                $stt->bindValue($str_bindName, $value);
            }
            $stt->execute();

            $result = TRUE;
        }
        catch (PDOException $e) {
            echo "err:".$e->getMessage()."<br>";

            $result = FALSE;
        }

        //DB解放
        $db = null;
    }

    return $result;
}


#-----------------------------------------------------------
# TBLを更新 (UPDATE)
#-----------------------------------------------------------
function updateTbl($tblName, $elementkeyValue, $paramKeyValue) {

    $result = FALSE;

    $strElement = "";
    $strParam = "";

    //DBアクセス
    $db = getDb();
    if ($db != null) {

        $strElement = "";

        //引数の連想配列は、テーブルの 要素名:値 になっている
        foreach ($elementkeyValue as $key => $value) {
            $strElement .= ($key."=:".$key.",");
        }
        $strElement = rtrim($strElement, ",");
        foreach ($paramKeyValue as $key => $value) {
            $strParam .= ($key."=:".$key.",");
        }
        $strParam = rtrim($strParam, ",");
    
        //SQLのUPDATEを行う
        try {
            $format = 'UPDATE %s SET %s WHERE %s';
            $strSql = sprintf($format, $tblName, $strElement, $strParam);
            //echo $strSql;

            $stt = $db->prepare($strSql);
 
            $format = ':%s';
            //SETのバインド設定
            foreach ($elementkeyValue as $key => $value) {
                $strBindName = sprintf($format, $key);
                $stt->bindValue($strBindName, $value);
            }
            //WHEREのバインド設定
            foreach ($paramKeyValue as $key => $value) {
                $strBindName = sprintf($format, $key);
                $stt->bindValue($strBindName, $value);
            }
            $stt->execute();

            $result = TRUE;
        }
        catch (PDOException $e) {
            echo "err:".$e->getMessage()."<br>";

            $result = FALSE;
        }

        //DB解放
        $db = null;
    }
    return $result;
}


#-----------------------------------------------------------
# TBLから削除 (UPDATE)
#-----------------------------------------------------------
function deleteTbl($tblName, $whereKeyValue) {

    $result = FALSE;

    $strParam = "";

    //DBアクセス
    $db = getDb();
    if ($db != null) {

        if ($whereKeyValue != NULL) { //削除条件あり
            //引数の連想配列は、テーブルの 要素名:値 になっている
            $count = 0;
            foreach ($whereKeyValue as $key => $value) {
                if ($count != 0)
                    $strParam .= " AND "; //複数の場合はAND条件で繋ぐ
                $strParam .= ($key."=:".$key);

                $count ++;
            }
        }
        else { //全削除
            $strParam = '1';
        }

        //SQLのUPDATEを行う
        try {
            $format = 'DELETE FROM %s WHERE %s';
            $strSql = sprintf($format, $tblName, $strParam);
            $stt = $db->prepare($strSql);
 
            //削除条件ありの場合はWHEREのバインド設定
            if ($whereKeyValue != NULL) {
                $format = ':%s';
                foreach ($whereKeyValue as $key => $value) {
                    $strBindName = sprintf($format, $key);
                    $stt->bindValue($strBindName, $value);
                }
            }
            $stt->execute();

            //全削除時はAuto Incrementをクリアする
            if ($whereKeyValue == NULL) {
                    $format = 'ALTER TABLE %s auto_increment = 1';
                    $strSql = sprintf($format, $tblName);
                    $stt = $db->prepare($strSql);
                    $stt->execute();
            }

            $result = TRUE;
        }
        catch (PDOException $e) {
            echo "err:".$e->getMessage()."<br>";

            $result = FALSE;
        }

        //DB解放
        $db = null;
    }
    return $result;
}


?>