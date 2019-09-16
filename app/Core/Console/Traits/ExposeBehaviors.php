<?php

namespace App\Core\Console\Traits;

trait ExposeBehaviors
{
    /**
     * Register all of the commands in the given directory.
     *
     * @param  array|string  $paths
     * @return void
     */
    public function loadCommandsForPaths($paths)
    {
        return $this->load($paths);
    }
}
