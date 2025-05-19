<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemResourcesWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        // Get CPU usage
        $cpuLoad = $this->getCpuUsage();

        // Get memory usage
        $memoryUsage = $this->getMemoryUsage();

        // Get disk usage
        $diskUsage = $this->getDiskUsage();

        // PHP version and extensions
        $phpVersion = phpversion();
        $phpExtensions = implode(', ', array_slice(get_loaded_extensions(), 0, 3)).'...';

        return [
            Stat::make('CPU Usage', $cpuLoad['percentage'].'%')
                ->description($cpuLoad['description'])
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color($cpuLoad['color'])
                ->chart($cpuLoad['chart']),

            Stat::make('Memory Usage', $memoryUsage['percentage'].'%')
                ->description($memoryUsage['description'])
                ->descriptionIcon('heroicon-m-variable')
                ->color($memoryUsage['color'])
                ->chart($memoryUsage['chart']),

            Stat::make('Disk Usage', $diskUsage['percentage'].'%')
                ->description($diskUsage['description'])
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color($diskUsage['color'])
                ->chart($diskUsage['chart']),

            Stat::make('PHP Version', $phpVersion)
                ->description('Extensions: '.$phpExtensions)
                ->descriptionIcon('heroicon-m-code-bracket')
                ->color('gray'),
        ];
    }

    private function getCpuUsage(): array
    {
        // Linux-specific CPU load monitoring
        $load = sys_getloadavg();
        $cores = $this->getCpuCores();

        // Normalize the 1-minute load average against number of cores
        $normalizedLoad = $load[0] / $cores;
        $percentage = min(round($normalizedLoad * 100), 100);

        // Determine status based on load
        if ($percentage < 50) {
            $color = 'success';
            $description = 'System load is normal';
        } elseif ($percentage < 80) {
            $color = 'warning';
            $description = 'Moderate system load';
        } else {
            $color = 'danger';
            $description = 'High system load';
        }

        // Generate a simple chart with some random fluctuation to simulate recent history
        $chart = $this->generateRandomChart($percentage, 10);

        return [
            'percentage' => $percentage,
            'description' => $description,
            'color' => $color,
            'chart' => $chart,
        ];
    }

    private function getMemoryUsage(): array
    {
        if (function_exists('memory_get_usage')) {
            // Get memory info from /proc/meminfo on Linux systems
            if (is_readable('/proc/meminfo')) {
                $memInfo = file_get_contents('/proc/meminfo');
                preg_match('/MemTotal:\s+(\d+)/', $memInfo, $memTotal);
                preg_match('/MemFree:\s+(\d+)/', $memInfo, $memFree);
                preg_match('/Buffers:\s+(\d+)/', $memInfo, $buffers);
                preg_match('/Cached:\s+(\d+)/', $memInfo, $cached);

                $total = isset($memTotal[1]) ? (int) $memTotal[1] : 0;
                $free = isset($memFree[1]) ? (int) $memFree[1] : 0;
                $buffers = isset($buffers[1]) ? (int) $buffers[1] : 0;
                $cached = isset($cached[1]) ? (int) $cached[1] : 0;

                $used = $total - $free - $buffers - $cached;
                $percentage = $total > 0 ? round(($used / $total) * 100) : 0;

                $actualFree = ($free + $buffers + $cached) / 1024;
                $totalMB = round($total / 1024);
                $freeMB = round($actualFree);
                $description = "Free: {$freeMB}MB of {$totalMB}MB";
            } else {
                // Fallback to PHP memory info if /proc/meminfo is not available
                $memUsage = memory_get_usage(true);
                $memLimit = ini_get('memory_limit');
                $memLimitBytes = $this->getMemoryLimitInBytes($memLimit);

                $percentage = $memLimitBytes > 0 ? round(($memUsage / $memLimitBytes) * 100) : 0;
                $description = 'Using '.$this->formatBytes($memUsage).' of '.$memLimit;
            }
        } else {
            // Fallback if memory_get_usage is not available
            $percentage = 0;
            $description = 'Memory info unavailable';
        }

        // Determine status based on memory usage
        if ($percentage < 60) {
            $color = 'success';
        } elseif ($percentage < 85) {
            $color = 'warning';
        } else {
            $color = 'danger';
        }

        // Generate a chart with some random fluctuation
        $chart = $this->generateRandomChart($percentage, 15);

        return [
            'percentage' => $percentage,
            'description' => $description,
            'color' => $color,
            'chart' => $chart,
        ];
    }

    private function getDiskUsage(): array
    {
        $path = '/';
        if (function_exists('disk_free_space') && function_exists('disk_total_space')) {
            $free = disk_free_space($path);
            $total = disk_total_space($path);
            $used = $total - $free;

            $percentage = $total > 0 ? round(($used / $total) * 100) : 0;
            $description = 'Free: '.$this->formatBytes($free).' of '.$this->formatBytes($total);
        } else {
            $percentage = 0;
            $description = 'Disk info unavailable';
        }

        // Determine status based on disk usage
        if ($percentage < 70) {
            $color = 'success';
        } elseif ($percentage < 90) {
            $color = 'warning';
        } else {
            $color = 'danger';
        }

        // Generate a chart that gradually increases (since disk usage tends to grow)
        $chart = $this->generateIncreasingChart($percentage, 5);

        return [
            'percentage' => $percentage,
            'description' => $description,
            'color' => $color,
            'chart' => $chart,
        ];
    }

    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= 1024 ** $pow;

        return round($bytes, $precision).' '.$units[$pow];
    }

    private function getMemoryLimitInBytes($memoryLimit): int
    {
        if ($memoryLimit === '-1') {
            return PHP_INT_MAX;
        }

        $unit = strtolower(substr((string) $memoryLimit, -1));
        $value = (int) substr((string) $memoryLimit, 0, -1);

        switch ($unit) {
            case 'g':
                $value *= 1024;
                // fall through
                // no break
            case 'm':
                $value *= 1024;
                // fall through
                // no break
            case 'k':
                $value *= 1024;
        }

        return $value;
    }

    private function getCpuCores(): int
    {
        $cores = 1; // Default to 1 core

        // Try to detect number of cores on Linux systems
        if (is_readable('/proc/cpuinfo')) {
            $cpuinfo = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', $cpuinfo, $matches);
            $cores = count($matches[0]);
        }

        return max(1, $cores);
    }

    private function generateRandomChart($currentValue, $variance): array
    {
        $values = [];
        for ($i = 0; $i < 7; $i++) {
            $randomFactor = mt_rand(-$variance, $variance);
            $value = max(0, min(100, $currentValue + $randomFactor));
            $values[] = $value;
        }

        // Ensure the last value is the current value
        $values[6] = $currentValue;

        return $values;
    }

    private function generateIncreasingChart($currentValue, $variance): array
    {
        $values = [];
        $base = max(0, $currentValue - ($variance * 6));

        for ($i = 0; $i < 7; $i++) {
            $randomFactor = mt_rand(-$variance / 2, $variance);
            $value = max(0, min(100, $base + ($i * $variance) + $randomFactor));
            $values[] = $value;
        }

        // Ensure the last value is the current value
        $values[6] = $currentValue;

        return $values;
    }
}
