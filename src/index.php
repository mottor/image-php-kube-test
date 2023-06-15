<?php

if ($_SERVER['REQUEST_URI'] == '/info') {
    phpinfo();
    exit;
}

if ($_SERVER['REQUEST_URI'] == '/db') {
    try {
        $sql = "SELECT * from devops_users";
        $host = $_ENV['MYSQL_HOST'];
        $user = $_ENV['MYSQL_USER'];
        $pass = $_ENV['MYSQL_PASS'];
        $dbname = $_ENV['MYSQL_DBNAME'];

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "ifconfig.co");
//        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, [
//            'Accept: application/json',
//        ]);
//        $raw = curl_exec($ch);
//        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//        curl_close($ch);
//        echo "Host IP: $raw<br/>";

        echo "Query: $sql<br/>";

        $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        echo "Connected.<br/>";

        echo "<strong>Result</strong>:<br/>";
        foreach ($dbh->query($sql) as $row) {
            echo '<pre>' . print_r($row, true) . '</pre>';
        }
        $dbh = null;
        echo "DONE<br/>";
    } catch (PDOException $e) {
        print "Error: #" . $e->getCode() . " " . $e->getMessage() . "<br/>";
    }
    exit;
}

function getClientIp()
{
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $v = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $e = preg_split('#\s*,\s*#', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $v = $e[0];
    } else {
        $v = $_SERVER['REMOTE_ADDR'];
    }
    return trim($v, ', ');
}

echo "<h1>This is PHP app</h1>";
echo "Current Host: <code>" . gethostname() . "</code><br/>";
echo "Current PHP version: " . phpversion() . "<br/>";
echo "Your IP: " . getClientIp() . "<br/>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br/>";
echo "ENV variable WP_WT_MYSQL_DB: " . $_ENV['WP_WT_MYSQL_DB'] . " " . ($_ENV['WP_WT_MYSQL_DB'] == 'wordpress' ? '✅' : '❌') . "<br/>";

echo '<pre>';
var_dump([
    'HTTP_CLIENT_IP' => $_SERVER['HTTP_CLIENT_IP'] ?? null,
    'HTTP_X_FORWARDED_FOR' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
    'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'] ?? null,
]);
echo '</pre></br>';