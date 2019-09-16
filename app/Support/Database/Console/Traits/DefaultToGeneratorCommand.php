<?php

namespace App\Support\Database\Console\Traits;

use Illuminate\Console\GeneratorCommand;

trait DefaultToGeneratorCommand
{
    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return GeneratorCommand::getPath($name);
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return GeneratorCommand::qualifyClass($name);
    }
}
