<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForPickupResource\Pages;
use App\Filament\Resources\ForPickupResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Filament\Notifications\Notification;

use App\Mail\EmployeeNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerEmail;

class ForPickupResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'For Pickup';

    protected static ?string $navigationParentItem = 'All Pickup Orders';

    protected static ?int $navigationSort = 1;


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
                        'forpickup' => 'For Pickup',
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

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $user = auth()->user();

                // Define the statuses to filter
                $statuses = ['forpickup'];

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
            'index' => Pages\ListForPickups::route('/'),
            'create' => Pages\CreateForPickup::route('/create'),
            'edit' => Pages\EditForPickup::route('/{record}/edit'),
        ];
    }
}
