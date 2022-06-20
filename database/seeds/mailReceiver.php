<?php

use App\Models\User;
use App\Models\MailReceiver;
use Illuminate\Database\Seeder;


class MailReceiverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'user_id' => User::first()->value('id'),
            ]
        ];

        foreach ($rows as $row) {
            MailReceiver::create($row);
        }
    }
}
