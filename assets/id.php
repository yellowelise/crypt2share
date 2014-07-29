<?php
session_start();
$sessions = array();

$path = realpath(session_save_path());
$files = array_diff(scandir($path), array('.', '..'));

foreach ($files as $file)
{
    $sessions[$file] = unserialize(file_get_contents($path . '/' . $file));
}

echo '<pre>';
print_r($sessions);
echo '</pre>';

?>
