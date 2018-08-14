<?php

use Illuminate\Database\Seeder;

class PaymentStatus extends Seeder
{
    /**
     * gives default statuses
     *
     * @return array
     */
    public function getDefault()
    {
        return [
            ['type' => 'paid', 'description' => ''],
            ['type' => 'non_paid', 'description' => ''],
            ['type' => 'partially_paid','description' => ''],
            ['type' => 'paid_with_fee', 'description' => ''],
            ['type' => 'transfer_to_bill', 'description' => ''],

        ];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getDefaults = $this->getDefault();
        foreach ($getDefaults as $default){
            $paymentStatus = \App\PaymentStatus::firstOrCreate($default);
        }

    }
}
