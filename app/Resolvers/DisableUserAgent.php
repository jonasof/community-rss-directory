<?php

namespace App\Resolvers;

class DisableUserAgent implements \OwenIt\Auditing\Contracts\UserAgentResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
        return '';
    }
}