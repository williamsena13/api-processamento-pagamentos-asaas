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
            ['description' => 'Boleto'],
            ['description' => 'Cartão'],
            ['description' => 'Pix'],
        ];

        foreach ($paymentOptions as $option) {
            PaymentOption::create($option);
        }
    }
}