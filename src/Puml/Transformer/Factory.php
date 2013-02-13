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
 * A factory pettern to ftech the correct transformer implementation.
 */
class Factory
{
    /**
     * Create a transformer implementation based on a file name
     *
     * @param string $filename
     *
     * @return \Puml\Transformer\Base
     * @since 0.1
     * @throws \Exception
     * @todo make this more dynamic, perhaps an observer pattern where the
     * transformers are registered at this factory.
     */
    public static function create($filename)
    {
        $pathInfo = pathinfo($filename);
        $pathInfo['extension'];

        switch ($pathInfo['extension']) {
            case 'png':
            case 'pdf':
            case 'dot':
                $transformer = new GraphViz();

                break;
            default:
                throw new \Exception('No support found for ' . $pathInfo['extension'] . ' extension');
        }

        $transformer
            ->setTransformation($pathInfo['extension'])
            ->setFilename($filename);
        return $transformer;
    }
}
