<?php
/**
 * Crystal Events - Database Connection & Query Execution Helper
 */

require_once __DIR__ . '/../config.php';

// Disable default MySQLi exception throwing to allow custom error handling
mysqli_report(MYSQLI_REPORT_OFF);

$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
date_default_timezone_set(defined('TIMEZONE') ? TIMEZONE : "Asia/Kolkata");

// 30-minute idle session timeout enforcement
if (session_status() === PHP_SESSION_ACTIVE) {
    $now = time();
    if (isset($_SESSION['last_activity']) && ($now - $_SESSION['last_activity'] > 1800)) {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    } elseif (isset($_SESSION['email'])) {
        $_SESSION['last_activity'] = $now;
    }
}

/**
 * Execute a query with optional prepared statement parameters.
 * Automatically infers types if not provided.
 */
function db_execute($sql, $params = [], $types = "")
{
    global $conn;
    if (empty($params)) {
        return mysqli_query($conn, $sql);
    }

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("MySQL prepare error: " . mysqli_error($conn) . " in query: " . $sql);
        return false;
    }

    if (empty($types)) {
        $types = "";
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= "i";
            } elseif (is_float($param)) {
                $types .= "d";
            } else {
                $types .= "s";
            }
        }
    }

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    if (!mysqli_stmt_execute($stmt)) {
        error_log("MySQL execute error: " . mysqli_stmt_error($stmt) . " in query: " . $sql);
        mysqli_stmt_close($stmt);
        return false;
    }

    return $stmt;
}

function insert($sql, $params = [], $types = "")
{
    global $conn;
    $res = db_execute($sql, $params, $types);
    if ($res === false) {
        return false;
    }
    if ($res instanceof mysqli_stmt) {
        mysqli_stmt_close($res);
    }
    return $conn;
}

function num($sql, $params = [], $types = "")
{
    global $conn;
    $res = db_execute($sql, $params, $types);
    if ($res === false) {
        return 0;
    }
    if ($res instanceof mysqli_stmt) {
        $result = mysqli_stmt_get_result($res);
        $count = $result ? mysqli_num_rows($result) : 0;
        mysqli_stmt_close($res);
        return $count;
    }
    return mysqli_num_rows($res);
}

function sel($sql, $params = [], $types = "")
{
    $res = db_execute($sql, $params, $types);
    if ($res === false) {
        return false;
    }
    if ($res instanceof mysqli_stmt) {
        $result = mysqli_stmt_get_result($res);
        mysqli_stmt_close($res);
        return $result;
    }
    return $res;
}

function update($sql, $params = [], $types = "")
{
    $res = db_execute($sql, $params, $types);
    if ($res === false) {
        return false;
    }
    if ($res instanceof mysqli_stmt) {
        mysqli_stmt_close($res);
    }
    return true;
}

function delete($sql, $params = [], $types = "")
{
    $res = db_execute($sql, $params, $types);
    if ($res === false) {
        return false;
    }
    if ($res instanceof mysqli_stmt) {
        mysqli_stmt_close($res);
    }
    return true;
}

function send_mail($email, $title, $body)
{
    $headers = "From: Crystal Events <no-reply@crystalevents.com>\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/html; charset=UTF-8\r\n";
    if (@mail($email, $title, $body, $headers)) {
        return 1;
    }
    return 0;
}

function safe_html($val)
{
    return htmlspecialchars((string)($val ?? ''), ENT_QUOTES, 'UTF-8');
}

function safe_str($val)
{
    return (string)($val ?? '');
}
