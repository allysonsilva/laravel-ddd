<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Schema;

const DOMAIN_TOP_NAME = 'Domains';

if (! function_exists('domain_component_path')) {
    /**
     * Recupera o caminho de algum componente interno do domínio.
     *
     * @param  string  $domain
     * @param  string|null  $domainComponentSuffixFolder
     *
     * @example
     *      $ domain_component_path('Users', 'Http/Controllers')
     *      => "/var/www/app.com/app/Domains/Users/Http/Controllers"
     *
     * @return string
     */
    function domain_component_path(string $domain, string $domainComponentSuffixFolder = null): string
    {
        return domains_top_level_path().DIRECTORY_SEPARATOR.Str::studly($domain).DIRECTORY_SEPARATOR.($domainComponentSuffixFolder ?? '');
    }
}

if (! function_exists('domains_top_level_path')) {
    /**
     * Recupera o caminho da pasta principal que conterá os domínios.
     *
     * @example
     *      $ domains_top_level_path()
     *      => "/var/www/app.com/app/Domains"
     *
     * @return string
     */
    function domains_top_level_path(): string
    {
        return app_path(DOMAIN_TOP_NAME);
    }
}

if (! function_exists('domain_top_level_folder_name')) {
    /**
     * Recupera a pasta principal que contêm dos domínios.
     *
     * @return string
     */
    function domain_top_level_folder_name(): string
    {
        return DOMAIN_TOP_NAME;
    }
}

if (! function_exists('paths_inside_components_domains')) {
    /**
     * Recupera todos os caminhos de acordo com prefixo de cada domínio.
     *
     * @param string $domainComponentFolder
     *
     * @example
     *      $ paths_inside_components_domains('Http/Controllers')
     *      [
     *          "/var/www/app.com/app/Domains/Categories/Http/Controllers",
     *          "/var/www/app.com/app/Domains/Products/Http/Controllers",
     *          "/var/www/app.com/app/Domains/Users/Http/Controllers",
     *      ]
     *
     * @return array
     */
    function paths_inside_components_domains(string $domainComponentFolder): array
    {
        return
            array_map(function($domainFolder) use ($domainComponentFolder) {
                return domain_component_path($domainFolder, $domainComponentFolder);
            }, domain_folder_names());
    }
}

if (! function_exists('domain_folder_names')) {
    /**
     * Recuperao nome das pastas de cada domínio.
     *
     * @example
     *      $ domain_folder_names()
     *      [
     *          "Categories",
     *          "Products",
     *          "Users",
     *      ]
     *
     * @return array
     */
    function domain_folder_names(): array
    {
        $domainsFolderNames = [];
        $directoryIterator = new DirectoryIterator(domains_top_level_path());

        foreach($directoryIterator as $iterator)
            if (! $iterator->isDot() && $iterator->isDir())
                $domainsFolderNames[] = $iterator->getFilename();

        return $domainsFolderNames;
    }
}

if (! function_exists('domain_component_namespace')) {
    /**
     * Recupera o NAMESPACE de terminado ou todos os componente do domínio.
     *
     * @param string $subNamespace
     * @param string|array|null $domain
     *
     * @example
     *      $ domain_component_namespace('Database\\Factories')
     *      [
     *          "App\Domains\Categories\Database\Factories",
     *          "App\Domains\Products\Database\Factories",
     *          "App\Domains\Users\Database\Factories",
     *      ]
     *
     *      $ domain_component_namespace('Database\\Factories', 'Users')
     *      [
     *          "App\Domains\Users\Database\Factories",
     *      ]
     *
     * @return array
     */
    function domain_component_namespace(string $subNamespace, $domain = null): array
    {
        $rootNamespace = Container::getInstance()->getNamespace();
        $domainsToMap = Arr::wrap($domain);

        if (empty($domain))
            $domainsToMap = domain_folder_names();

        return
            array_map(function($domain) use ($subNamespace, $rootNamespace) {
                return $rootNamespace.DOMAIN_TOP_NAME.'\\'.Str::studly($domain).'\\'.$subNamespace;
            }, $domainsToMap);
    }
}

if (! function_exists('domain_route_file')) {
    /**
     * Recupera o arquivo de rotas de determinado domínio.
     *
     * @param string $domain
     * @param string $fileName
     *
     * @return string
     */
    function domain_route_file(string $domain, string $fileName): string
    {
        return domain_component_path($domain, 'Http' .DIRECTORY_SEPARATOR. 'Routes' .DIRECTORY_SEPARATOR. $fileName);
    }
}

if (! function_exists('unit_route_file')) {
    /**
     * Recupera o arquivo de rotas de determinada unidade.
     *
     * @param string $unit
     * @param string $fileName
     *
     * @return string
     */
    function unit_route_file(string $unit, string $fileName): string
    {
        return app_path("Units/{$unit}/Http/Routes/{$fileName}");
    }
}

if (! function_exists('populate_table_by_file')) {
    /**
     * Popula os dados de um arquivo sql($file) para determinada tabela($table).
     *
     * @param \Illuminate\Console\Command $command
     * @param string $table
     * @param string $file
     *
     * @return void
     */
    function populate_table_by_file(Command &$command, string $table, string $file): void
    {
        $commandOutput = $command->getOutput();

        $commandOutput->newLine();

        if (! Schema::hasTable($table)) {
            $command->alert("Tabela \"{$table}\" não existe.");
            return;
        }

        if (! file_exists($file)) {
            $command->alert("Arquivo .SQL para popular a tabela \"{$table}\" não existe.");
            return;
        }

        Schema::disableForeignKeyConstraints();

        if (! DB::table($table)->exists()) {

            DB::unprepared("ALTER TABLE {$table} AUTO_INCREMENT = 1;");

        } else {
            DB::table($table)->truncate();

            $command->alert("Executando \"truncate\" na tabela \"{$table}\".");
        }

        Schema::enableForeignKeyConstraints();

        DB::beginTransaction();

        try {

            DB::unprepared(file_get_contents($file));
            DB::commit();

            $command->alert("Arquivo .SQL da tabela \"{$table}\" executado com sucesso.");

        } catch (Throwable $e) {
            DB::rollback();

            dd($e->getMessage());
        }
    }
}

if (! function_exists('api_prefix')) {
    /**
     * Recupera uma URI para ser utilizada na URL na API.
     *
     * @param string|null $suffix
     *
     * @return string
     */
    function api_prefix(?string $suffix): string
    {
        $apiPrefix = 'api'.DIRECTORY_SEPARATOR.config('app.version').DIRECTORY_SEPARATOR.$suffix;
        $apiPrefix = str_replace('//', '/', $apiPrefix);

        return $apiPrefix;
    }
}

if (! function_exists('to_HTML')) {
    function to_HTML(string $string): string
    {
        return html_entity_decode(strip_tags(trim($string)));
    }
}

if (! function_exists('map_status')) {
    function map_status(): array
    {
        return [
            '' => 'Selecione',
            '1' => 'Ativo',
            '0' => 'Inativo',
        ];
    }
}

if (! function_exists('input')) {
    function input(string $key)
    {
        return request($key) ?? old($key);
    }
}

if (! function_exists('request_filled')) {
    function request_filled(array $data): array
    {
        return array_filter(request($data), function ($value) {
            return is_bool($value) || is_array($value) || trim((string) $value) !== '';
        });
    }
}

if (! function_exists('html_status')) {
    function html_status(bool $status): string
    {
        if ($status)
            return '<span class="badge badge-success">Ativo</span>';

        return '<span class="badge badge-danger">Inativo</span>';
    }
}

if (! function_exists('to_money_PTBR')) {
    function to_money_PTBR($value)
    {
        if (! empty($value))
            return "R$ ".number_format($value, 2, ',', '.');

        return;
    }
}

if (! function_exists('convert_currency_from_PTRB')) {
    function convert_currency_from_PTRB($value)
    {
        if (Str::contains($value, 'R$')) {
            return trim(str_replace('R$', '', str_replace(',' , '.', str_replace('.', '', $value))));
        }

        return $value;
    }
}

if (! function_exists('error')) {
    function error(Throwable $e, string $class, string $method): void
    {
        logger()->error("Error {$class} - {$method}", ['code' => $e->getCode(), 'message' => $e->getMessage()]);
    }
}
