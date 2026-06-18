<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportDatabaseDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import-dump {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import simpleak_kuesioner.sql database dump into the active database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = base_path('simpleak_kuesioner.sql');

        if (!File::exists($filePath)) {
            $this->error("SQL dump file not found at: {$filePath}");
            return 1;
        }

        if (!$this->option('force')) {
            if (!$this->confirm('WARNING: This will overwrite tables in your current database. Do you want to proceed?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Importing database dump...');

        try {
            $sql = File::get($filePath);
            
            // Execute the raw SQL dump
            DB::unprepared($sql);
            
            $this->info('✅ Database successfully imported!');
            
            // Try to count kuesioners to verify
            try {
                $count = DB::table('kuesioners')->count();
                $this->info("Current Kuesioners Count: {$count}");
            } catch (\Exception $e) {
                // Table might not exist or error, ignore
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error importing database: " . $e->getMessage());
            return 1;
        }
    }
}
