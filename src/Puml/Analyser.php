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
namespace Puml;

use Puml\Model\Object;
use Puml\Model\Property;
use Puml\Model\Method;
use Puml\Model\MethodParameter;

/**
 * Puml analyser, transforms a single object name, into an series of objects,
 * objects, properties, methods, including parent relations.
 */
class Analyser
{
    /**
     * The object analysis
     * @var \Puml\Model\Object
     */
    protected $object;

    /**
     * The object name, to analyse
     * @var string
     */
    protected $objectName;

    /**
     * The reflected object used for analysis
     * @var type
     */
    protected $reflectedObject;

    /**
     * Constructor
     *
     * @since 0.1
     */
    public function __construct()
    {
        $this->object = new Object();
    }

    /**
     * Get the name of the object to analyse for this object instance
     *
     * @return string
     * @since 0.1
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * Set the object name
     *
     * @param string $objectName
     *
     * @return \Puml\Analyser
     * @since 0.1
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
        return $this;
    }

    /**
     * Get the object
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Create a new analyser object instance
     *
     * @param string $name
     *
     * @return \Puml\Analyser
     * @since 0.1
     */
    public static function create($name)
    {
        $analyser = new self();

        $analyser
            ->setObjectName($name);

        return $analyser;
    }

    /**
     * Run the analysis
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function run()
    {

        $this->reflectedObject = new \ReflectionClass($this->objectName);

        $this->object->setName($this->reflectedObject->getName());

        /* Analyse its properties */
        $this->extractProperties($this->reflectedObject, $this->object);

        /* Analyse its methods */
        $this->extractMethods($this->reflectedObject, $this->object);

        /* Analyse its parents */
        $this->determineParent($this->reflectedObject, $this->object);

        return $this->object;
    }

    /**
     * Extract the properties of the reflection class into the object
     *
     * @param \ReflectionClass   $reflectedObject The reflected object to
     *                                            extract the properties out of.
     * @param \Puml\Model\Object $object          The object to add the property
     *                                            to.
     *
     * @return void
     * @since 0.1
     */
    protected function extractProperties(\ReflectionClass $reflectedObject, \Puml\Model\Object $object)
    {
        foreach ($reflectedObject->getProperties() as $reflectedProperty) {
            $reflectedProperty->setAccessible(true);
            $property = new Property();

            /* Skip when its not declared in this class */
            if ($reflectedProperty->getDeclaringClass()->getName() != $reflectedObject->getName()) {
                continue;
            }

            /* Determine visibility */
            if ($reflectedProperty->isStatic()) {
                $property->setVisibility(\ReflectionProperty::IS_STATIC);
            } elseif ($reflectedProperty->isPublic()) {
                $property->setVisibility(\ReflectionProperty::IS_PUBLIC);
            } elseif ($reflectedProperty->isProtected()) {
                $property->setVisibility(\ReflectionProperty::IS_PROTECTED);
            } else {
                $property->setVisibility(\ReflectionProperty::IS_PRIVATE);
            }

            /* Determine type */
            $type = $this->determinePropertyType($reflectedProperty);

            $property
                ->setName($reflectedProperty->getName())
                ->setType($type);


            $object->addProperty($property);
        }
    }

    /**
     * Extract the methods of the reflection class into the object
     *
     * @param \ReflectionClass   $reflectedObject The reflected object to
     *                                            extract the methods out of.
     * @param \Puml\Model\Object $object          The object to add the methods
     *                                            to.
     *
     * @return void
     * @since 0.1
     */
    protected function extractMethods(\ReflectionClass $reflectedObject, \Puml\Model\Object $object)
    {
        foreach ($reflectedObject->getMethods() as $reflectedMethod) {
            $reflectedMethod->setAccessible(true);
            $method = new Method();

            /* Skip when its not declared in this class */
            if ($reflectedMethod->getDeclaringClass()->getName() != $reflectedObject->getName()) {
                continue;
            }

            if ($reflectedMethod->isStatic()) {
                $method->setVisibility(\ReflectionProperty::IS_STATIC);
            } elseif ($reflectedMethod->isPublic()) {
                $method->setVisibility(\ReflectionProperty::IS_PUBLIC);
            } elseif ($reflectedMethod->isProtected()) {
                $method->setVisibility(\ReflectionProperty::IS_PROTECTED);
            } else {
                $method->setVisibility(\ReflectionProperty::IS_PRIVATE);
            }

            /* Determine type */
            $type = $this->determineMethodType($reflectedMethod);

            $method
                ->setName($reflectedMethod->getName())
                ->setType($type);

            $this->extractParameters($reflectedMethod, $method);

            $object->addMethod($method);
        }
    }

    /**
     * Determine the parent
     *
     * @param \ReflectionClass   $reflectedObject
     * @param \Puml\Model\Object $object
     *
     * @return void
     * @since 0.1
     */
    protected function determineParent(\ReflectionClass $reflectedObject, \Puml\Model\Object $object)
    {
        if ($reflectedObject->getParentClass() !== false) {
            $analyser = $this->create($reflectedObject->getParentClass()->getName());

            $analyser->run();

            $object->setParent($analyser->getObject());
        }
    }

    /**
     * Determine the property type using @var annotion lookup or using the
     * default value to determine the type
     *
     * @param \ReflectionProperty $reflectedProperty
     *
     * @return string
     * @since 0.1
     * @todo Fallback to phpdoc @var annotation, determine weight compared to default value
     */
    protected function determinePropertyType(\ReflectionProperty $reflectedProperty)
    {
        if (strlen($reflectedProperty->getDocComment())) {
            $pattern = '/[ ]+\*[ ]+@var[ ]+([a-zA-Z\\\]+).*/';

            preg_match($pattern, $reflectedProperty->getDocComment(), $matches);

            if (is_array($matches) && array_key_exists(1, $matches)) {
                return $matches[1];
            }
        }

        $objectDefaultProperties = $reflectedProperty->getDeclaringClass()->getDefaultProperties();

        if (array_key_exists($reflectedProperty->getName(), $objectDefaultProperties)) {
            $defaultValue = $objectDefaultProperties[$reflectedProperty->getName()];

            if (is_object($defaultValue)) {
                return get_class($defaultValue);
            }
            if (is_array($defaultValue)) {
                return 'array()';
            }
            if (is_string($defaultValue)) {
                return 'string';
            }
            if (is_float($defaultValue)) {
                return 'float';
            }
            if (is_long($defaultValue)) {
                return 'long';
            }
            if (is_int($defaultValue)) {
                return 'int';
            }
            if (is_bool($defaultValue)) {
                return 'bool';
            }

            return 'unknown';
        }
    }

    /**
     * Extract the parameters for a single method
     *
     * @param \ReflectionMethod  $reflectedMethod
     * @param \Puml\Model\Method $method
     *
     * @return void
     * @since 0.1
     * @todo remove the adding of parameters out of this function should extract only, and return
     */
    protected function extractParameters(\ReflectionMethod $reflectedMethod, \Puml\Model\Method $method)
    {
        if ($reflectedMethod->getNumberOfParameters() == 0) {
            return;
        }

        foreach ($reflectedMethod->getParameters() as $reflectedParameter) {
            $parameter = new MethodParameter;

            $type = $this->determineParameterType($reflectedParameter);

            $parameter
                ->setName($reflectedParameter->getName())
                ->setType($type);

            $method->addParameter($parameter);
        }
    }

    /**
     * Determine the parameter type by looking into annotations
     *
     * @param \ReflectionParameter $reflectedParameter
     *
     * @return string
     * @since 0.1
     * @todo Look for the correct parameter by name
     */
    protected function determineParameterType(\ReflectionParameter $reflectedParameter)
    {
        if (strlen($reflectedParameter->getDeclaringFunction()->getDocComment())) {
            $name = $reflectedParameter->getName();
            $pattern = '/[ ]+\*[ ]+@param[ ]+([a-zA-Z\\\]+).*/';

            preg_match($pattern, $reflectedParameter->getDeclaringFunction()->getDocComment(), $matches);

            if (is_array($matches) && array_key_exists(1, $matches)) {
                return $matches[1];
            }
        }
    }

    /**
     * Determine the method type by looking into annotations
     *
     * @param \ReflectionMethod $reflectedMethod
     *
     * @return string
     * @since 0.1
     */
    protected function determineMethodType(\ReflectionMethod $reflectedMethod)
    {
        if (strlen($reflectedMethod->getDocComment())) {
            $pattern = '/[ ]+\*[ ]+@return[ ]+([a-zA-Z\\\]+).*/';

            preg_match($pattern, $reflectedMethod->getDocComment(), $matches);

            if (is_array($matches) && array_key_exists(1, $matches)) {
                return $matches[1];
            }
        }
    }
}
