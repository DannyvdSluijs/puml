<?php
/**
 * Puml
 *
 * PHP Version 5.3
 *
 * @category  Puml
 * @package   Puml\Model
 * @author    Danny van der Sluijs <danny.vandersluijs@fleppuhstein.com>
 * @copyright 2012 Danny van der Sluijs <www.fleppuhstein.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Puml\Model;

use Puml\Model\MethodParameter;

/**
 * A class modeled after a method of a class
 */
class Method extends ObjectItem
{
    /**
     * A collection of method parameters belonging to this object instance
     * @var array<\Puml\Model\MethodParameter>
     */
    protected $parameters = array();

    /**
     * Add a parameter to this object instance
     *
     * @param \Puml\Model\MethodParameter $parameter
     *
     * @return \Puml\Model\Method
     * @since 0.1
     */
    public function addParameter(MethodParameter $parameter)
    {
        $this->parameters[] = $parameter;
        return $this;
    }

    /**
     * Get the parameters for this object instance
     *
     * @return array<\Puml\Model\MethodParameter>
     * @since 0.1
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Test if this object instance has parameters
     *
     * @return boolean
     * @since 0.1
     */
    public function hasParameters()
    {
        return (bool) count($this->parameters);
    }
}
