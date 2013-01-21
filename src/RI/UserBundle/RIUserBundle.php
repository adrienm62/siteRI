<?php

namespace RI\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RIUserBundle extends Bundle
{
    public function getParent() {
        return "FOSUserBundle";
    }
}
