<?php

use App\Models\PaymentOption;
use Illuminate\Database\Seeder;

class PaymentOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentOptions = [
            ['description' => 'Boleto', 'value'=> 'BOLETO'],
            ['description' => 'Cartão de Crédito', 'value'=> 'CREDIT_CARD'],
            ['description' => 'Pix', 'value'=> 'PIX'],
        ];

        foreach ($paymentOptions as $option) {
            PaymentOption::create($option);
        }
    }
}