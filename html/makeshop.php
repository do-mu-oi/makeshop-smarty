<?php
require_once('/app/vendor/smarty/smarty/libs/Smarty.class.php');

define('JSON_FILES', 'theme/data/{*.json}');
define('TEMPLATE_MODULES', 'theme/templates/module/{*.tpl}');
define('LEFT_DELIMITER', '<{');
define('RIGHT_DELIMITER', '}>');

function load_json($filename) {
    if (is_file($filename)) {
        $json = file_get_contents($filename);
        return json_decode($json, true);
    }

    return [];
}

function load_data($pattern) {
    $data = [];

    foreach (glob($pattern, GLOB_BRACE) as $filename) {
        if (is_file($filename)) {
            $json = load_json($filename);
            $data = array_merge($data, $json);
        }
    }

    return $data;
}

function load_modules($pattern) {
    $modules = [];
    $smarty = new Smarty();
    $smarty->left_delimiter = LEFT_DELIMITER;
    $smarty->right_delimiter = RIGHT_DELIMITER;
    $smarty->assign(load_data(JSON_FILES), null, true);

    foreach (glob($pattern, GLOB_BRACE) as $filename) {
        if (is_file($filename)) {
            preg_match('/([^\/]+).tpl$/i', $filename, $match);
            $id = $match[1];
            $modules[$id] = $smarty->fetch($filename);
        }
    }

    return $modules;
}

$data = array_merge(
    load_data(JSON_FILES),
    array('module'=>load_modules(TEMPLATE_MODULES))
);

$smarty = new Smarty();
$smarty->left_delimiter = LEFT_DELIMITER;
$smarty->right_delimiter = RIGHT_DELIMITER;
$smarty->assign($data, null, true);

if (isset($_GET['template'])) {
    $template = $_GET['template'];
    $smarty->display($template);
} else {
    header('Content-Type: text/plain; charset=utf-8');
    var_dump($data);
}
?>