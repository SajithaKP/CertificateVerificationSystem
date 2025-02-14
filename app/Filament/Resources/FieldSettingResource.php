<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FieldSettingResource\Pages;
use App\Filament\Resources\FieldSettingResource\RelationManagers;
use App\Models\FieldSetting;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FieldSettingResource extends Resource
{
    protected static ?string $model = FieldSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('field_name')
                ->label('Field Name')
                ->disabled()
                ->required(),

            Toggle::make('is_enabled')
                ->label('Enabled')
                ->default(true),

            TextInput::make('step_order')
                ->label('Step Order')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('field_name')
                    ->label('Field Name')
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('is_enabled')
                    ->label('Enabled')
                    ->sortable(),

                TextColumn::make('step_order')
                    ->label('Step Order')
                    ->sortable(),
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
            'index' => Pages\ListFieldSettings::route('/'),
            'create' => Pages\CreateFieldSetting::route('/create'),
            'edit' => Pages\EditFieldSetting::route('/{record}/edit'),
        ];
    }
}


