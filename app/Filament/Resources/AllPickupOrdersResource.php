<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllPickupOrdersResource\Pages;
use App\Filament\Resources\AllPickupOrdersResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput; // Import TextInput
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TimeColumn;
use Illuminate\Support\Facades\Auth;


use App\Mail\EmployeeNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerEmail;


use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction as FilamentExportBulkAction;

use Filament\Notifications\Notification;

class AllPickupOrdersResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'All Pickup Orders';
    
    protected static ?int $navigationSort = 1;

    //Who has access
    public static function canViewAny(): bool
    {
        return in_array(Auth::user()->role, ['Superadmin', 'Admin', 'Store_Staff']);
    }

    public static function canCreate(): bool
    {
        return Auth::user()->role === 'Superadmin';
    }

    public static function canEdit($record): bool
    {
        return in_array(Auth::user()->role, ['Superadmin', 'Admin', 'Store_Staff']);
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'Superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // IMEI
                TextInput::make('imei')
                    ->nullable()
                    ->maxLength(255)
                    ->label('IMEI')
                    ->rules(fn($get) => $get('imei') === null ? 'unique:orders,imei' : null) // Apply rule only if IMEI is empty
                    ->disabled(fn() => in_array(Auth::user()->role, ['Admin'])),

                // Order ID
                TextInput::make('order_id')
                    ->required()
                    ->maxLength(255)
                    ->label('Order ID')
                    ->rules(fn($get) => $get('order_id') === null ? 'unique:orders,order_id' : null) // Apply rule only if Order ID is empty
                    ->disabled(fn() => in_array(Auth::user()->role, ['Admin', 'Store_Staff'])),

                // Invoice ID
                TextInput::make('invoice_id')
                    ->required()
                    ->maxLength(255)
                    ->label('Invoice ID')
                    ->rules(fn($get) => $get('invoice_id') === null ? 'unique:orders,invoice_id' : null) // Apply rule only if Invoice ID is empty
                    ->disabled(fn() => in_array(Auth::user()->role, ['Admin', 'Store_Staff'])),
                // Customer Email
                TextInput::make('customer_email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Customer Email')
                    ->type('email')
                    ->disabled(fn() => in_array(Auth::user()->role, ['Store_Staff'])),

                // Customer Number
                TextInput::make('customer_number')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                    ->required()
                    ->maxLength(20)
                    ->label('Customer Contact Number')
                    ->disabled(fn() => in_array(Auth::user()->role, ['Store_Staff'])),


                // Branch ID
                Select::make('branch_id')
                    ->nullable()
                    ->label('Store Branch')
                    ->options(function () {
                        return DB::table('phoneville_branches')
                            ->pluck('store_name', 'id')
                            ->mapWithKeys(function ($value, $key) {
                                return [(int) $key => $value];
                            });
                    })
                    ->placeholder('Select a store')
                    ->searchable()
                    ->disabled(fn() => in_array(Auth::user()->role, ['Admin', 'Store_Staff'])),

                // Order Status
                //Payment
                Select::make('payment_status')->label('Payment Status')
                    ->options([
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                        'pending' => 'Pending'

                    ])
                    ->required()
                    ->default('pending')
                    ->label('Payment Status')
                    ->disabled(fn() => in_array(Auth::user()->role, ['Admin', 'Store_Staff'])),

                //Order status
                Select::make('status')
                    ->options([
                        'forpickup' => 'For Pickup',
                        'readyforpickup' => 'Ready for Pickup',
                        'fordelivery' => 'For Delivery',
                        'readyfordelivery' => 'Ready For Delivery',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('forpickup')
                    ->label('Status')
                    ->disabled(fn() => in_array(Auth::user()->role, ['Admin', 'Store_Staff'])),

                // Stock Available
                TextInput::make('stock_available')
                    ->required()
                    ->numeric()
                    ->nullable()
                    ->maxLength(1000)
                    ->label('Stock Available')
                    ->disabled(fn() => Auth::user()->role === 'Admin'),

                // Availability Section
                Section::make('Availability')
                    ->schema([
                        TextInput::make('pickup_code')
                            ->nullable()
                            ->maxLength(12)
                            ->label('Pickup Code')
                            ->disabled(fn() => in_array(Auth::user()->role, ['Admin', 'Store_Staff']))
                            ->default(fn() => static::generatePickupCode()),

                        DatePicker::make('availability_date')
                            ->nullable()
                            ->label('Available Date')
                            ->format('Y-m-d')
                            ->default(now()->format('Y-m-d'))
                            ->disabled(fn() => Auth::user()->role === 'Admin'),

                        DatePicker::make('pickup_date')
                            ->nullable()
                            ->label('Pickup Date')
                            ->format('Y-m-d')
                            ->default(now()->format('Y-m-d'))
                            ->disabled(fn() => Auth::user()->role === 'Admin'),

                        TimePicker::make('pickup_time')
                            ->seconds(false)
                            ->label('Pickup Time')
                            ->format('H:i')
                            ->default(now()->format('H:i'))
                            ->disabled(fn() => Auth::user()->role === 'Admin'),

                    ]),
            ]);
    }
    public static function sendEmailToCustomer(Order $order)
    {
        // Check if the order has a customer email and send the email
        if ($order->customer_email) {
            // Send the email using the CustomerEmail mailable
            Mail::to($order->customer_email)->send(new CustomerEmail($order));
            \Log::info("Email sent to customer: " . $order->customer_email);

            // Add a success notification
            Notification::make()
            ->title('Email sent successfully to customer email: '. $order->customer_email)
            ->icon('heroicon-o-envelope')
            ->iconColor('success')
            ->success()
            ->send();
        } else {
            \Log::warning("No customer email provided for Order ID: " . $order->id);
        }
    }


    public static function table(Table $table): Table
    {

        return $table
            ->query(function () {
                $user = auth()->user();

                // Define the statuses to filter
                $statuses = ['forpickup', 'readyforpickup', 'completed', 'cancelled'];

                // Restrict query for Store_Staff and Admin
                if (in_array($user->role, ['Store_Staff', 'Admin'])) {
                    return Order::whereIn('status', $statuses)
                        ->where('branch_id', $user->store_assigned);
                }

                // Return filtered orders for other roles
                return Order::whereIn('status', $statuses);
            })
            ->columns([
                TextColumn::make('imei')->sortable()->label('IMEI')->searchable(),
                TextColumn::make('order_id')->sortable()->label('Order ID')->searchable(),
                TextColumn::make('invoice_id')->sortable()->label('Invoice ID')->searchable(),
                TextColumn::make('pickup_code')->label('Pickup Code')->searchable(),
                // Display Store Branch (Fetching store names based on the branch_id)
                TextColumn::make('branch_id')
                    ->label('Store Branch')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        // Fetch the store name based on the branch_id
                        return DB::table('phoneville_branches')
                            ->where('id', $record->branch_id)  // Use the correct relationship field 'branch_id'
                            ->value('store_name');  // Get the store name from the store_branch table
                    }),
                TextColumn::make('payment_status')->label('Payment Status')->searchable(),
                TextColumn::make('status')->sortable()->label('Shipping Status')->searchable(),
                TextColumn::make('stock_available')->sortable()->label('Stock Available')->searchable(),
                TextColumn::make('customer_email')->sortable()->label('Customer Email')->searchable(),
                TextColumn::make('customer_number')->sortable()->label('Customer Contact No.')->searchable(),
                TextColumn::make('customer_name')->label('Customer Name')->searchable(),
                //Order details

                TextColumn::make('ordered_items')->label('Ordered Items')->searchable(),
                TextColumn::make('order_quantity')->label('Order Quantity')->searchable(),
                TextColumn::make('order_sku')->label('Order SKU')->searchable(),
                TextColumn::make('pickup_type')->label('Pickup type')->searchable(),

                //Display Available Date
                TextColumn::make('availability_date')->label('Availability_Date')->sortable()->searchable()
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->format('Y-m-d') : null),
                TextColumn::make('pickup_date')->sortable()->label('Pickup Date')->searchable()
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->format('Y-m-d') : null),
                // Display Pickup Time
                TextColumn::make('pickup_time')
                    ->searchable()
                    ->label('Pickup Time')
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('H:i'))  // Display in 24-hour format

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('sendEmail')
                    ->label('Send Email')
                    ->action(function ($record) {
                        // Make sure $record is an instance of the Order model
                        if ($record instanceof Order) {
                            self::sendEmailToCustomer($record);  // Pass the whole order, not just email data
                            session()->flash('success', 'Email sent successfully!');
                        } else {
                            session()->flash('error', 'Failed to send email. Invalid order.');
                        }
                    })
                    ->icon('heroicon-o-inbox')
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

    // Method to generate random code if it's empty
    public static function generatePickupCode(): ?string
    {
        $pickupCode = null; // Default as null

        // Only generate a code if it's empty (avoid overwriting if there's already a code)
        if (!request()->has('pickup_code')) {
            $code = bin2hex(random_bytes(6)); // Generates a 12-character alphanumeric code

            // Randomly convert some characters to uppercase
            $pickupCode = preg_replace_callback('/[a-zA-Z]/', function ($matches) {
                return rand(0, 1) ? strtoupper($matches[0]) : strtolower($matches[0]);
            }, $code);
        }

        return $pickupCode;
    }


    // Optionally, hook into the saving event
    public static function afterSave(Order $order): void
    {
        if (empty($order->pickup_code)) {
            $order->pickup_code = static::generatePickupCode(); // Generate and set pickup code if empty
            $order->save();
        }
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
            'index' => Pages\ListAllPickupOrders::route('/'),
            // 'create' => Pages\CreateAllPickupOrders::route('/create'),
            'edit' => Pages\EditAllPickupOrders::route('/{record}/edit'),
        ];
    }
}
