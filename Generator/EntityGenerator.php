<?php

namespace Wizin\Bundle\GeneratorBundle\Generator;

use Doctrine\ORM\Tools\EntityGenerator as BaseGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class EntityGenerator extends BaseGenerator
{
    /**
     * @var array values for override metadata
     */
    private $overrideMetadata = [];

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setOverrideMetadata($key, $value)
    {
        $this->overrideMetadata[$key] = $value;
    }

    /**
     * Generates a PHP5 Doctrine 2 entity class from the given ClassMetadataInfo instance.
     *
     * @param ClassMetadataInfo $metadata
     *
     * @return string
     */
    public function generateEntityClass(ClassMetadataInfo $metadata)
    {
        foreach ($this->overrideMetadata as $key => $value) {
            $metadata->$key = $value;
        }

        return parent::generateEntityClass($metadata);
    }
}
