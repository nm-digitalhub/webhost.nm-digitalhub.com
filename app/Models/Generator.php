<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'namespace',
        'extends',
        'implements',
        'traits',
        'fillable',
        'fields',
        'timestamps',
        'soft_deletes',
        'relations',
        'group',
        'icon',
        'label',
        'preview_before_generate',
        'confirm_overwrite',
        'target_path',
    ];
    
    protected $casts = [
        'fillable' => 'boolean',
        'timestamps' => 'boolean',
        'soft_deletes' => 'boolean',
        'preview_before_generate' => 'boolean',
        'confirm_overwrite' => 'boolean',
        'fields' => 'array',
        'relations' => 'array',
    ];
    
    public function generationLogs()
    {
        return $this->hasMany(GenerationLog::class);
    }
}
