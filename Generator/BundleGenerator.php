<?php

namespace Wizin\Bundle\GeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator as BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\Container;

/**
 * Generates a bundle.
 *
 * @author Makoto Hashiguchi <gusagi@gmail.com>
 */
class BundleGenerator extends BaseGenerator
{
    private $namespace;
    private $bundle;
    private $dir;
    private $format;
    private $structure;
    private $skeletonDirs;

    public function __construct(Filesystem $filesystem)
    {
        $this->skeletonDirs = [__DIR__.'/../Resources/skeleton'];
        parent::__construct($filesystem);
    }

    /**
     * Sets an array of directories to look for templates.
     *
     * The directories must be sorted from the most specific to the most
     * directory.
     *
     * @param array $skeletonDirs An array of skeleton dirs
     */
    public function setSkeletonDirs($skeletonDirs)
    {
        if (is_array($skeletonDirs) === false) {
            $skeletonDirs = array($skeletonDirs);
        }
        $this->skeletonDirs = array_merge($this->skeletonDirs, $skeletonDirs);
    }

    /**
     * Get the twig environment that will render skeletons
     * @return \Twig_Environment
     */
    protected function getTwigEnvironment()
    {
        return new \Twig_Environment(new \Twig_Loader_Filesystem($this->skeletonDirs), array(
                'debug'            => true,
                'cache'            => false,
                'strict_variables' => true,
                'autoescape'       => false,
            ));
    }

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

        $basename = substr($this->bundle, 0, -6);
        $parameters = array(
            'namespace' => $this->namespace,
            'bundle'    => $this->bundle,
            'format'    => $this->format,
            'bundle_basename' => $basename,
            'extension_alias' => Container::underscore($basename),
        );
        if ('yml' === $this->format) {
            $this->renderFile('bundle/parameters.yml.twig', $dir.'/Resources/config/parameters.yml', $parameters);
        }
    }
}
