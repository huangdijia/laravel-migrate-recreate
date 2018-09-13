<?php

namespace Huangdijia\Migrate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecreateAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:recreate-all {--y|yes : Sure?}';

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
        if (!$yes && !$this->confirm('Are you sure you want to do this?', false)) {
            $this->info('Bye bye ^_^');
            return false;
        }

        DB::table('migrations')
            ->get()
            ->tap(function ($tables) {
                $this->warn($tables->count() . ' tables will recreate now');
            })
            ->each(function ($item) {
                $table = self::getTable($item->migration);
                $this->info('Recreating ' . $table);
                if (!$table) {
                    return;
                }

                $this->call('migrate:recreate', ['table' => $table, '-y' => true]);
            })
            ->tap(function () {
                $this->info('Okey');
            });
    }

    public static function getTable($migration = '')
    {
        if (preg_match('/create_(.*)_table$/i', $migration, $matches)) {
            return $matches[1];
        }
        return '';
    }
}
