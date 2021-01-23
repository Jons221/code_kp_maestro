<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurnal;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('jurnals')->delete();
        $journals_data = [
            [
                'transaction_no' => 'Journal2021-1',
                'transaction_date' => '2020-10-01',
                'total_debit' => 147200000,
                'total_credit' => 147200000,
                'created_at'=>'2020-10-01 00:00:00',
            ],
        ];
        foreach ($journals_data as $data) {
            Jurnal::create($data);
        }
    }
}
