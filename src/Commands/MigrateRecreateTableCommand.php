<?php

namespace Huangdijia\Migrate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RecreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:recreate {table* : Tables} {--y|yes : Sure?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recreate table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $yes = $this->option('yes');
        if (!$yes && !$this->confirm('Are you sure?', false)) {
            $this->info('Alright');
            return false;
        }

        $tables = $this->argument('table');

        collect($tables)->tap(function ($tables) {
            $this->info('Recreate beginning');
        })->each(function ($table) {
            // clean up migrate records
            $this->info('Clean up ' . $table . ' migrate records');
            DB::table('migrations')
                ->where('migration', 'like', "%create_{$table}_table")
                ->orWhere('migration', 'like', "%alter_{$table}_table")
                ->delete();

            // rename table
            $backup = self::backupTableName($table);
            try {
                Schema::dropIfExists($backup);
                $this->info('Renaming ' . $table . ' to ' . $backup);
                Schema::rename($table, $backup);
            } catch (\Exception $e) {
                $this->warn('Renamed faild, error: ' . $e->getMessage());
                $this->info('Deleting ' . $table);
                Schema::dropIfExists($table);
                $this->info('Deleting backup table ' . $backup);
                Schema::dropIfExists($backup);
            }
        })->tap(function () {
            // do migrates
            $this->info('Migrating');
            $this->call('migrate');
        })->each(function ($table) {
            try {
                $backup = self::backupTableName($table);
                // get columns of table
                $this->info('Analyzing ' . $table . ' and ' . $backup . ' table structure');
                $newColumns  = Schema::getColumnListing($table);
                $bakColumns  = Schema::getColumnListing($backup);
                $columns     = array_intersect($bakColumns, $newColumns);
                $loseColumns = array_diff($bakColumns, $newColumns);

                // restore data from backup table
                if (!empty($columns)) {
                    $this->info('Restoring data from ' . $backup);
                    if ($loseColumns) {
                        $this->warn('Fields of ' . self::columnsToString($loseColumns) . ' will be abandoned');
                    }

                    $sql = sprintf(
                        'insert ignore into %s (%s) select %s from %s',
                        self::fullTableName($table),
                        self::columnsToString($columns),
                        self::columnsToString($columns),
                        self::fullTableName($backup)
                    );
                    DB::statement($sql);
                }
            } catch (\Exception $e) {
                $this->warn('Restored faild, error: ' . $e->getMessage());
            }
            // remove backup
            $this->info('Remove ' . $backup);
            Schema::dropIfExists($backup);
        })->tap(function () {
            // completed
            $this->info('Migrate completed');
        });
    }

    protected static function fullTableName($table = '')
    {
        return config('database.connections.mysql.prefix') . $table;
    }

    protected static function backupTableName($table = '')
    {
        return $table . '_bak_at_' . date('ymd');
    }

    protected static function columnsToString($columns = [])
    {
        if (empty($columns)) {
            return '';
        }

        return '`' . join('`, `', $columns) . '`';
    }
}
