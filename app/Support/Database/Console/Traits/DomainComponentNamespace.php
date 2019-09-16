<?php

namespace App\Support\Database\Console\Traits;

use Illuminate\Support\Arr;
use Illuminate\Console\DetectsApplicationNamespace;

trait DomainComponentNamespace
{
    use DetectsApplicationNamespace;

    protected function getDomainComponentNamespace(string $domainComponentSuffixNamespace, string $rootNamespace)
    {
        // $rootNamespace.'\\'.domain_top_level_folder_name().'\\'.$this->getDomainInput().'\\'.$domainComponentSuffixNamespace;
        return Arr::first(domain_component_namespace($domainComponentSuffixNamespace, $this->getDomainInput()));
    }
}
