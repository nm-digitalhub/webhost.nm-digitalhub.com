<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SystemHealthWidget extends Widget
{
    protected static ?int $sort = 5;

    protected static string $view = 'filament.widgets.system-health-widget';

    protected int|string|array $columnSpan = 'full';

    // Mock system health checks (in a real implementation, these would come from actual checks)
    protected function getHealthChecks(): array
    {
        return [
            $this->checkDatabaseConnection(),
            $this->checkCacheSystem(),
            $this->checkStoragePermissions(),
            $this->checkQueueSystem(),
        ];
    }

    protected function checkDatabaseConnection(): array
    {
        try {
            DB::connection()->getPdo();

            return [
                'name' => 'Database Connection',
                'status' => 'passing',
                'message' => 'Connected to ' . config('database.connections.mysql.database'),
                'icon' => 'heroicon-o-circle-stack',
            ];
        } catch (\Exception $e) {
            return [
                'name' => 'Database Connection',
                'status' => 'failing',
                'message' => 'Database connection failed: ' . $e->getMessage(),
                'icon' => 'heroicon-o-circle-stack',
            ];
        }
    }

    protected function checkCacheSystem(): array
    {
        try {
            $cacheDriver = config('cache.default');
            $value = 'test_' . time();
            Cache::put('health_check', $value, 1);
            $retrieved = Cache::get('health_check');

            if ($retrieved === $value) {
                return [
                    'name' => 'Cache System',
                    'status' => 'passing',
                    'message' => 'Using ' . $cacheDriver . ' driver',
                    'icon' => 'heroicon-o-bolt',
                ];
            } else {
                return [
                    'name' => 'Cache System',
                    'status' => 'warning',
                    'message' => 'Cache retrieval inconsistent',
                    'icon' => 'heroicon-o-bolt',
                ];
            }
        } catch (\Exception $e) {
            return [
                'name' => 'Cache System',
                'status' => 'failing',
                'message' => 'Cache error: ' . $e->getMessage(),
                'icon' => 'heroicon-o-bolt',
            ];
        }
    }

    protected function checkStoragePermissions(): array
    {
        $storagePath = storage_path();

        if (! is_dir($storagePath)) {
            return [
                'name' => 'Storage Directory',
                'status' => 'failing',
                'message' => 'Storage directory does not exist',
                'icon' => 'heroicon-o-folder',
            ];
        }

        if (! is_writable($storagePath)) {
            return [
                'name' => 'Storage Permissions',
                'status' => 'failing',
                'message' => 'Storage directory is not writable',
                'icon' => 'heroicon-o-folder',
            ];
        }

        // Get available disk space
        $freeSpace = disk_free_space($storagePath);
        $totalSpace = disk_total_space($storagePath);
        $usedPercentage = round(($totalSpace - $freeSpace) / $totalSpace * 100);

        if ($usedPercentage > 90) {
            return [
                'name' => 'Storage Space',
                'status' => 'failing',
                'message' => 'Storage is ' . $usedPercentage . '% full. Only ' . $this->formatBytes($freeSpace) . ' free',
                'icon' => 'heroicon-o-folder',
            ];
        } elseif ($usedPercentage > 75) {
            return [
                'name' => 'Storage Space',
                'status' => 'warning',
                'message' => 'Storage is ' . $usedPercentage . '% full. ' . $this->formatBytes($freeSpace) . ' free',
                'icon' => 'heroicon-o-folder',
            ];
        } else {
            return [
                'name' => 'Storage Space',
                'status' => 'passing',
                'message' => $this->formatBytes($freeSpace) . ' free (' . $usedPercentage . '% used)',
                'icon' => 'heroicon-o-folder',
            ];
        }
    }

    protected function checkQueueSystem(): array
    {
        $queueConnection = config('queue.default');
        $queueStatus = 'unknown';
        $message = '';

        if ($queueConnection === 'sync') {
            $queueStatus = 'warning';
            $message = 'Using sync driver (not recommended for production)';
        } elseif ($queueConnection === 'database') {
            try {
                $failedCount = DB::table('failed_jobs')->count();
                $jobsCount = 0;

                if (Schema::hasTable('jobs')) {
                    $jobsCount = DB::table('jobs')->count();
                }

                if ($failedCount > 0) {
                    $queueStatus = 'warning';
                    $message = $failedCount . ' failed jobs in queue';
                } else {
                    $queueStatus = 'passing';
                    $message = 'Queue has ' . $jobsCount . ' pending jobs';
                }
            } catch (\Exception $e) {
                $queueStatus = 'failing';
                $message = 'Queue error: ' . $e->getMessage();
            }
        } elseif (in_array($queueConnection, ['redis', 'beanstalkd', 'sqs'])) {
            $queueStatus = 'passing';
            $message = 'Using ' . $queueConnection . ' driver';
        }

        return [
            'name' => 'Queue System',
            'status' => $queueStatus,
            'message' => $message,
            'icon' => 'heroicon-o-queue-list',
        ];
    }

    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= 1024 ** $pow;

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    protected function getViewData(): array
    {
        return [
            'healthChecks' => $this->getHealthChecks(),
        ];
    }
}
