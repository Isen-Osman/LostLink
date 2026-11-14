<?php

namespace App\Http\Requests;

use App\Enums\ReportCategory;
use App\Enums\ReportType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(ReportType::class)],
            'category' => ['required', Rule::enum(ReportCategory::class)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'location' => ['required', 'string', 'max:255'],
            'happened_at' => ['required', 'date'],
        ];
    }
}
