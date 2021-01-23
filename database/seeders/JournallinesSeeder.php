<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JurnalDetail;

class JournallinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('jurnal_lines')->delete();
        $journal_lines_data = [
            [
                'jurnal_id' => '1',
                'akun_id' => '3',
                'debit' => '13800000',
                'credit' => '0',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '4',
                'debit' => '8000000',
                'credit' => '0',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '7',
                'debit' => '400000',
                'credit' => '0',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '12',
                'debit' => '120000000',
                'credit' => '0',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '13',
                'debit' => '0',
                'credit' => '6400000',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '10',
                'debit' => '5000000',
                'credit' => '0',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '41',
                'debit' => '0',
                'credit' => '350000',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '21',
                'debit' => '0',
                'credit' => '3500000',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '27',
                'debit' => '100000000',
                'credit' => '0',
                'description' => 'Opening balance',
            ],
            [
                'jurnal_id' => '1',
                'akun_id' => '57',
                'debit' => '36950000',
                'credit' => '0',
                'description' => 'Opening balance',
            ],
        ];
        foreach ($journal_lines_data as $journal_line) {
            JurnalDetail::create($journal_line);
        }
    }
}
