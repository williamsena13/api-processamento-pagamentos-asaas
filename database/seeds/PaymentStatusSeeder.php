<?php

use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentStatuses = [
            ['description' => 'Pendente'],
            ['description' => 'Concluído'],
            ['description' => 'Cancelado'],
            // Outros status de pagamento que você desejar adicionar
        ];

        foreach ($paymentStatuses as $status) {
            PaymentStatus::create($status);
        }
    }
}