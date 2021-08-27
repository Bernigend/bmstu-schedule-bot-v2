<?php

use app\bot\VkBot;
use app\core\Application;

require_once '../vendor/autoload.php';

Application::createInstance();

$event = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);

if (json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception ('Error during JSON event decoding: ' . json_last_error_msg() . '; Event: ' . print_r(file_get_contents('php://input'), true));
}

if (is_null($event)) {
    throw new Exception ('Decoded event is null...');
}

(new VkBot())->handle($event);
