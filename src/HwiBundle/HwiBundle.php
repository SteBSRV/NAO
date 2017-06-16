<?php

namespace HwiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HwiBundle extends Bundle
{
    public function getParent()
    {
        return 'HWIOAuthBundle';
    }
}
