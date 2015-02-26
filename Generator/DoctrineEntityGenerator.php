<?php

namespace Wizin\Bundle\GeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\DoctrineEntityGenerator as BaseGenerator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Generates a Doctrine entity class based on its name, fields and format.
 *
 * @author gusagi <gusagi@gmail.com>
 */
class DoctrineEntityGenerator extends BaseGenerator
{
    /**
     * @var \Wizin\Bundle\GeneratorBundle\Generator\EntityGenerator
     */
    private $entityGenerator;

    /**
     * @param BundleInterface $bundle
     * @param $entity
     * @param $format
     * @param array $fields
     * @param $withRepository
     */
    public function generate(BundleInterface $bundle, $entity, $format, array $fields, $withRepository)
    {
        if ($withRepository) {
            $customRepositoryClassName = $bundle->getNamespace().'\\Repository\\'.$entity.'Repository';
            $this->setOverrideMetadata('customRepositoryClassName', $customRepositoryClassName);
        }
        parent::generate($bundle, $entity, $format, $fields, $withRepository);
        if ($withRepository && 'annotation' !== $format) {
            $mappingPath = $bundle->getPath().'/Resources/config/doctrine/'.str_replace('\\', '.', $entity).'.orm.'.$format;
            if ($mappingPath) {
                $mappingCode = str_replace(
                    $bundle->getNamespace().'\\Entity\\'.$entity.'Repository',
                    $customRepositoryClassName,
                    file_get_contents($mappingPath)
                );
                file_put_contents($mappingPath, $mappingCode);
            }
        }
    }

    /**
     * @return \Wizin\Bundle\GeneratorBundle\Generator\EntityGenerator
     */
    protected function getEntityGenerator()
    {
        if (isset($this->entityGenerator) === false) {
            $this->entityGenerator = new EntityGenerator();
            $this->entityGenerator->setGenerateAnnotations(false);
            $this->entityGenerator->setGenerateStubMethods(true);
            $this->entityGenerator->setRegenerateEntityIfExists(false);
            $this->entityGenerator->setUpdateEntityIfExists(true);
            $this->entityGenerator->setNumSpaces(4);
            $this->entityGenerator->setAnnotationPrefix('ORM\\');
        }

        return $this->entityGenerator;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    private function setOverrideMetadata($key, $value)
    {
        $entityGenerator = $this->getEntityGenerator();
        $entityGenerator->setOverrideMetadata($key, $value);
    }
}
