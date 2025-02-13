<?php

namespace Illuminate\Queue\Console;

use Illuminate\Console\MigrationGeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:queue-failed-table')]
class FailedTableCommand extends MigrationGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:queue-failed-table';

    /**
     * The console command name aliases.
     *
     * @var array
     */
    protected $aliases = ['queue:failed-table'];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the failed queue jobs database table';

    /**
     * Get the migration table name.
     *
     * @return string
     */
    protected function migrationTableName()
    {
        return $this->laravel['config']['queue.failed.table'];
    }

    /**
     * Get the path to the migration stub file.
     *
     * @return string
     */
    protected function migrationStubFile()
    {
        return __DIR__.'/stubs/failed_jobs.stub';
    }

    /**
     * Determine whether a migration for the table already exists.
     *
     * @param  string  $table
     * @return bool
     */
    protected function migrationExists($table)
    {
        if ($table !== 'failed_jobs') {
            return parent::migrationExists($table);
        }

        return count($this->files->glob(sprintf(
            '{%s,%s}',
            $this->laravel->joinPaths($this->laravel->databasePath('migrations'), '*_*_*_*_create_'.$table.'_table.php'),
            $this->laravel->joinPaths($this->laravel->databasePath('migrations'), '0001_01_01_000003_create_jobs_table.php'),
        ))) !== 0;
    }
}
