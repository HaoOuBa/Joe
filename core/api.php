<?php

$_requestType = _getParam('type');

switch ($_requestType) {
    case 'getRank':
        _getRank();
        break;
}

function _getRank()
{
}

function _getParam($key, $default = '')
{
    return trim($key && is_string($key) ? (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default)) : $default);
}

function _echoJson($data = null, $code = 1)
{
    die(array(
        "code" => $code,
        "data" => $data
    ));
}
