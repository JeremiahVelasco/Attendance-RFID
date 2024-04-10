<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $admins = User::where('role', User::ADMIN)->count();
        $faculty = User::where('role', User::FACULTY)->count();
        $staff = User::where('role', User::STAFF)->count();
        $students = User::where('role', User::STUDENT)->count();

        return [
            Stat::make('Total Users', User::count()),
            Stat::make('Total Faculty', $faculty),
            Stat::make('Total Admins', $admins),
            Stat::make('Total Staff', $staff),
            Stat::make('Total Students', $students),
        ];
    }
}
