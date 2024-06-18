# PHP Shell scanner

PHP Shell Scanner is a tool designed to scan directories recursively for PHP files and detect the usage of sensitive functions. This tool helps in identifying potential security risks in your PHP code by logging the occurrences of functions that can be used for malicious purposes.

## Features

- Scans directories recursively for PHP files.
- Detects files with a variety of PHP-related extensions.
- Identifies and logs the usage of sensitive functions such as `exec`, `eval`, `system`, and more.
- Provides an easy-to-use web interface for specifying the directory to scan.

## Sensitive Functions

The following functions are considered sensitive and are checked by this tool:
- `exec`
- `shell_exec`
- `system`
- `passthru`
- `eval`
- `popen`
- `proc_open`
- `file_put_contents`
- `fwrite`
- `fopen`
- `file_get_contents`
- `unlink`
- `rename`
- `copy`
- `move_uploaded_file`
- `scandir`
- `opendir`
- `readdir`

## Supported Extensions

This tool scans files with the following extensions:
- `.php`
- `.php2`
- `.php3`
- `.php4`
- `.php5`
- `.php6`
- `.php7`
- `.phps`
- `.pht`
- `.phtm`
- `.phtml`
- `.pgif`
- `.shtml`
- `.htaccess`
- `.phar`
- `.inc`
- `.hphp`
- `.ctp`
- `.module`

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/php-shell-scanner.git
    cd php-shell-scanner
    ```

2. Make sure you have a web server running with PHP support.

3. Place the `scanner.php` file in your web server's root directory or any accessible directory.

## Usage

1. Open your web browser and navigate to the location of `scanner.php` on your web server.

2. Enter the directory you want to scan in the input field and click the "Scan" button.

3. The tool will scan the specified directory recursively and log any occurrences of sensitive functions in a file named `sensitive_functions_log.txt`.

4. After the scan is complete, a link to the log file will be provided. Click the link to view the details.

## Example

Here's an example of how to use the PHP Shell Finder:

1. Navigate to `http://yourserver.com/php-shell-scanner/scanner.php` in your web browser.

2. Enter the path to the directory you want to scan (e.g., `/var/www/html`).

3. Click the "Scan" button.

4. After the scan completes, check the `sensitive_functions_log.txt` file for the results.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## CONTACT US

[opsx Team on Telegram](https://t.me/opsxteam)
