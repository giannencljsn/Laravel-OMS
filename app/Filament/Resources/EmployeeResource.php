<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Password;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;


use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction as ExportAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction as FilamentExportBulkAction;
use Filament\Tables\Columns\BadgeColumn;

class EmployeeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $pluralModelLabel = 'Employees';

    protected static ?int $navigationSort = 6;
  
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
                    ->password() // Displays the input as a password field
                    ->required(fn($get) => !$get('id')) // Required only for new records
                    ->minLength(8)
                    ->disabled(fn($get) => $get('id') !== null) // Disable for existing records
                    ->dehydrated(fn($state) => !empty ($state)) // Only save if a new password is provided
                    ->label('Password'),

                // Address Field
                TextInput::make('address')
                    ->nullable()
                    ->label('Address'),

                // Store Assigned field (select dropdown, disabled for the user)
                Select::make('store_assigned')
                    ->options(function () {
                        $user = auth()->user();
                        if ($user->role === 'Superadmin') {
                            // Fetch all stores for Superadmin
                            $stores = DB::table('phoneville_branches')->pluck('store_name', 'id');
                            
                            return $stores; // Return all stores as key-value pairs
                        } else {
                            // Fetch only the assigned store for other users
                            $storeAssignedId = $user->store_assigned;
                            \Log::info("User's store_assigned ID: " . $storeAssignedId); // Log the store_assigned ID
                            $storeName = DB::table('phoneville_branches')
                                ->where('id', $storeAssignedId)
                                ->value('store_name'); // Get the store name based on the user's store_assigned ID

                            \Log::info("Fetched store name: " . $storeName); // Log the fetched store name
                            return [
                                $storeAssignedId => $storeName, // Return the ID and name pair for display
                            ];
                        }
                    })
                    ->default(fn () => auth()->user()->role === 'Superadmin' ? null : auth()->user()->store_assigned) // Default for non-Superadmin
                    ->placeholder('Select a store') // Placeholder text
                    ->required(), // Ensure the field is required if needed


                // Role Field
                Select::make('role')
                    ->options([
                        'Store_Staff' => 'Store_Staff',
                        'Admin' => 'Admin',
                        'Superadmin' => 'Superadmin'
                    ])
                    ->default('Store_Staff')
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
        //

    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn() => User::where('store_assigned', auth()->user()->store_assigned)) // Filter by store_assigned
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Name'), // Display user name

                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('Email'), // Display user email

                TextColumn::make('branch.store_name')  // Assuming a relationship exists to fetch the store name
                    ->label('Store Assigned')          // Custom label for the column
                    ->sortable()
                    ->searchable(),

                TextColumn::make('role')
                    ->sortable()
                    ->searchable()
                    ->label('Role'), // Display the user role

                // Add additional columns as needed
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                ExportAction::make('export')
                    ->label('Export Branch Employees')

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->authorize(fn() => Auth::user()->role === 'Superadmin'), // Ensure only Superadmin can delete
                ]),
                //export only by Superadmin/Admin
                FilamentExportBulkAction::make('export')
                    ->authorize(fn() => in_array(Auth::user()->role, ['Superadmin', 'Admin']))
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

      //Who has access
      public static function canViewAny(): bool
      {
          return in_array(Auth::user()->role, ['Superadmin', 'Admin']);
      }
  
      public static function canCreate(): bool
      {
          return Auth::user()->role === 'Superadmin';
      }
  
      public static function canEdit($record): bool
      {
          return in_array(Auth::user()->role, ['Superadmin', 'Admin']);
      }
  
      public static function canDelete($record): bool
      {
          return Auth::user()->role === 'Superadmin';
      }
}
