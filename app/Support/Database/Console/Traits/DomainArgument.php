<?php

namespace App\Support\Database\Console\Traits;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

trait DomainArgument
{
    /**
     * Get the desired {domain} from the input.
     *
     * @return string
     */
    protected function getDomainInput()
    {
        return Str::studly(trim($this->argument('domain')));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        $baseArguments = parent::getArguments();

        $domainArgument = [
            ['domain', InputArgument::REQUIRED, 'Name of the domain folder'],
        ];

        return array_merge($baseArguments, $domainArgument);
    }
}
