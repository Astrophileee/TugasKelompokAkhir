<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Membuat Role
        Role::create(['name' => 'owner', 'guard_name' => 'web']);
        Role::create(['name' => 'manager', 'guard_name' => 'web']);
        Role::create(['name' => 'supervisor', 'guard_name' => 'web']);
        Role::create(['name' => 'cashier', 'guard_name' => 'web']);
        Role::create(['name' => 'stocker', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Membuat Cabang
        $branch = Branch::create([
            'name' => 'Cabang Pusat',
            'location' => 'Jl. Merdeka No.1'
        ]);

        // Membuat Users
        $owner = User::create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'password' => bcrypt('password')
        ]);
        $owner->assignRole('owner');

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('admin');

        $users = [];

        foreach ([
            ['name' => 'Manager User', 'email' => 'manager@example.com', 'role' => 'manager'],
            ['name' => 'Supervisor User', 'email' => 'supervisor@example.com', 'role' => 'supervisor'],
            ['name' => 'Cashier User', 'email' => 'cashier@example.com', 'role' => 'cashier'],
            ['name' => 'Stocker User', 'email' => 'stocker@example.com', 'role' => 'stocker'],
        ] as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => bcrypt('password'),
                'branch_id' => $branch->id
            ]);
            $user->assignRole($userData['role']);
            $users[] = $user; // Menyimpan objek User yang sudah dibuat
        }

        // Membuat Produk
        $products = Product::factory(10)->create(['branch_id' => $branch->id]);

        // Membuat Transaksi dan Detail Transaksi
        $transaction = Transaction::create([
            'transaction_number' => 'TRX12345',
            'branch_id' => $branch->id,
            'user_id' => $users[0]->id,  // Menggunakan objek User, bukan array biasa
            'total_price' => 100000,
            'date' => now()
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $products->first()->id,
            'qty' => 2,
            'unit_price' => 50000
        ]);
    }
}
