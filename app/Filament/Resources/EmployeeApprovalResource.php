<?php


namespace App\Filament\Resources;

use App\Models\Employee;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;


use App\Filament\Resources\EmployeeApprovalResource\Pages;
use App\Filament\Resources\EmployeeApprovalResource\RelationManagers;

use Filament\Forms\Form;


use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeApprovalResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Employee Approvals';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Employee Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('is_approved')
                    ->label('Approved')
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->actions([
                Action::make('toggleApproval')
                    ->label(fn (Employee $record) => $record->is_approved ? 'Disapprove' : 'Approve')
                    ->color(fn (Employee $record) => $record->is_approved ? 'danger' : 'success')
                    ->action(function (Employee $record) {
                        $record->is_approved = !$record->is_approved; // Toggle approval status
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->icon(fn (Employee $record) => $record->is_approved ? 'heroicon-o-x-mark' : 'heroicon-o-check')
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeApprovals::route('/'),
        ];
    }
}
