<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BemLocavelSeeder extends Seeder
{
    public function run()
    {
        DB::table('bens_locaveis')->insert([
            // Toyota
            ['marca_id' => 1, 'modelo' => 'Corolla', 'registo_unico_publico' => '01-AC-01', 'cor' => 'branco', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'automática', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 50.00, 'observacao' => ''],
            ['marca_id' => 1, 'modelo' => 'Corolla', 'registo_unico_publico' => 'RS-39-SC', 'cor' => 'cinza', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 55.00, 'observacao' => ''],
            ['marca_id' => 1, 'modelo' => 'Yaris', 'registo_unico_publico' => 'MS-BA-02', 'cor' => 'vermelho', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2021, 'manutencao' => false, 'preco_diario' => 48.00, 'observacao' => ''],
            ['marca_id' => 1, 'modelo' => 'Yaris', 'registo_unico_publico' => '09-TO-PE', 'cor' => 'azul', 'numero_passageiros' => 5, 'combustivel' => 'híbrido', 'numero_portas' => 4, 'transmissao' => 'automática', 'ano' => 2021, 'manutencao' => false, 'preco_diario' => 50.00, 'observacao' => ''],
            ['marca_id' => 1, 'modelo' => 'RAV4', 'registo_unico_publico' => '07-SE-AL', 'cor' => 'preto', 'numero_passageiros' => 5, 'combustivel' => 'híbrido', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2023, 'manutencao' => false, 'preco_diario' => 65.00, 'observacao' => ''],
            ['marca_id' => 1, 'modelo' => 'RAV4', 'registo_unico_publico' => 'AD-CT-09', 'cor' => 'branco', 'numero_passageiros' => 5, 'combustivel' => 'híbrido', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2024, 'manutencao' => false, 'preco_diario' => 70.00, 'observacao' => ''],

            // Honda
            ['marca_id' => 2, 'modelo' => 'Civic', 'registo_unico_publico' => 'AB-10-RN', 'cor' => 'cinza', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 55.00, 'observacao' => ''],
            ['marca_id' => 2, 'modelo' => 'Civic', 'registo_unico_publico' => 'YG-FC-08', 'cor' => 'azul', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 60.00, 'observacao' => ''],
            ['marca_id' => 2, 'modelo' => 'Fit', 'registo_unico_publico' => 'GB-78-AH', 'cor' => 'vermelho', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 50.00, 'observacao' => ''],
            ['marca_id' => 2, 'modelo' => 'Fit', 'registo_unico_publico' => 'EH-16-PA', 'cor' => 'branco', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 54.00, 'observacao' => ''],
            ['marca_id' => 2, 'modelo' => 'HR-V', 'registo_unico_publico' => 'WS-54-RJ', 'cor' => 'preto', 'numero_passageiros' => 5, 'combustivel' => 'híbrido', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 65.00, 'observacao' => ''],
            ['marca_id' => 2, 'modelo' => 'HR-V', 'registo_unico_publico' => 'SP-24-PB', 'cor' => 'cinza', 'numero_passageiros' => 5, 'combustivel' => 'híbrido', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 70.00, 'observacao' => ''],

            // Ford
            ['marca_id' => 3, 'modelo' => 'Focus', 'registo_unico_publico' => 'JV-95-HP', 'cor' => 'branco', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 55.00, 'observacao' => ''],
            ['marca_id' => 3, 'modelo' => 'Focus', 'registo_unico_publico' => 'PM-BP-90', 'cor' => 'preto', 'numero_passageiros' => 5, 'combustivel' => 'diesel', 'numero_portas' => 4, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 59.00, 'observacao' => ''],
            ['marca_id' => 3, 'modelo' => 'Fiesta', 'registo_unico_publico' => 'PA-12-AP', 'cor' => 'vermelho', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 48.00, 'observacao' => ''],
            ['marca_id' => 3, 'modelo' => 'Fiesta', 'registo_unico_publico' => 'MT-64-MG', 'cor' => 'azul', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 52.00, 'observacao' => ''],
            ['marca_id' => 3, 'modelo' => 'EcoSport', 'registo_unico_publico' => 'AA-A1-03', 'cor' => 'preto', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 60.00, 'observacao' => ''],
            ['marca_id' => 3, 'modelo' => 'EcoSport', 'registo_unico_publico' => 'HY-10-27', 'cor' => 'branco', 'numero_passageiros' => 5, 'combustivel' => 'diesel', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 66.00, 'observacao' => ''],

            // Volkswagen
            ['marca_id' => 4, 'modelo' => 'Golf', 'registo_unico_publico' => 'DF-83-03', 'cor' => 'cinza', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 70.00, 'observacao' => ''],
            ['marca_id' => 4, 'modelo' => 'Golf', 'registo_unico_publico' => 'MA-PA-27', 'cor' => 'preto', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 75.00, 'observacao' => ''],
            ['marca_id' => 4, 'modelo' => 'Polo', 'registo_unico_publico' => 'AM-10-31', 'cor' => 'vermelho', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 58.00, 'observacao' => ''],
            ['marca_id' => 4, 'modelo' => 'Polo', 'registo_unico_publico' => 'CE-93-RO', 'cor' => 'cinza', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 62.00, 'observacao' => ''],
            ['marca_id' => 4, 'modelo' => 'Tiguan', 'registo_unico_publico' => 'AC-RM-33', 'cor' => 'azul', 'numero_passageiros' => 5, 'combustivel' => 'diesel', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 80.00, 'observacao' => ''],
            ['marca_id' => 4, 'modelo' => 'Tiguan', 'registo_unico_publico' => '12-PM-36', 'cor' => 'preto', 'numero_passageiros' => 5, 'combustivel' => 'diesel', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 85.00, 'observacao' => ''],

            // Renault
            ['marca_id' => 5, 'modelo' => 'Clio', 'registo_unico_publico' => 'AC-MS-90', 'cor' => 'branco', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 45.00, 'observacao' => ''],
            ['marca_id' => 5, 'modelo' => 'Clio', 'registo_unico_publico' => 'PR-59-23', 'cor' => 'azul', 'numero_passageiros' => 5, 'combustivel' => 'gasolina', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2021, 'manutencao' => false, 'preco_diario' => 47.00, 'observacao' => ''],
            ['marca_id' => 5, 'modelo' => 'Captur', 'registo_unico_publico' => '21-ES-34', 'cor' => 'preto', 'numero_passageiros' => 5, 'combustivel' => 'híbrido', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 60.00, 'observacao' => ''],
            ['marca_id' => 5, 'modelo' => 'Captur', 'registo_unico_publico' => 'BA-93-57', 'cor' => 'vermelho', 'numero_passageiros' => 5, 'combustivel' => 'híbrido', 'numero_portas' => 5, 'transmissao' => 'automática', 'ano' => 2021, 'manutencao' => false, 'preco_diario' => 63.00, 'observacao' => ''],
            ['marca_id' => 5, 'modelo' => 'Megane', 'registo_unico_publico' => 'GO-AL-68', 'cor' => 'cinza', 'numero_passageiros' => 5, 'combustivel' => 'diesel', 'numero_portas' => 4, 'transmissao' => 'manual', 'ano' => 2020, 'manutencao' => false, 'preco_diario' => 68.00, 'observacao' => ''],
            ['marca_id' => 5, 'modelo' => 'Megane', 'registo_unico_publico' => '29-SE-97', 'cor' => 'azul', 'numero_passageiros' => 5, 'combustivel' => 'diesel', 'numero_portas' => 4, 'transmissao' => 'automática', 'ano' => 2022, 'manutencao' => false, 'preco_diario' => 73.00, 'observacao' => ''],
        ]);
    }
}
