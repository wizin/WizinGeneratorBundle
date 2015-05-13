<?php

namespace Wizin\Bundle\GeneratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateBundleCommand as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;
use Wizin\Bundle\GeneratorBundle\Generator\BundleGenerator;

/**
 * Generates bundles.
 *
 * @author Makoto Hashiguchi <gusagi@gmail.com>
 */
class GenerateBundleCommand extends BaseCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        parent::configure();
        $this->addOption(
            'without-controller',
            null,
            InputOption::VALUE_NONE,
            'generate without controller ?'
        );
    }

    /**
     * @see Command
     *
     * @throws \InvalidArgumentException When namespace doesn't end with Bundle
     * @throws \RuntimeException         When bundle can't be executed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $this->getGenerator()->override($input, $this->getContainer()->get('filesystem'));
    }

    /**
     * @return \Wizin\Bundle\GeneratorBundle\Generator\BundleGenerator
     */
    protected function createGenerator()
    {
        return new BundleGenerator($this->getContainer()->get('filesystem'));
    }

    /**
     * @param DialogHelper $dialog
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $bundle
     * @param $format
     * @return array
     */
    protected function updateRouting(DialogHelper $dialog, InputInterface $input, OutputInterface $output, $bundle, $format)
    {
        if ($input->getOption('without-controller') === false) {
            return parent::updateRouting($dialog, $input, $output, $bundle, $format);
        }
    }
}

