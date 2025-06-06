<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhonevilleBranchResource\Pages;
use App\Filament\Resources\PhonevilleBranchResource\RelationManagers;
use App\Models\PhonevilleBranch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\TextInput;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction as ExportAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction as FilamentExportBulkAction;

class PhonevilleBranchResource extends Resource
{
    protected static ?string $model = PhonevilleBranch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?int $navigationSort = 7;
    //Who has access
    public static function canViewAny(): bool
    {
        return Auth::user()->role === 'Superadmin';
    }

    public static function canCreate(): bool
    {
        return Auth::user()->role === 'Superadmin';
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->role === 'Superadmin';
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'Superadmin';
    }


    //Form
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('store_name')->required(),

                TextArea::make('store_location')->required(),
                // Customer Number
                TextInput::make('contact_number')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                    ->required()
                    ->maxLength(20)
                    ->label('Branch Contact Number')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('store_name')->sortable(),
                TextColumn::make('store_location')->sortable(),
                TextColumn::make('contact_number')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Export Branches')

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPhonevilleBranches::route('/'),
            'create' => Pages\CreatePhonevilleBranch::route('/create'),
            'edit' => Pages\EditPhonevilleBranch::route('/{record}/edit'),
        ];
    }
}
