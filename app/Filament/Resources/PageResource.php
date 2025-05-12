<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Forms\Set;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Content';
    
    protected static ?int $navigationSort = 1;
    
    public static function getNavigationLabel(): string
    {
        return __('Page Editor');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('Pages');
    }
    
    public static function getModelLabel(): string
    {
        return __('Page');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => 
                                        $set('slug', Str::slug($state))),
                                    
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                    
                                Select::make('type')
                                    ->options([
                                        'standard' => 'Standard',
                                        'home' => 'Home Page',
                                        'domains' => 'Domains Page',
                                        'hosting' => 'Hosting Page',
                                        'vps' => 'VPS Page',
                                        'cloud' => 'Cloud Page', 
                                        'legal' => 'Legal Page',
                                    ])
                                    ->required()
                                    ->default('standard')
                                    ->reactive(),
                                    
                                Select::make('language')
                                    ->options([
                                        'en' => 'English',
                                        'he' => 'Hebrew (עברית)',
                                    ])
                                    ->required()
                                    ->default('en'),
                                
                                Select::make('parent_id')
                                    ->label('Parent Page')
                                    ->relationship('parent', 'title')
                                    ->searchable()
                                    ->nullable(),
                                    
                                TextInput::make('order')
                                    ->integer()
                                    ->default(0),
                                    
                                Select::make('layout')
                                    ->options([
                                        'default' => 'Default',
                                        'full-width' => 'Full Width',
                                        'sidebar-right' => 'Sidebar Right',
                                        'sidebar-left' => 'Sidebar Left',
                                    ])
                                    ->default('default'),
                                    
                                FileUpload::make('featured_image')
                                    ->directory('pages/featured')
                                    ->image()
                                    ->visibility('public')
                                    ->maxSize(5120) // 5MB
                                    ->nullable(),
                            ])
                            ->columns(2),
                        
                        Tabs::make('Content')
                            ->tabs([
                                Tabs\Tab::make('Main Content')
                                    ->schema([
                                        RichEditor::make('content')
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/attachments')
                                            ->toolbarButtons([
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'codeBlock',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->nullable(),
                                    ]),
                                    
                                Tabs\Tab::make('Structured Content')
                                    ->schema([
                                        KeyValue::make('metadata')
                                            ->keyLabel('Section Key')
                                            ->valueLabel('Content')
                                            ->addable()
                                            ->reorderable()
                                            ->nullable()
                                            ->helperText('Use this section to add structured content that will be rendered in the page template'),
                                    ]),
                                    
                                Tabs\Tab::make('SEO')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->maxLength(70)
                                            ->nullable()
                                            ->helperText('Max 70 characters'),
                                            
                                        Textarea::make('meta_description')
                                            ->maxLength(160)
                                            ->nullable()
                                            ->helperText('Max 160 characters'),
                                            
                                        TextInput::make('meta_keywords')
                                            ->maxLength(255)
                                            ->nullable()
                                            ->helperText('Comma-separated list of keywords'),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 3]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(false)
                                    ->helperText('Make the page publicly accessible'),
                            ]),
                            
                        Section::make('Preview')
                            ->schema([
                                Forms\Components\Placeholder::make('preview_link')
                                    ->content(function ($record) {
                                        if (!$record || !$record->exists) {
                                            return 'Save the page to preview';
                                        }
                                        
                                        return view('filament.components.page-preview-link', [
                                            'url' => $record->getUrl(),
                                        ]);
                                    }),
                            ])
                            ->visible(fn ($record) => $record && $record->exists),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'standard',
                        'success' => 'home',
                        'info' => fn ($state) => in_array($state, ['domains', 'hosting', 'vps', 'cloud']),
                        'warning' => 'legal',
                    ]),
                    
                Tables\Columns\TextColumn::make('language')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'standard' => 'Standard',
                        'home' => 'Home Page',
                        'domains' => 'Domains Page',
                        'hosting' => 'Hosting Page',
                        'vps' => 'VPS Page',
                        'cloud' => 'Cloud Page', 
                        'legal' => 'Legal Page',
                    ]),
                    
                SelectFilter::make('language')
                    ->options([
                        'en' => 'English',
                        'he' => 'Hebrew (עברית)',
                    ]),
                    
                TernaryFilter::make('is_published')
                    ->label('Published'),
                    
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}