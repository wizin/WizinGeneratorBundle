<?php

namespace Wizin\Bundle\GeneratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineEntityCommand as BaseCommand;
use Wizin\Bundle\GeneratorBundle\Generator\DoctrineEntityGenerator;

/**
 * Generates a Doctrine entity class based on its name, fields and format.
 *
 * @author Makoto Hashiguchi <gusagi@gmail.com>
 */
class GenerateDoctrineEntityCommand extends BaseCommand
{
    /**
     * @return \Wizin\Bundle\GeneratorBundle\Generator\DoctrineEntityGenerator
     */
    protected function createGenerator()
    {
        return new DoctrineEntityGenerator($this->getContainer()->get('filesystem'), $this->getContainer()->get('doctrine'));
    }
}
