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

/**
 * Transformer base provides the generic methods that apply to an transformer,
 * without having a driect implementation for a specific transformation.
 */
class Base
{
    /**
     * The transformed Object
     * @var type
     */
    private $transformation;

    /**
     * The filename to transform
     * @var string
     */
    private $filename;

    /**
     * The object to transform
     * @var \Puml\Model\Object
     */
    private $object;

    /**
     * Get the value for the transformation property of this object instance
     * @return type
     */
    public function getTransformation()
    {
        return $this->transformation;
    }

    /**
     * Set the value for the transformation property of this object instance
     *
     * @param type $transformation
     *
     * @return \Puml\Transformer\Base
     * @sicne 0.1
     */
    public function setTransformation($transformation)
    {
        $this->transformation = $transformation;
        return $this;
    }

    /**
     * Get the value for the filename property of this object instance
     *
     * @return string
     * @since 0.1
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value for filename property of this object instance
     *
     * @param string $filename
     *
     * @return \Puml\Transformer\Base
     * @since 0.1
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Decorate the visibility to the proper UML character
     *
     * @param integer $visibility
     *
     * @return string
     * @since 0.1
     */
    protected function decorateVisibility($visibility)
    {
        switch ($visibility) {
            case \ReflectionProperty::IS_STATIC:
                return '$';
            case \ReflectionProperty::IS_PUBLIC:
                return '+';
            case \ReflectionProperty::IS_PROTECTED:
                return '#';
            case \ReflectionProperty::IS_PROTECTED:
            default:
                return '-';
        }
    }

    /**
     * Run the transformation
     *
     * @param \Puml\Model\Object $object
     *
     * @return void
     * @throws \Exception
     * @since 0.1
     */
    public function run(\Puml\Model\Object $object)
    {
        if (!in_array($this->getTransformation(), $this->getTransformationPossibilities())) {
            throw new \Exception('Unknown transformation');
        }

        $this->setObject($object);
        $this->preExecute();
        $this->execute();
        $this->postExecute();
    }

    /**
     * Pre execute the transformation.  Supports fluent interface.
     *
     * @return \Puml\Transformer\Base
     * @since 0.1
     */
    protected function preExecute()
    {
        return $this;
    }

    /**
     * Post execute the transformation. Supports fluent interface.
     * @return \Puml\Transformer\Base
     * @since 0.1
     */
    protected function postExecute()
    {
        return $this;
    }

    /**
     * Set the object property for this object instance. Supports fluent interface
     *
     * @param \Puml\Model\Object $object
     *
     * @return \Puml\Transformer\Base
     * @since 0.1
     */
    public function setObject(\Puml\Model\Object $object)
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Get the object property value for this object instance.
     *
     * @return \Puml\Model\Object
     * @since 0.1
     */
    public function getObject()
    {
        return $this->object;
    }
}
