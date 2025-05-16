<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobpResource\Pages;
use App\Filament\Resources\JobpResource\RelationManagers;
use App\Models\Jobp;


use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
class JobpResource extends Resource
{
    protected static ?string $model = Jobp::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                   TextInput::make('title')->required(),
        TextInput::make('department')->required(),
        Textarea::make('description')->required(),
        TextInput::make('location'),
        DatePicker::make('deadline')->required(),
        Toggle::make('is_active')->label('Active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                       TextColumn::make('title')->searchable()->sortable(),
        TextColumn::make('department'),
        TextColumn::make('location'),
        TextColumn::make('deadline')->date(),
        IconColumn::make('is_active')->boolean()->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobps::route('/'),
            'create' => Pages\CreateJobp::route('/create'),
            'edit' => Pages\EditJobp::route('/{record}/edit'),
        ];
    }
}
