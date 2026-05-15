<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Storage::disk('local')->files('backups');
        $backups = collect($backups)->map(function ($file) {
            return [
                'name' => basename($file),
                'size' => round(Storage::disk('local')->size($file) / 1024 / 1024, 2) . ' MB',
                'date' => date('Y-m-d H:i:s', Storage::disk('local')->lastModified($file)),
                'path' => $file
            ];
        })->sortByDesc('date');

        return view('admin.backup.index', compact('backups'));
    }

    public function create()
    {
        try {
            $database = config('database.connections.mysql.database');
            $filename = 'backup-' . $database . '-' . date('Y-m-d-His') . '.sql';
            
            // Simple SQL Export logic
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $database;
            
            $sql = "-- ProPePa PEDULI Database Backup\n";
            $sql .= "-- Date: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                
                // Structure
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
                $sql .= "\n\n-- Table structure for `$tableName` --\n";
                $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Dumping data for `$tableName` --\n";
                    foreach ($rows as $row) {
                        $values = collect((array)$row)->map(function ($val) {
                            if (is_null($val)) return 'NULL';
                            return "'" . addslashes($val) . "'";
                        })->implode(', ');
                        
                        $sql .= "INSERT INTO `$tableName` VALUES ($values);\n";
                    }
                }
            }

            Storage::disk('local')->put('backups/' . $filename, $sql);

            return back()->with('success', 'Backup database berhasil dibuat: ' . $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        if (Storage::disk('local')->exists('backups/' . $filename)) {
            return Storage::disk('local')->download('backups/' . $filename);
        }
        abort(404);
    }

    public function delete($filename)
    {
        if (Storage::disk('local')->exists('backups/' . $filename)) {
            Storage::disk('local')->delete('backups/' . $filename);
            return back()->with('success', 'File backup berhasil dihapus.');
        }
        return back()->with('error', 'File tidak ditemukan.');
    }
}
