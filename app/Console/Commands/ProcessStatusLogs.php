<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusChangeNotification;

class ProcessStatusLogs extends Command
{
    protected $signature = 'process:status-logs';
    protected $description = 'Process status logs and send email notifications';

    public function handle()
    {
        // Fetch unprocessed logs
        $logs = DB::table('status_logs')->where('processed', 0)->get();

        foreach ($logs as $log) {
            // Retrieve the customer's email from the orders table using IMEI
            $customerEmail = DB::table('orders')
                ->where('imei', $log->imei)
                ->value('customer_email');

            if ($customerEmail) {
                try {
                    // Send the email
                    Mail::to($customerEmail)->send(new StatusChangeNotification($log));

                    // Mark the log as processed
                    DB::table('status_logs')
                        ->where('id', $log->id)
                        ->update(['processed' => 1]);

                    $this->info('Email sent to ' . $customerEmail . ' for IMEI: ' . $log->imei);
                } catch (\Exception $e) {
                    $this->error('Failed to send email to ' . $customerEmail . ': ' . $e->getMessage());
                }
            } else {
                $this->warn('No customer email found for IMEI: ' . $log->imei);
            }
        }

        $this->info('Processed ' . count($logs) . ' status logs.');
    }
}
