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

use phpDocumentor\GraphViz\Graph;
use phpDocumentor\GraphViz\Node;
use phpDocumentor\GraphViz\Edge;

/**
 * A transformer which uses a intermediate dot file to tranform the object into
 * an image.
 */
class GraphViz extends Base implements Transformer
{
    const NEWLINE = "\l";

    /**
     * The graphviz graph
     * @var \phpDocumentor\GraphViz\Graph
     */
    protected $graph;

    /**
     * Get the transformation possiblities supported by this transformer
     *
     * @return array<string>
     * @since 0.1
     */
    public static function getTransformationPossibilities()
    {
        return array(
            'png',
            'pdf'
        );
    }

    /**
     * Pre execute the transformation. Supports fluent interface
     *
     * @return \Puml\Transformer\Base
     * @since 0.1
     */
    public function preExecute()
    {
        $this->graph = new Graph();
        return $this;
    }

    /**
     * Execute the transformation
     *
     * @return void
     * @since 0.1
     */
    public function execute()
    {
        $this->transformObject($this->getObject());
        if ($this->getObject()->hasParent()) {
            $this->transformParent($this->getObject());
        }

        return $this;
    }

    /**
     * Post execute the transformation. Supports fluent interface
     *
     * @return \Puml\Transformer\Base
     * @since 0.1
     */
    public function postExecute()
    {
        $this->graph->export($this->getTransformation(), $this->getFilename());
        return $this;
    }

    /**
     * Transform the parent
     *
     * @param \Puml\Model\Object $child  The direct child of the parent
     *
     * @return void
     * @since 0.1
     */
    protected function transformParent(\Puml\Model\Object $child)
    {
        $parent = $child->getParent();
        $this->transformObject($parent);

        $this->graph->link(
            new Edge(
                $this->graph->findNode($child->getName()),
                $this->graph->findNode($parent->getName())
            )
        );

        if ($parent->hasParent()) {
            $this->transformParent($parent->getParent(), $parent);
        }
    }

    /**
     * Transform the object to an UML scheme
     *
     * @param \Puml\Model\Object $object
     *
     * @return void
     * @since 0.1
     */
    protected function transformObject(\Puml\Model\Object $object)
    {
        $label = implode(
            '|',
            array(
                addslashes($object->getName()),
                implode($this->transformProperties($object->getProperties())),
                implode($this->transformMethods($object->getMethods()))
            )
        );

        $node = new Node($object->getName());
        $node
            ->setShape('record')
            ->setLabel('"{' . $label . '}"');

        $this->graph->setNode($node);
    }

    /**
     * Transform the properties to string representations
     *
     * @param array<\Puml\Model\Property> $properties
     *
     * @return array<string>
     * @since 0.1
     */
    protected function transformProperties($properties)
    {
        $transformeredProperties =array();

        foreach ($properties as $property) {
            $transformeredProperties[] =
                $this->decorateVisibility($property->getVisibility()) .
                $property->getName() . ' : ' .
                addslashes($property->getType()) . self::NEWLINE;
        }

        return $transformeredProperties;
    }

    /**
     * Transform the methods
     *
     * @param array<\Puml\Model\Method> $methods
     *
     * @return array<string>
     * @since 0.1
     */
    protected function transformMethods($methods)
    {
        $transformeredMethods = array();

        foreach ($methods as $method) {
            $transformeredMethods[] =
                $this->decorateVisibility($method->getVisibility()) .
                $method->getName() .
                '(' . $this->transformParameters($method->getParameters()) . ') : ' .
                addslashes($method->getType()) . self::NEWLINE;
        }

        return $transformeredMethods;
    }

    /**
     * Transform the parameters
     *
     * @param array<\Puml\Model\Parameter>
     *
     * @return string
     * @since 0.1
     */
    protected function transformParameters($parameters)
    {
        $transformedParameters = '';

        foreach ($parameters as $parameter) {
            $transformedParameters .=
            $parameter->getName() .
            ' : ' .
            addslashes($parameter->getType()) . ' ';
        }

        return substr($transformedParameters, 0, -1);
    }
}
