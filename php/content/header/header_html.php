<header>
    <nav class="navbar">
        <div class="navbar-brand">
            <span class="navbar-item ml-6 is-size-7"><?php echo $_SESSION['user_name']; ?> さん</span>
            <a class="navbar-item" href="logout.php">
                    <span class="button is-light is-size-7 ml-4">ログアウト</span>
                </a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="targetMenu">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
<!---
        <div class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="login_passwd.php">
                    <span class="button is-outlined is-size-7 mr-6">パスワード変更</span>
                </a>

            </div>
        </div>
--->
    </nav>
    <section class="hero is-info is-small">
        <div class="hero-body">
            <a href="index.php">
                <h1 class="title ml-6">Time Tracking</h1>
            </a>
        </div>
    </section>
    <nav class="navbar has-background-info-light">
        <div class="navbar-menu ml-6" id="targetMenu">
            <div class="navbar-start">
                <a class="navbar-item has-text-link" href="branch.php?menu=history_list">
                    <span>一覧表示</span>
                </a>
                <a class="navbar-item has-text-link" href="branch.php?menu=search">
                    <span>検索</span>
                </a>
                <?php echo $strItem; ?>
                <?php echo $strAuth; ?>
            </div>
        </div>
    </nav>
</header>