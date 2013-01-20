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
 * A composite class of direct object childeren, such as method or property
 */
abstract class ObjectItem
{
    /**
     * The bits in \ReflectionMethod::[IS_STATIC|IS_PUBLIC|IS_PROTECTED|IS_PRIVATE]
     */
    const FULL_SCOPE = 1793;

    /**
     * The visibility
     * @var integer
     */
    protected $visibility = \ReflectionMethod::IS_PUBLIC;

    /**
     * The name
     * @var string
     */
    protected $name;

    /**
     * The type
     * @var string
     */
    protected $type;

    /**
     * Get the visibility for this object instance
     *
     * @return integer
     * @since 0.1
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the visibility for this object instance
     *
     * @param integer $visibility
     *
     * @return \Puml\Model\ObjectItem
     * @since 0.1
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * Get the name for this object instance
     *
     * @return string
     * @since 0.1
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the string for this object instance
     *
     * @param string $name
     *
     * @return \Puml\Model\ObjectItem
     * @since 0.1
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the type of this object instance
     * @return string
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
     * @return \Puml\Model\ObjectItem
     * @since 0.1
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
