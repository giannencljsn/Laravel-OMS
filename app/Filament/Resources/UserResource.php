<?php 

namespace App\Filament\Resources;

use App\Models\User;

//Filament Resource

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Password; 
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\BadgeColumn;

//Illuminate 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

//Export Action
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction as ExportAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction as FilamentExportBulkAction;
use App\Filament\Exports\UserExporter;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;

//Import Action
use App\Filament\Imports\UserImporter;
use Filament\Tables\Actions\ImportAction;


class UserResource extends Resource 
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Name Field
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Full Name'),

                // Email Field
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Email'),

                // Password Field
                TextInput::make('password')
                    ->label('Password')
                    ->minLength(8)
                    ->placeholder(fn($record) => $record && !empty ($record->password) ? 'Password is already set' : 'Enter a password')
                    ->disabled(fn($record) => $record && !empty ($record->password))
                    ->required(fn($record) => !$record),

                // Address Field
                TextInput::make('address')
                    ->nullable()
                    ->label('Address'),

                // Store Assigned Field
                Select::make('store_assigned')
                    ->nullable()
                    ->label('Store Assigned')
                    ->options(function () {
                        // Fetching all store names from the phoneville_branches table and ensuring ID is an integer
                        return DB::table('phoneville_branches')
                            ->pluck('store_name', 'id')
                            ->mapWithKeys(function ($value, $key) {
                            return [(int) $key => $value]; // Ensure the ID is an integer
                        });
                    })
                    ->placeholder('Select a store')
                    ->searchable(),





                // Role Field
                Select::make('role')
                    ->options([
                        'Superadmin' => 'Superadmin',
                        'Admin' => 'Admin',
                        'Store_Staff' => 'Store_Staff',
                    ])
                    ->required()
                    ->label('Role'),

                // Status Field
                Select::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->required()
                    ->default('Active')
                    ->label('Status'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Display Name Field
                TextColumn::make('name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable(),

                // Display Email Field
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                // Display Role Field
                TextColumn::make('role')
                    ->label('Role')
                    ->sortable()
                    ->searchable(),

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
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                    ]),
            ])
            ->filters([
                // You can add filters here if needed, for example:
                // Select::make('role')->options([
                //     'Superadmin' => 'Superadmin',
                //     'Admin' => 'Admin',
                //     'Store_Staff' => 'Store_Staff',
                // ])
            ])
            ->actions([
                // Only show edit action for Superadmin
                Auth::user()->role === 'Superadmin'
                ? Tables\Actions\EditAction::make()
                : null,
                // Optionally add other actions here
            ])
            ->headerActions([
                //Import
                ImportAction::make()
                    ->importer(UserImporter::class),
                //Export
                ExportAction::make('export')
                    ->label('Export Users')

            ])
            ->bulkActions([
                // Only show edit action for Superadmin
                Auth::user()->role === 'Superadmin'
                ? Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                : null,
                // Optionally add other actions here
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

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
}