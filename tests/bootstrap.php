<?php

ini_set('display_errors', TRUE);
ini_set('html_errors', FALSE);

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../Goodreads/Classes/ApiClass.php';
require __DIR__ . '/../Goodreads/Classes/BaseClass.php';
require __DIR__ . '/../Goodreads/Classes/User.php';
require __DIR__ . '/../Goodreads/ClassGetter.php';
require __DIR__ . '/../Goodreads/Goodreads.php';

require __DIR__ . '/test_classes.php';

return new Goodreads\Goodreads('b1eQdQi14rjRJBqp1cbQ');
