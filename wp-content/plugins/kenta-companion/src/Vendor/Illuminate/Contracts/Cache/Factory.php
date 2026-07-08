<?php

namespace KentaCompanion\Vendor\Illuminate\Contracts\Cache;

interface Factory
{
    /**
     * Get a cache store instance by name.
     *
     * @param  string|null  $name
     * @return \KentaCompanion\Vendor\Illuminate\Contracts\Cache\Repository
     */
    public function store($name = null);
}
