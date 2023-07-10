<?php

use App\Models\TransactionStatus;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactionStatuses = [
            ['description' => 'Pendente'],
            ['description' => 'Aprovado'],
            ['description' => 'Rejeitado'],
            // Outros status de transação que você desejar adicionar
        ];

        foreach ($transactionStatuses as $status) {
            TransactionStatus::create($status);
        }
    }
}