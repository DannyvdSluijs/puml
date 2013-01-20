<?php
/**
 * Puml
 *
 * PHP Version 5.3
 *
 * @category  Puml
 * @package   Puml\Transformer
 * @author    Danny van der Sluijs <danny.vandersluijs@fleppuhstein.com>
 * @copyright 2012 Danny van der Sluijs <www.fleppuhstein.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Puml\Transformer;

interface Transformer
{
    /**
     * Pre execute the transformation. Supports fluent interface
     *
     * @return \Puml\Transformer\Transformer
     * @since 0.1
     */
    public function preExecute();

    /**
     * Execute the transformation. Supports fluent interface
     *
     * @return \Puml\Transformer\Transformer
     * @since 0.1
     * @throws \Exception
     */
    public function execute();

    /**
     * Post execute the transformation. Supports fluent interface
     * @return \Puml\Transformer\Transformer
     * @since 0.1
     */
    public function postExecute();

    /**
     * Get the transformation possiblities supported by the transformer
     *
     * @return array<string>
     * @since 0.1
     */
    public static function getTransformationPossibilities();
}
