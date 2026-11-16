<?php

use App\Enums\ReportCategory;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement(sprintf(
            'ALTER TABLE reports ADD CONSTRAINT reports_type_check CHECK (type IN (%s))',
            $this->quoted(ReportType::cases()),
        ));

        DB::statement(sprintf(
            'ALTER TABLE reports ADD CONSTRAINT reports_category_check CHECK (category IN (%s))',
            $this->quoted(ReportCategory::cases()),
        ));

        DB::statement(sprintf(
            'ALTER TABLE reports ADD CONSTRAINT reports_status_check CHECK (status IN (%s))',
            $this->quoted(ReportStatus::cases()),
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE reports DROP CONSTRAINT IF EXISTS reports_type_check');
        DB::statement('ALTER TABLE reports DROP CONSTRAINT IF EXISTS reports_category_check');
        DB::statement('ALTER TABLE reports DROP CONSTRAINT IF EXISTS reports_status_check');
    }

    /**
     * @param  array<int, ReportType|ReportCategory|ReportStatus>  $cases
     */
    private function quoted(array $cases): string
    {
        return implode(', ', array_map(
            fn ($case) => DB::getPdo()->quote($case->value),
            $cases,
        ));
    }
};
