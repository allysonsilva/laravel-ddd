<?php

namespace App\Support\Database\Console;

use Illuminate\Support\ServiceProvider;
use App\Support\Database\Console\Seeds\{
    SeedCommand,
    SeederMakeCommand
};
use App\Support\Database\Console\Migrations\{
    MigrateCommand,
    MigrateMakeCommand,
    ResetCommand as MigrateResetCommand,
    RollbackCommand as MigrateRollbackCommand,
    StatusCommand as MigrateStatusCommand
};
use App\Support\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider as BaseArtisanServiceProvider;

class ArtisanServiceProvider extends BaseArtisanServiceProvider
{
    // /**
    //  * The commands to be registered.
    //  *
    //  * @var array
    //  */
    // protected $commandsToDatabase = [
    //     'Migrate' => 'command.migrate',
    //     'Seed' => 'command.seed',
    //     'MigrateReset' => 'command.migrate.reset',
    //     'MigrateRollback' => 'command.migrate.rollback',
    //     'MigrateStatus' => 'command.migrate.status',
    // ];

    // /**
    //  * The commands to be registered.
    //  *
    //  * @var array
    //  */
    // protected $devCommandsToDatabase = [
    //     'MigrateMake' => 'command.migrate.make',
    //     'SeederMake' => 'command.seeder.make',
    //     'FactoryMake' => 'command.factory.make',
    // ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        // $this->registerCommands(array_merge(
        //     $this->commandsToDatabase, $this->devCommandsToDatabase
        // ));
    }

    // /**
    //  * Register the given commands.
    //  *
    //  * @param  array  $commands
    //  * @return void
    //  */
    // protected function registerCommands(array $commands)
    // {
    //     foreach (array_keys($commands) as $command) {
    //         call_user_func_array([$this, "register{$command}Command"], []);
    //     }
    // }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateCommand()
    {
        $this->app->singleton('command.migrate', function ($app) {
            return new MigrateCommand($app['migrator']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateStatusCommand()
    {
        $this->app->singleton('command.migrate.status', function ($app) {
            return new MigrateStatusCommand($app['migrator']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateResetCommand()
    {
        $this->app->singleton('command.migrate.reset', function ($app) {
            return new MigrateResetCommand($app['migrator']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateRollbackCommand()
    {
        $this->app->singleton('command.migrate.rollback', function ($app) {
            return new MigrateRollbackCommand($app['migrator']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateMakeCommand()
    {
        $this->app->singleton('command.migrate.make', function ($app) {
            // Once we have the migration creator registered, we will create the command
            // and inject the creator. The creator is responsible for the actual file
            // creation of the migrations, and may be extended by these developers.
            $creator = $app['migration.creator'];

            $composer = $app['composer'];

            return new MigrateMakeCommand($creator, $composer);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSeedCommand()
    {
        $this->app->singleton('command.seed', function ($app) {
            return new SeedCommand($app['db']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSeederMakeCommand()
    {
        $this->app->singleton('command.seeder.make', function ($app) {
            return new SeederMakeCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerFactoryMakeCommand()
    {
        $this->app->singleton('command.factory.make', function ($app) {
            return new FactoryMakeCommand($app['files']);
        });
    }
}
