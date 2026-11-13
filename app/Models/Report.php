<?php

namespace App\Models;

use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'type', 'category', 'title', 'description', 'location', 'happened_at', 'status'])]
class Report extends Model
{
    public const CATEGORIES = [
        'phone' => 'Телефон',
        'wallet' => 'Паричник',
        'keys' => 'Клучеви',
        'backpack' => 'Ранец',
        'documents' => 'Документи',
        'electronics' => 'Електроника',
        'jewelry' => 'Накит',
        'clothing' => 'Облека',
        'other' => 'Друго',
    ];

    /** @use HasFactory<ReportFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'happened_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
