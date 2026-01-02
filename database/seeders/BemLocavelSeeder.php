<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BemLocavelSeeder extends Seeder
{
    public function run()
    {
        $bens = [
            // Toyota
            ['nome' => 'Corolla', 'descricao' => 'Carro económico e confiável', 'registo_unico_publico' => '01-AC-01', 'preco_por_dia' => 50.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Corolla', 'ano' => 2020, 'matricula' => 'AA-00-AA', 'combustivel' => 'gasolina', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Corolla', 'descricao' => 'Versão atualizada com tecnologia', 'registo_unico_publico' => 'RS-39-SC', 'preco_por_dia' => 55.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Corolla', 'ano' => 2022, 'matricula' => 'BB-11-BB', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Yaris', 'descricao' => 'Compacto ideal para cidade', 'registo_unico_publico' => 'MS-BA-02', 'preco_por_dia' => 48.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Yaris', 'ano' => 2021, 'matricula' => 'CC-22-CC', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Yaris', 'descricao' => 'Versão híbrida eco-friendly', 'registo_unico_publico' => '09-TO-PE', 'preco_por_dia' => 50.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'Yaris', 'ano' => 2021, 'matricula' => 'DD-33-DD', 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'RAV4', 'descricao' => 'SUV familiar espaçoso', 'registo_unico_publico' => '07-SE-AL', 'preco_por_dia' => 65.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'RAV4', 'ano' => 2023, 'matricula' => 'EE-44-EE', 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],
            ['nome' => 'RAV4', 'descricao' => 'SUV premium com todos extras', 'registo_unico_publico' => 'AD-CT-09', 'preco_por_dia' => 70.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 1, 'modelo' => 'RAV4', 'ano' => 2024, 'matricula' => 'FF-55-FF', 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],

            // Honda
            ['nome' => 'Civic', 'descricao' => 'Sedan desportivo', 'registo_unico_publico' => 'AB-10-RN', 'preco_por_dia' => 55.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 2, 'modelo' => 'Civic', 'ano' => 2020, 'matricula' => 'GG-66-GG', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Civic', 'descricao' => 'Versão automática de luxo', 'registo_unico_publico' => 'YG-FC-08', 'preco_por_dia' => 60.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 2, 'modelo' => 'Civic', 'ano' => 2022, 'matricula' => 'HH-77-HH', 'combustivel' => 'gasolina', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Fit', 'descricao' => 'Compacto versátil', 'registo_unico_publico' => 'GB-78-AH', 'preco_por_dia' => 50.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 2, 'modelo' => 'Fit', 'ano' => 2020, 'matricula' => 'II-88-II', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Fit', 'descricao' => 'Modelo atualizado', 'registo_unico_publico' => 'EH-16-PA', 'preco_por_dia' => 54.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 2, 'modelo' => 'Fit', 'ano' => 2022, 'matricula' => 'JJ-99-JJ', 'combustivel' => 'gasolina', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'HR-V', 'descricao' => 'Crossover compacto', 'registo_unico_publico' => 'WS-54-RJ', 'preco_por_dia' => 65.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 2, 'modelo' => 'HR-V', 'ano' => 2020, 'matricula' => 'KK-00-KK', 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],
            ['nome' => 'HR-V', 'descricao' => 'Crossover topo de gama', 'registo_unico_publico' => 'SP-24-PB', 'preco_por_dia' => 70.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 2, 'modelo' => 'HR-V', 'ano' => 2022, 'matricula' => 'LL-11-LL', 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],

            // Ford
            ['nome' => 'Focus', 'descricao' => 'Carro familiar económico', 'registo_unico_publico' => 'JV-95-HP', 'preco_por_dia' => 55.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 3, 'modelo' => 'Focus', 'ano' => 2020, 'matricula' => 'MM-22-MM', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Focus', 'descricao' => 'Versão diesel automática', 'registo_unico_publico' => 'PM-BP-90', 'preco_por_dia' => 59.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 3, 'modelo' => 'Focus', 'ano' => 2022, 'matricula' => 'NN-33-NN', 'combustivel' => 'diesel', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Fiesta', 'descricao' => 'Compacto urbano', 'registo_unico_publico' => 'PA-12-AP', 'preco_por_dia' => 48.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 3, 'modelo' => 'Fiesta', 'ano' => 2020, 'matricula' => 'OO-44-OO', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Fiesta', 'descricao' => 'Modelo desportivo', 'registo_unico_publico' => 'MT-64-MG', 'preco_por_dia' => 52.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 3, 'modelo' => 'Fiesta', 'ano' => 2022, 'matricula' => 'PP-55-PP', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'EcoSport', 'descricao' => 'SUV compacto', 'registo_unico_publico' => 'AA-A1-03', 'preco_por_dia' => 60.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 3, 'modelo' => 'EcoSport', 'ano' => 2020, 'matricula' => 'QQ-66-QQ', 'combustivel' => 'gasolina', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],
            ['nome' => 'EcoSport', 'descricao' => 'SUV com motor diesel', 'registo_unico_publico' => 'HY-10-27', 'preco_por_dia' => 66.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 3, 'modelo' => 'EcoSport', 'ano' => 2022, 'matricula' => 'RR-77-RR', 'combustivel' => 'diesel', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],

            // Volkswagen
            ['nome' => 'Golf', 'descricao' => 'Icono alemão', 'registo_unico_publico' => 'DF-83-03', 'preco_por_dia' => 70.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 4, 'modelo' => 'Golf', 'ano' => 2020, 'matricula' => 'SS-88-SS', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Golf', 'descricao' => 'Versão GTI', 'registo_unico_publico' => 'MA-PA-27', 'preco_por_dia' => 75.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 4, 'modelo' => 'Golf', 'ano' => 2022, 'matricula' => 'TT-99-TT', 'combustivel' => 'gasolina', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Polo', 'descricao' => 'Compacto eficiente', 'registo_unico_publico' => 'AM-10-31', 'preco_por_dia' => 58.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 4, 'modelo' => 'Polo', 'ano' => 2020, 'matricula' => 'UU-00-UU', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Polo', 'descricao' => 'Modelo atualizado', 'registo_unico_publico' => 'CE-93-RO', 'preco_por_dia' => 62.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 4, 'modelo' => 'Polo', 'ano' => 2022, 'matricula' => 'VV-11-VV', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Tiguan', 'descricao' => 'SUV familiar', 'registo_unico_publico' => 'AC-RM-33', 'preco_por_dia' => 80.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 4, 'modelo' => 'Tiguan', 'ano' => 2020, 'matricula' => 'WW-22-WW', 'combustivel' => 'diesel', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],
            ['nome' => 'Tiguan', 'descricao' => 'SUV premium', 'registo_unico_publico' => '12-PM-36', 'preco_por_dia' => 85.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 4, 'modelo' => 'Tiguan', 'ano' => 2022, 'matricula' => 'XX-33-XX', 'combustivel' => 'diesel', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],

            // Renault
            ['nome' => 'Clio', 'descricao' => 'Compacto francês', 'registo_unico_publico' => 'AC-MS-90', 'preco_por_dia' => 45.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 5, 'modelo' => 'Clio', 'ano' => 2020, 'matricula' => 'YY-44-YY', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Clio', 'descricao' => 'Modelo hibrido', 'registo_unico_publico' => 'PR-59-23', 'preco_por_dia' => 47.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 5, 'modelo' => 'Clio', 'ano' => 2021, 'matricula' => 'ZZ-55-ZZ', 'combustivel' => 'gasolina', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Captur', 'descricao' => 'Crossover estilo francês', 'registo_unico_publico' => '21-ES-34', 'preco_por_dia' => 60.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 5, 'modelo' => 'Captur', 'ano' => 2020, 'matricula' => 'A1-66-B2', 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],
            ['nome' => 'Captur', 'descricao' => 'Crossover topo de linha', 'registo_unico_publico' => 'BA-93-57', 'preco_por_dia' => 63.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 5, 'modelo' => 'Captur', 'ano' => 2021, 'matricula' => 'C3-77-D4', 'combustivel' => 'híbrido', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 5],
            ['nome' => 'Megane', 'descricao' => 'Sedan elegante', 'registo_unico_publico' => 'GO-AL-68', 'preco_por_dia' => 68.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 5, 'modelo' => 'Megane', 'ano' => 2020, 'matricula' => 'E5-88-F6', 'combustivel' => 'diesel', 'transmissao' => 'manual', 'lugares' => 5, 'portas' => 4],
            ['nome' => 'Megane', 'descricao' => 'Sedan automático', 'registo_unico_publico' => '29-SE-97', 'preco_por_dia' => 73.00, 'disponivel' => true, 'tipo_bem_id' => 1, 'marca_id' => 5, 'modelo' => 'Megane', 'ano' => 2022, 'matricula' => 'G7-99-H8', 'combustivel' => 'diesel', 'transmissao' => 'automática', 'lugares' => 5, 'portas' => 4],
        ];

        foreach ($bens as $bem) {
            DB::table('bens_locaveis')->updateOrInsert(
                ['registo_unico_publico' => $bem['registo_unico_publico']],
                $bem
            );
        }
    }
}
