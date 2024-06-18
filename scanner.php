<?php
// Set unlimited execution time
set_time_limit(0);

// Increase memory limit
ini_set('memory_limit', '512M'); // Adjust as needed

// Continue executing even if the user disconnects
ignore_user_abort(true);

function scanDirectory($directory, &$results = []) {
    $files = scandir($directory);

    foreach ($files as $key => $value) {
        $path = realpath($directory . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (isPhpFile($path)) {
                $results[] = $path;
            }
        } else if ($value != "." && $value != "..") {
            scanDirectory($path, $results);
        }
    }

    return $results;
}

function isPhpFile($file) {
    $phpExtensions = ['php', 'php2', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'pht', 'phtm', 'phtml', 'pgif', 'shtml', 'htaccess', 'phar', 'inc', 'hphp', 'ctp', 'module'];
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    return in_array(strtolower($extension), $phpExtensions);
}

function containsSensitiveFunctions($fileContent, $sensitiveFunctions) {
    foreach ($sensitiveFunctions as $function) {
        if (preg_match('/\b' . preg_quote($function, '/') . '\b/i', $fileContent)) {
            return true;
        }
    }
    return false;
}

function logSensitiveFunctions($filePath, $fileContent, $sensitiveFunctions, $logFile) {
    $logMessages = [];

    foreach ($sensitiveFunctions as $function) {
        if (preg_match_all('/\b' . preg_quote($function, '/') . '\b/i', $fileContent, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $line = substr_count(substr($fileContent, 0, $match[1]), "\n") + 1;
                $logMessages[] = "File: $filePath | Line: $line | Sensitive function: $function";
            }
        }
    }

    if (!empty($logMessages)) {
        file_put_contents($logFile, implode(PHP_EOL, $logMessages) . PHP_EOL, FILE_APPEND);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['directory'])) {
    $directory = $_POST['directory'];
    $logFile = 'sensitive_functions_log.txt';
    $sensitiveFunctions = ['exec', 'shell_exec', 'system', 'passthru', 'eval', 'popen', 'proc_open', 'file_put_contents', 'fwrite', 'fopen', 'file_get_contents', 'unlink', 'rename', 'copy', 'move_uploaded_file', 'scandir', 'opendir', 'readdir'];

    if (file_exists($logFile)) {
        unlink($logFile); // Remove existing log file
    }

    $phpFiles = scanDirectory($directory);

    foreach ($phpFiles as $file) {
        $content = file_get_contents($file);
        if (containsSensitiveFunctions($content, $sensitiveFunctions)) {
            logSensitiveFunctions($file, $content, $sensitiveFunctions, $logFile);
        }
    }

    echo "Scanning completed. Check <a href='$logFile'>log file</a> for details.";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>simple PHP Shell scanner</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }
            .container {
                background: #fff;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                text-align: center;
            }
            h1 {
                margin: 0;
                padding: 20px 0;
            }
            form {
                margin: 20px 0;
            }
            input[type="text"] {
                padding: 10px;
                width: 80%;
                max-width: 400px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            button {
                padding: 10px 20px;
                border: none;
                background-color: #007BFF;
                color: white;
                border-radius: 4px;
                cursor: pointer;
            }
            button:hover {
                background-color: #0056b3;
            }
            .footer {
                margin-top: 20px;
                text-align: center;
            }
            .footer img {
                width: 150px;
            }
            .footer a {
                color: #007BFF;
                text-decoration: none;
            }
            .footer a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>simple PHP Shell scanner</h1>
            <form method="POST">
                <label for="directory">Enter directory to scan:</label><br>
                <input type="text" name="directory" id="directory" required><br>
                <button type="submit">Scan</button>
            </form>
        </div>
        <div class="footer">
            <p>Developed by OX Team</p>
            <a href="https://t.me/opsxteam">t.me/opsxteam</a><br>
            <a href="https://i.ibb.co/RbrW72w/ox.webp">
                <img src="https://i.ibb.co/RbrW72w/ox.webp" alt="OX Team Logo">
            </a>
        </div>
    </body>
    </html>
    <?php
}
?>
