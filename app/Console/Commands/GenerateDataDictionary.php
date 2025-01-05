<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateDataDictionary extends Command
{
    protected $signature = 'generate:dictionary';
    protected $description = 'Generate a data dictionary for the database';

    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        $database = env('DB_DATABASE');
        $output = [];

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_{$database}"};
            $columns = DB::select("SHOW COLUMNS FROM {$tableName}");

            $output[$tableName] = array_map(function ($column) {
                return [
                    'Field' => $column->Field,
                    'Type' => $column->Type,
                    'Null' => $column->Null,
                    'Key' => $column->Key,
                    'Default' => $column->Default,
                    'Extra' => $column->Extra,
                ];
            }, $columns);
        }

        $filePath = storage_path('app/data_dictionary.json');
        file_put_contents($filePath, json_encode($output, JSON_PRETTY_PRINT));
        $this->info("Data dictionary generated at: {$filePath}");
    }
}
