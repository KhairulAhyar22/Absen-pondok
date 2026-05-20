<?php

namespace App\Filament\Resources\Absensis\Widgets;

use App\Filament\Resources\Absensis\Pages\ListAbsensis;
use Filament\Widgets\Widget;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class AbsensiOverview extends BaseWidget
{

    // public ?Model $record = null;
    // protected string $view = 'filament.resources.absensis.widgets.absensi-overview';

    protected function getStats(): array
    {
        return [
            Stat::make('-', '21%'),
            Stat::make('-', '3:12'),
            Stat::make('-', '3:12'),
        ];

    }
}
