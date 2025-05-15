<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers;

use App\Http\Controllers\Controller;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileScanController extends Controller
{
    public function scanFiles()
    {
        $directoryPath = '/var/www/vhosts/nm-digitalhub.com/webhost.nm-digitalhub.com';
        $files = [];

        if (is_dir($directoryPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directoryPath));

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $files[] = $file->getPathname();
                }
            }
        }

        return response()->json([
            'files' => $files,
        ]);
    }
}
