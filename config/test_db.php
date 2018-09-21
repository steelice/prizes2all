<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
// у нас нет пока тестов на изменение данных, поэтому для простоты используется продакшн, но так нельзя!
$db['dsn'] = 'mysql:host=localhost;dbname=prizes2all';

return $db;
