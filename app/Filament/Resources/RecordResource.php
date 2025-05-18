<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordResource\Pages;
use App\Filament\Resources\RecordResource\RelationManagers;
use App\Models\Record;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecordResource extends Resource
{
    protected static ?string $model = Record::class;

     protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Records';
    protected static ?string $navigationGroup = 'System';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
         
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('user.name')->label('User')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('action')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('description')->limit(50),
            Tables\Columns\TextColumn::make('ip_address')->label('IP'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Logged At')->sortable(),
            ])
              ->defaultSort('created_at', 'desc')
            ->filters([
                //
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
            'index' => Pages\ListRecords::route('/'),
            //'create' => Pages\CreateRecord::route('/create'),
            //'edit' => Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
