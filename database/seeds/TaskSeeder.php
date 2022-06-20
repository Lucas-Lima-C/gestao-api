<?php

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
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
                'title' => 'Ler um livro',
                'date_of_conclusion' => '2022-07-30',
                'status' => 'Pendente'
            ],
            [
                'title' => 'Gerar backup',
                'date_of_conclusion' => '2022-08-02',
                'status' => 'Pendente'
            ],
            [
                'title' => 'Caminhada',
                'date_of_conclusion' => '2022-07-25',
                'status' => 'Concluido'
            ],
            [
                'title' => 'Academia',
                'date_of_conclusion' => '2022-09-05',
                'status' => 'Concluido'
            ],
            [
                'title' => 'Finalizar API',
                'date_of_conclusion' => '2022-07-25',
                'status' => 'Concluido'
            ],
            [
                'title' => 'Criar nova tela',
                'date_of_conclusion' => '2022-06-05',
                'status' => 'Pendente'
            ],
            [
                'title' => 'Manutenção',
                'date_of_conclusion' => '2022-06-02',
                'status' => 'Pendente'
            ],
        ];

        foreach ($rows as $row) {
            $exists = Task::where('title', $row['title'])->first();
            if ($exists) {
                $exists->update($row);
                continue;
            }
            Task::create($row);
        }
    }
}
