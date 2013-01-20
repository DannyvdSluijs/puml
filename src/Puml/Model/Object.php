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
 * A class modeled after an object
 */
class Object
{
    /**
     * The parent for this object instance
     * @var \Puml\Model\Object
     */
    protected $parent;

    /**
     * The name for this object instance
     * @var string
     */
    protected $name;

    /**
     * A collection of properties belonging to this object instance
     * @var array<\Puml\Model\Property>
     */
    protected $properties = array();

    /**
     * A collection of methods belonging to this object instance
     * @var array <\Puml\Model\Method>
     */
    protected $methods = array();

    /**
     * Whether or not this object instance has a parent
     *
     * @return boolean
     * @since 0.1
     */
    public function hasParent()
    {
        return isset($this->parent);
    }

    /**
     * Get the parent property of this object instance
     *
     * @return \Puml\Model\Object|null
     * @since 0.1
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the parent property of this object instance
     *
     * @param \Puml\Model\Object $parent
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function setParent(Object $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Set the name property for this object instance
     *
     * @param string $name
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the name property for this object instance
     *
     * @return string
     * @since 0.1
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add a property to the collection of properties of this object instance
     *
     * @param \Puml\Model\Property $property
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
        return $this;
    }

    /**
     * Remove a property from the collection of properties for this
     * object instance
     *
     * @param \Puml\Model\Property $property
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function removeProperty(Property $property)
    {
        unset($this->properties[$property->getName()]);
        return $this;
    }

    /**
     * Whether or a given property is available in the collection of
     * properties for this object instance
     *
     * @param \Puml\Model\Property $property
     *
     * @return boolean
     * @since 0.1
     */
    public function hasProperty(Property $property)
    {
        return isset($this->properties[$property->getName()]);
    }

    /**
     * Get the collection of properties of this object instance
     * where each property matches the given visibility scope.
     *
     * @param integer|null $visibility
     *
     * @return array<\Puml\Model\Property>
     * @since 0.1
     */
    public function getProperties($visibility = null)
    {
        if (is_null($visibility)) {
            $visibility = \ReflectionProperty::IS_STATIC
                | \ReflectionProperty::IS_PUBLIC
                | \ReflectionProperty::IS_PROTECTED
                | \ReflectionProperty::IS_PRIVATE;
        }

        return array_filter(
            $this->properties,
            function ($var) use ($visibility) {
                return ($var->getVisibility() & $visibility) > 0;
            }
        );
    }

    /**
     * Add a method to the collection of methods for this object instance
     *
     * @param \Puml\Model\Method $method
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function addMethod(Method $method)
    {
        $this->methods[$method->getName()] = $method;
        return $this;
    }

    /**
     * Remove a method from the collection of methods for this
     * object instance
     *
     * @param \Puml\Model\Method $method
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function removeMethod(Method $method)
    {
        unset($this->methods[$method->getName()]);
        return $this;
    }

    /**
     * Whether or a given method is available in the collection of
     * methods for this object instance
     *
     * @param \Puml\Model\Method $method
     *
     * @return boolean
     * @since 0.1
     */
    public function hasMethod(Method $method)
    {
        return isset($this->methods[$method->getName()]);
    }

    /**
     * Get the collection of properties of this object instance
     * where each property matches the given visibility scope.
     *
     * @param integer|null $visibility
     *
     * @return array<\Puml\Model\Method>
     * @since 0.1
     */
    public function getMethods($visibility = null)
    {
        if (is_null($visibility)) {
            $visibility = \ReflectionProperty::IS_STATIC
                | \ReflectionProperty::IS_PUBLIC
                | \ReflectionProperty::IS_PROTECTED
                | \ReflectionProperty::IS_PRIVATE;
        }

        return array_filter(
            $this->methods,
            function ($var) use ($visibility) {
                return ($var->getVisibility() & $visibility) > 0;
            }
        );
    }
}
