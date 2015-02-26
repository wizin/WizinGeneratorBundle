<?php

namespace Wizin\Bundle\GeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator as BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Generates a bundle.
 *
 * @author gusagi <gusagi@gmail.com>
 */
class BundleGenerator extends BaseGenerator
{
    private $namespace;
    private $bundle;
    private $dir;
    private $format;
    private $structure;

    /**
     * @param string $namespace
     * @param string $bundle
     * @param string $dir
     * @param string $format
     * @param string $structure
     * @return void
     */
    public function generate($namespace, $bundle, $dir, $format, $structure)
    {
        $this->namespace = $namespace;
        $this->bundle = $bundle;
        $this->dir = $dir;
        $this->format = $format;
        $this->structure = $structure;
        parent::generate($namespace, $bundle, $dir, $format, $structure);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface
     * @param \Symfony\Component\Filesystem\Filesystem
     * @return void
     */
    public function override(InputInterface $input, Filesystem $filesystem)
    {
        $dir = $this->dir .'/' .strtr($this->namespace, '\\', '/');
        if ($input->getOption('without-controller') === true) {
            $filesystem->remove($dir .'/Controller');
            $filesystem->remove($dir .'/Resources/views');
            if ('annotation' != $this->format) {
                $filesystem->remove($dir.'/Resources/config/routing.'.$this->format);
            }
        }
        $filesystem->mkdir($dir .'/Exception');
    }
}
