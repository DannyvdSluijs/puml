<?php
/**
 * Puml
 *
 * PHP Version 5.3
 *
 * @category  Puml
 * @package   Puml\Command
 * @author    Danny van der Sluijs <danny.vandersluijs@fleppuhstein.com>
 * @copyright 2012 Danny van der Sluijs <www.fleppuhstein.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Puml\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Puml;

/**
 * This command generates a file, containing the uml scheme of the class given
 */
class Generate extends Console\Command\Command
{
    /**
     * Configure command, set parameters definition and help.
     *
     * @return void
     * @since 0.1
     */
    protected function configure()
    {
        $this
            ->setName('generate')
            ->setDescription('Generate the output file based on the given object name')
            ->setDefinition(
                array(
                    new InputArgument('object', InputArgument::REQUIRED, 'Object name'),
                    new InputArgument('filename', InputArgument::REQUIRED, 'The output filename'),
                    //new InputArgument('scope', InputArgument::REQUIRED, 'The visibility scope')
                )
            )
            ->setHelp(
                sprintf(
                    '%sGenerate the output file based on the given object name%s',
                    PHP_EOL,
                    PHP_EOL
                )
            );
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input  The input used for this command
     * @param OutputInterface $output The output used for this command
     *
     * @return void
     * @since 0.1
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $analyser = Puml\Analyser::create($input->getArgument('object'));
        $object = $analyser->run();

        $transformer = Puml\Transformer\Factory::create($input->getArgument('filename'));
        $transformer->run($object);
    }
}
