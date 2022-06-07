<?php
require_once(realpath(dirname(__FILE__) . '/../entities/user.php'));
require_once(realpath(dirname(__FILE__) . '/../services/user_service.php'));

$userService = new UserService();

// Handle registration