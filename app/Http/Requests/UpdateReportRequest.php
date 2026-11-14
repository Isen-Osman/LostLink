<?php

namespace App\Http\Requests;

use App\Enums\ReportCategory;
use App\Enums\ReportType;
use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Report $report */
        $report = $this->route('report');

        return $this->user()->can('update', $report);
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
