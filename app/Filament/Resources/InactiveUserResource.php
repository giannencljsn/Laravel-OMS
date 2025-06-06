<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InactiveUserResource\Pages;
use App\Filament\Resources\InactiveUserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\InactiveUser;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction as ExportAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction as FilamentExportBulkAction;

class InactiveUserResource extends Resource
{
    protected static ?string $model = InactiveUser::class;

    protected static ?string $navigationLabel = 'Inactive Users';

    protected static ?string $navigationIcon = 'heroicon-o-user-minus';

    protected static ?int $navigationSort = 5;
    public static function canViewAny(): bool
    {
        return in_array(Auth::user()->role, ['Superadmin', 'Admin']);
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'Superadmin';
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('store_assigned', auth()->user()->store_assigned)
            ->where('status', 'Inactive');
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('name')->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')->label('Email'),
                // Display Store Assigned Field (you can fetch store names from the database)
                TextColumn::make('store_assigned')
                    ->label('Store Assigned')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        // Fetch the store name based on the store_assigned ID
                        return DB::table('phoneville_branches')
                            ->where('id', $record->store_assigned)
                            ->value('store_name');
                    }),
                BadgeColumn::make('status')
                    ->colors(['danger' => 'Inactive']),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Export Inactive Users')

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->authorize(fn() => Auth::user()->role === 'Superadmin'), // Ensure only Superadmin can delete
                ]),
                //export
                FilamentExportBulkAction::make('export')
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
            'index' => Pages\ListInactiveUsers::route('/'),

            'edit' => Pages\EditInactiveUser::route('/{record}/edit'),
        ];
    }
}
