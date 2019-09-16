<?php

namespace App\Support\Database\Console\Seeds;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Console\Seeds\SeedCommand as BaseSeedCommand;

class SeedCommand extends BaseSeedCommand
{
    /**
     * Create a new database seed command instance.
     *
     * @param  \Illuminate\Database\ConnectionResolverInterface  $resolver
     * @return void
     */
    public function __construct(Resolver $resolver)
    {
        parent::__construct($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        if (! empty($this->option('class')) && empty($this->option('domain'))) {
            return parent::handle();
        }

        if (! $this->confirmToProceed()) {
            return;
        }

        $this->resolver->setDefaultConnection($this->getDatabase());

        $namespaceSeederDomains = [];

        if ($this->input->hasOption('domain') && ! empty($domains = $this->option('domain'))) {
            $classSeeder = $this->option('class') ?: 'DatabaseSeeder';

            $namespaceSeederDomains = domain_component_namespace("Database\\Seeders\\{$classSeeder}", $domains);
        } else {
            $namespaceSeederDomains = domain_component_namespace('Database\\Seeders\\DatabaseSeeder');
        }

        Model::unguarded(function () use ($namespaceSeederDomains) {
            collect($namespaceSeederDomains)->each(function ($namespaceSeederDomain) {
                $this->getSeederByDomain($namespaceSeederDomain)->__invoke();
            });
        });

        $this->info('Database seeding completed successfully.');
    }

    /**
     * {@inheritdoc}
     */
    protected function getSeederByDomain(string $namespaceSeederDomain)
    {
        $class = $this->laravel->make($namespaceSeederDomain);

        return $class->setContainer($this->laravel)->setCommand($this);
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        $baseOptions = collect(parent::getOptions());

        $keyClass = $baseOptions->search(function ($item, $key) {
            return Arr::first($item) == 'class';
        });

        $baseOptions = $baseOptions->all();

        // Remove default value key {class=DatabaseSeeder}
        array_pop($baseOptions[$keyClass]);

        // php artisan db:seed --domain=Categories --domain=Products
        $domainOption = [
            ['domain', 'D', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Adding Domain Option to the Command', []]
        ];

        return array_merge($baseOptions, $domainOption);
    }
}
