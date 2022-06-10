<!DOCTYPE html>
<html>
<head>
    <title>PHP-Proxy</title>
    <meta name="generator" content="php-proxy.com">
    <meta name="version" content="<?= $version; ?>">
    <link rel="stylesheet" href="https://classless.de/classless.css">
</head>

<body>

<nav>
    <ul>
        <li>
            <strong>PHP-Proxy</strong>
        </li>
        <li><a href="index.php">Home </a></li>
        <li><a href="#">More ▾</a>
            <ul>
                <li><a href="https://github.com/Athlon1600/php-proxy-app" target="_blank" title="Visit PHP-Proxy Project on GitHub">GitHub</a></li>
            </ul>
        </li>
    </ul>
</nav>

<main>
    <?php
    if (isset($error_msg)) { ?>
        <blockquote class="warn">
            <p><b>⚠ Warning</b></p>
            <p>
                <?= strip_tags($error_msg) ?>
            </p>
        </blockquote>
    <?php
    } ?>


    <!-- I wouldn't touch this part -->

    <form action="index.php" method="post">

        <div class="row">
            <div class="col">
                <input name="url" type="url" autocomplete="off" placeholder="https://" required />

                <div>
                    <input id="new_tab" type="checkbox" value="yes">
                    <label for="new_tab">In new Tab</label>
                </div>

            </div>
            <div class="col-2">
                <input type="submit" value="Go"/>
            </div>
        </div>



    </form>

    <script type="text/javascript">

        const form = document.querySelector('form');

        /**
         * Autofocus the URL Form
         */
        document.querySelector('input[type="url"').focus();

        /**
         * New Tab?
         */
        form.addEventListener('submit', function (evt) {
            evt.preventDefault();

            if (form.querySelector('input#new_tab').checked) {
                // New Tab
                form.setAttribute('target', '_blank');
            } else {
                form.setAttribute('target', '_self');
            }


            form.submit();
        }, true)
    </script>

    <!-- [END] -->

    <h2>
        Mini F.A.Q.
    </h2>

    <details>
        <summary>What is the PHP-Proxy?</summary>
        <p>
            Web proxy application project powered by PHP-Proxy library
        </p>
    </details>


</main>

<footer>
    <p class="text-right">
        Powered by <a href="//www.php-proxy.com/" target="_blank">PHP-Proxy <?= $version ?> </a> (PHP <?= PHP_VERSION ?>)
    </p>
</footer>


</body>
</html>