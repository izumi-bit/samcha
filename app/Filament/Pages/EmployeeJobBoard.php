<?php

namespace App\Filament\Pages;

use App\Models\Jobp;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;

class EmployeeJobBoard extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static string $view = 'filament.pages.employee-job-board';
    protected static ?string $navigationLabel = 'Job Board';
    protected static ?string $title = 'Employee Job Board';
    protected static ?int $navigationSort = 10;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Jobp::query())
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Job Title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->label('Description')->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('department.name')->label('Department'),
                Tables\Columns\TextColumn::make('created_at')->label('Posted On')->date()->sortable(),
            ]);
    }
}
