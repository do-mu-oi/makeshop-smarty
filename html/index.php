<html>
<body>
<ul>
<?php
foreach (glob('theme/templates/{*.tpl}', GLOB_BRACE) as $filename) {
    if (is_file($filename)) {
        echo '<li><a href="makeshop.php?template=' . $filename . '">' . $filename . '</a></li>';
    }
}
?>
</ul>
</body>
</html>