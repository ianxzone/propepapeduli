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

    public function create(Request $request)
    {
        $type = $request->input('type', 'db'); // 'db' or 'full'

        try {
            $database = config('database.connections.mysql.database');
            $timestamp = date('Y-m-d-His');
            $filename = 'backup-' . $database . '-' . $timestamp;
            
            // 1. Generate SQL
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $database;
            $sql = "-- ProPePa PEDULI Database Backup\n-- Date: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
                $sql .= "\n\nDROP TABLE IF EXISTS `$tableName`;\n" . $createTable->{'Create Table'} . ";\n\n";
                
                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $values = collect((array)$row)->map(fn($val) => is_null($val) ? 'NULL' : "'" . addslashes($val) . "'")->implode(', ');
                    $sql .= "INSERT INTO `$tableName` VALUES ($values);\n";
                }
            }

            if ($type === 'full') {
                // 2. Create ZIP (SQL + Uploads)
                $zipFilename = $filename . '-full.zip';
                $zipPath = storage_path('app/backups/' . $zipFilename);
                
                if (!file_exists(dirname($zipPath))) {
                    mkdir(dirname($zipPath), 0755, true);
                }

                $zip = new \ZipArchive();
                if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                    // Add SQL file
                    $zip->addFromString('database.sql', $sql);
                    
                    // Add public uploads
                    $uploadPath = storage_path('app/public');
                    if (is_dir($uploadPath)) {
                        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($uploadPath), \RecursiveIteratorIterator::LEAVES_ONLY);
                        foreach ($files as $name => $file) {
                            if (!$file->isDir()) {
                                $filePath = $file->getRealPath();
                                $relativePath = 'uploads/' . substr($filePath, strlen($uploadPath) + 1);
                                $zip->addFile($filePath, $relativePath);
                            }
                        }
                    }
                    $zip->close();
                }
                $finalFilename = $zipFilename;
            } else {
                // Save as SQL only
                $finalFilename = $filename . '.sql';
                Storage::disk('local')->put('backups/' . $finalFilename, $sql);
            }

            return back()->with('success', 'Backup berhasil dibuat: ' . $finalFilename);
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
