<?php
$action = filter_input(INPUT_GET, 'action');
switch ($action) {
    case 'show':
        include 'vues/post.php';
        break;
}
