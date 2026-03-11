<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@shreeji.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'ADMIN',
            'phone' => '9999999999',
        ]);

        // 2. Create Partner
        $partner = \App\Models\User::create([
            'name' => 'Rajesh Partner',
            'email' => 'partner@shreeji.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'PARTNER',
            'phone' => '8888888888',
        ]);

        // 3. Create Employee
        $employee = \App\Models\User::create([
            'name' => 'Suresh Employee',
            'email' => 'employee@shreeji.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'EMPLOYEE',
            'phone' => '7777777777',
        ]);

        // 4. Create Customer
        $customer = \App\Models\User::create([
            'name' => 'Amit Customer',
            'email' => 'customer@shreeji.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'CUSTOMER',
            'phone' => '6666666666',
        ]);

        // 5. Create Loans for Customer
        \App\Models\Loan::create([
            'user_id' => $customer->id,
            'loan_type' => 'EXPRESS CASH',
            'loan_amount' => 50000,
            'status' => 'PENDING',
            'customer_name' => 'Amit Customer',
        ]);

        // 6. Create Leads for Partner
        \App\Models\Lead::create([
            'user_id' => $partner->id,
            'customer_name' => 'New Lead 1',
            'mobile_number' => '1234567890',
            'loan_amount' => 100000,
            'status' => 'OPEN',
        ]);

        // 7. Create Tasks for Employee
        \App\Models\Task::create([
            'user_id' => $employee->id,
            'title' => 'Verify Amit KYC',
            'description' => 'Verify Aadhaar and PAN for Amit Customer',
            'due_date' => now()->addDays(2),
            'status' => 'PENDING',
        ]);

        // 8. Wallet Transactions for Partner (Commission)
        \App\Models\WalletTransaction::create([
            'user_id' => $partner->id,
            'amount' => 142850,
            'type' => 'CREDIT',
            'description' => 'Monthly Commission Payout',
        ]);

        // 9. App Settings
        \App\Models\AppSetting::create([
            'key' => 'home_screen_config',
            'value' => json_encode([
                'banner_text' => 'Shreeji Finance - Your Trusted Partner',
                'show_express_cash' => true,
                'show_flexiloan' => true,
                'announcement' => 'New interest rates available now!'
            ]),
        ]);
    }
}
