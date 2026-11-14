<?php

namespace App\Models;

use App\Enums\ReportCategory;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'type', 'category', 'title', 'description', 'image', 'location', 'happened_at', 'status'])]
class Report extends Model
{
    /** @use HasFactory<ReportFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'happened_at' => 'date',
            'type' => ReportType::class,
            'category' => ReportCategory::class,
            'status' => ReportStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categoryLabel(): string
    {
        return $this->category->label();
    }

    public function imageUrl(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}
