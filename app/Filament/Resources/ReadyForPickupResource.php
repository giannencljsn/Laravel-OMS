<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReadyForPickupResource\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Mail\EmployeeNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerEmail;
use Filament\Notifications\Notification;


class ReadyForPickupResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $modelLabel = 'Ready For Pickups';

    protected static ?string $navigationParentItem = 'All Pickup Orders';

    protected static ?int $navigationSort = 2;


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
        return in_array(Auth::user()->role, ['Superadmin', 'Admin']);
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'Superadmin';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('order_id')
                    ->required()
                    ->label('Order ID')
                    ->disabled(fn() => Auth::user()->role !== 'Superadmin'),

                Select::make('status')
                    ->options([
                        'readyforpickup' => 'Ready for Pickup',
                    ])
                    ->required()
                    ->label('Status'),


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

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table

            ->query(function () {
                $user = auth()->user();

                // Define the statuses to filter
                $statuses = ['readyforpickup'];

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

            ])
            ->actions([
                EditAction::make(),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReadyForPickups::route('/'),
            'create' => Pages\CreateReadyForPickup::route('/create'),
            'edit' => Pages\EditReadyForPickup::route('/{record}/edit'),
        ];
    }
}
