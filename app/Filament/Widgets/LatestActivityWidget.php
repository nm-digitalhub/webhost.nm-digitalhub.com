<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\GenerationLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestActivityWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $pollingInterval = '30s';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Get the latest generation logs
                GenerationLog::query()
                    ->with('user', 'generator')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('generator.name')
                    ->label('Generator')
                    ->searchable(),

                Tables\Columns\TextColumn::make('file_path')
                    ->label('File Path')
                    ->limit(40)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->searchable(),

                Tables\Columns\IconColumn::make('success')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->heading('Latest Activity')
            ->description('Recent code generation activity')
            ->emptyStateHeading('No recent activity')
            ->emptyStateDescription('Code generation logs will appear here when users create code.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->paginated(false);
    }
}
