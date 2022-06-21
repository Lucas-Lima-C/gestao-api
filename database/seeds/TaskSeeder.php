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
                'name' => 'Ler um livro',
                'date_of_conclusion' => '2022-07-30',
                'status' => 'Pendente'
            ],
            [
                'name' => 'Gerar backup',
                'date_of_conclusion' => '2022-08-02',
                'status' => 'Pendente'
            ],
            [
                'name' => 'Caminhada',
                'date_of_conclusion' => '2022-07-25',
                'status' => 'Concluido'
            ],
            [
                'name' => 'Academia',
                'date_of_conclusion' => '2022-09-05',
                'status' => 'Concluido'
            ],
            [
                'name' => 'Finalizar API',
                'date_of_conclusion' => '2022-07-25',
                'status' => 'Concluido'
            ],
            [
                'name' => 'Criar nova tela',
                'date_of_conclusion' => '2022-06-05',
                'status' => 'Pendente'
            ],
            [
                'name' => 'Manutenção',
                'date_of_conclusion' => '2022-06-02',
                'status' => 'Pendente'
            ],
        ];

        foreach ($rows as $row) {
            $exists = Task::where('name', $row['name'])->first();
            if ($exists) {
                $exists->update($row);
                continue;
            }
            Task::create($row);
        }
    }
}
