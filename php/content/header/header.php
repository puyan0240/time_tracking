<?php
    require_once(dirname(__FILE__).'/../common/DbManager.php');


    //ログイン中の判定
    {
        session_start();
        session_regenerate_id(true); //認証IDを変更(乗っ取り対策)
        if (isset($_SESSION['login']) == false)
        {
            header('Location:login.php');
            exit();
        }
    }

    //権限によって表示を切り替える
    {
        $strItem = "";
        $strAuth = "";

        $format = "
                    <a class=\"navbar-item has-text-link\" href=\"branch.php?menu=%s\">
                        <span>%s</span>
                    </a>";
        if ($_SESSION['auth'] == 1) {
            $strItem = $strItem.sprintf($format, "item_list", "マシン管理");
            $strAuth = $strAuth.sprintf($format, "account_list", "アカウント管理");
        }
    }

    //Header作成
    {
        ob_start();
        include('header_html.php');
        $strHeader = ob_get_contents();
        ob_end_clean();
    }
?>