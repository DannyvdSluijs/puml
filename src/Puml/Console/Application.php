<?php
/**
 * Puml
 *
 * PHP Version 5.3
 *
 * @category  Puml
 * @package   Puml\Console
 * @author    Danny van der Sluijs <danny.vandersluijs@fleppuhstein.com>
 * @copyright 2012 Danny van der Sluijs <www.fleppuhstein.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Puml\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Puml\Command;

/**
 * The puml application
 */
class Application extends BaseApplication
{
    /**
     * Constructor
     *
     * @since 0.1
     */
    public function __construct()
    {
        parent::__construct('Puml', '1.0');

        $this->addCommands(
            array(
                new Command\Generate()
            )
        );
    }
}
