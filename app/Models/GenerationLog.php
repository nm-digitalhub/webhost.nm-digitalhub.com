<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenerationLog extends Model
{
    protected $fillable = [
        'user_id',
        'generator_id',
        'entity_type',
        'entity_name',
        'namespace',
        'command',
        'params',
        'status',
        'error_message',
        'file_path',
        'overwritten',
    ];

    protected $casts = [
        'params' => 'array',
        'overwritten' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generator()
    {
        return $this->belongsTo(Generator::class);
    }
}
