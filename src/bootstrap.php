<?php
/**
 * Puml
 *
 * PHP Version 5.3
 *
 * @category  Puml
 * @package   Puml
 * @author    Danny van der Sluijs <danny.vandersluijs@fleppuhstein.com>
 * @copyright 2012 Danny van der Sluijs <www.fleppuhstein.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

$files = array(
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php'
);

foreach ($files as $file) {
    if (is_readable($file)) {
        $loader = include($file);
        break;
    }
}

if (!$loader) {
    die(
        'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
}

return $loader;
