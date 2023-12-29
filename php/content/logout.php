<?php
    session_start();
    $_SESSION=array();
    if (isset($_COOKIE[session_name()]) == true) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<?php include(dirname(__FILE__).'/./header/head_html.php'); ?>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar-brand">
                <span class="navbar-item ml-6 is-size-7">おつかれさま</span>
            </div>
            <div class="navbar-menu">
        </div>
        </nav>
        <section class="hero is-info is-small">
            <div class="hero-body">
                <h1 class="title ml-6">Time Tracking</h1>
            </div>
        </section>
        <nav class="navbar has-background-info-light">
            <div class="navbar-menu ml-4" id="targetMenu"></div>
        </nav>
    </header>
    <br>
    <br>
    <div class="block ml-6">
        <p>ログアウトしました。</p>
    </div>
    <br><br>
    <div class="block ml-6">
        <a href="login.php">ログイン画面へ</a>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 2*1000);
    </script>

    <?php include(dirname(__FILE__).'/./header/bulma_burger.js'); ?>
</body>
</html>