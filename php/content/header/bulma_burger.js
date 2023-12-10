<script>
    document.addEventListener('DOMContentLoaded', () => {

    // ナビゲーションバーガー（navbar-burgerクラスを持つすべての要素）を取得します。
    const $navbarBurgers = document.querySelectorAll('.navbar-burger');

    // ナビゲーションバーガーがあるかどうかを確認します。
    if ($navbarBurgers.length > 0) {

        // すべてのナビゲーションバーガーをループします。
        $navbarBurgers.forEach( el => {

            // ナビゲーションバーガーにクリックイベントを追加します。
            el.addEventListener('click', () => {

                // ナビゲーションバーガーのdata-target属性の値を取得します。
                const target = el.dataset.target;
                // メニュー（data-target属性の値をIDとして持つ要素）を取得します。
                const $target = document.getElementById(target);

                // ナビゲーションバーガーでis-activeクラスを切り替えます。
                el.classList.toggle('is-active');
                // メニューでis-activeクラスを切り替えます。
                $target.classList.toggle('is-active');
                });
            });
        }
    });
</script>