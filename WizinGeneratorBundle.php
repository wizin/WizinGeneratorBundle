<?php

namespace Wizin\Bundle\GeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * WizinGeneratorBundle.
 *
 * Bundle to generate a bundle that extends SensioGeneratorBundle
 *
 * @author gusagi <gusagi@gmail.com>
 */
class WizinGeneratorBundle extends Bundle
{
    /**
     * @return string parent bundle name
     */
    public function getParent()
    {
        return 'SensioGeneratorBundle';
    }
}
