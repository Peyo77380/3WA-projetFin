</main>

<footer>
    coucou footer
</footer>
<?php
if (isset($meta['scriptName'])) {
    foreach ($meta['scriptName'] as $script) {
        echo '<script type="text/javascript" src="http://' . $_SERVER["HTTP_HOST"] . '/assets/js/' . $script . '.js"></script>';
    }
}

?>
</body>
</html>