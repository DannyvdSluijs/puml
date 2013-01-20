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

/**
 * A class modeled after a parameter of a class method
 */
class MethodParameter
{
    /**
     * The name of this object instance
     * @var string
     */
    protected $name;

    /**
     * The type of this object instance
     * @var string
     */
    protected $type;

    /**
     * Get the name of this object instance
     *
     * @return string
     * @since 0.1
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of this object instance
     *
     * @param string $name
     *
     * @return \Puml\Model\MethodParameter
     * @since 0.1
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the type of this object instance
     *
     * @return mixed
     * @since 0.1
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of this object instance
     *
     * @param string $type
     *
     * @return \Puml\Model\MethodParameter
     * @since 0.1
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
