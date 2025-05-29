# Query - Consulta
É uma solicitação de dados para o Banco de Dados. 

Exemplo: 
```php
$disponiveis = DB::table('bens_locaveis')
    ->where('numero_hospedes', '>=', $hospedes)  // Filtro da query
    ->orderBy('numero_hospedes', 'asc')  // Ordena os resultados
    ->get();  // Executa a consulta e retorna os dados disponíveis
```

Exemplo: 
```php
 public function all_avalible($dataInicio, $dataFim, $hospedes)
    {
        if (!$dataInicio || !$dataFim || !$hospedes) {
            $disponiveis = DB::table('bens_locaveis')->get();
        } else {
            $disponiveis = DB::table('bens_locaveis')
                ->leftJoin('reservas', function ($join) use ($dataInicio, $dataFim) {
                    $join->on('reservas.bem_locavel_id', '=', 'bens_locaveis.id')
                        ->where('reservas.status', 'reservado')
                        ->where(function ($q) use ($dataInicio, $dataFim) {
                            $q->where('reservas.data_inicio', '<=', $dataFim)
                            ->where('reservas.data_fim', '>=', $dataInicio);
                        });
                })
                ->whereNull('reservas.id') // Apenas registos sem reservas no período
                ->where('bens_locaveis.numero_hospedes', '>=', $hospedes)
                ->orderBy('bens_locaveis.numero_hospedes', 'asc')
                ->get();
        }
    return $disponiveis;
    }
``` 
➤ Quando fazemos um LEFT JOIN (retornamos todos os registos da tabela da esquerda e os da direita que satisfazem a condição de junção) ou um RIGHT JOIN, os dados das duas tabelas são combinados em uma única linha de resultado. 
Se ambas as tabelas tiverem colunas com o mesmo nome, como `id`, `created_at`, pode haver conflito de nomes; o que pode causar problemas tanto no backend (como sobreposição de dados no array retornado), quanto no frontend — que pode exibir dados errados ou até deixar de exibir. ➤ Uma forma de resolver o problema é usando `alias` para as colunas, como `bens_locaveis.id AS bens_locaveis_id`.


# Subquery - Subconsulta
É uma consulta dentro de outra consulta, usada para fazer verificações adicionais.
Em vez de buscar diretamente os dados na tabela principal, a subquery realiza uma consulta em uma tabela diferente ou faz uma verificação adicional sobre os dados para filtrar ainda mais os resultados.

Vamos analisar o exemplo a seguir:
```sql
DELIMITER $$
CREATE PROCEDURE BuscarImoveisDisponiveis (
    IN param_hospedes INT,
    IN param_dataInicio DATE,
    IN param_dataFim DATE
)
BEGIN
    -- select retorna dados
    SELECT *
    FROM bens_locaveis
    WHERE numero_hospedes >= param_hospedes
    -- "Existe algum registro na tabela reservas que atende a essas condições?"
    -- Se sim, o NOT EXISTS bloqueia o imóvel.
    -- Se não, o imóvel é considerado disponível.   
    -- not exists não retorna dados, mas verifica condição
      AND NOT EXISTS (
        SELECT 1
        FROM reservas
        WHERE reservas.bem_locavel_id = bens_locaveis.id
          AND status = 'reservado'
          AND (
            data_inicio <= param_dataFim
            AND data_fim >= param_dataInicio
          )
      )
    ORDER BY numero_hospedes ASC;
END$$
DELIMITER ;
```

Equivale a:

```php
 public function all_avalible($dataInicio, $dataFim, $hospedes)
    {
        // Se não houver filtros de data ou número de hóspedes, retorna todos os imóveis
        if (!$dataInicio || !$dataFim || !$hospedes) {
            $disponiveis = DB::table('bens_locaveis')->get();

        } else {

        // Inicia uma consulta na tabela
            $disponiveis = DB::table('bens_locaveis')
            // Filtro de imóveis com número de hóspedes suficiente: Verifica se o imóvel pode acomodar o número de hóspedes
                ->where('numero_hospedes', '>=', $hospedes)
                // Adiciona uma subquery com whereNotExists para garantir que o imóvel não esteja reservado no período desejado.
                // verifica se existe uma reserva no intervalo de datas – se existir, o imóvel será excluído do resultado.
                ->whereNotExists(function ($query) use ($dataInicio, $dataFim) {
                    //“sim, existe algo aqui”.
                    $query->select(DB::raw(1))
                        ->from('reservas')
                        ->whereColumn('reservas.bem_locavel_id', 'bens_locaveis.id')
                        ->where('status', 'reservado') // Verifica se a reserva está com o status 'reservado', caso lide com "cancelado"
                        
                        // Cláusula where aninhada, ou seja, um bloco de condições agrupadas.
                        // Consulta a tabela reservas, onde estão registadas todas as reservas feitas nos imóveis.
                        ->where(function ($q) use ($dataInicio, $dataFim) {
                            // Verifica a sobreposição das datas
                            $q->where('data_inicio', '<=', $dataFim)
                              ->where('data_fim', '>=', $dataInicio);
                        });
                })
                ->orderBy('numero_hospedes', 'asc')
                ->get();   
        }
        return $disponiveis;
    }
```
No código, temos uma subquery dentro do método `whereNotExists`; usada para verificar se um imóvel já está reservado no período entre `dataInicio` e `dataFim`. Ou seja, a subquery realiza a consulta na tabela reservas para garantir que o imóvel não esteja reservado nesse intervalo de datas.

## Resumo dos métodos mais comuns para subqueries no Laravel:
Existência de Resultados
1. whereExists: verifica se a subconsulta retorna resultados (se uma condição existe ou não).
2. whereNotExists: verifica se a subconsulta não retorna resultados.

Seleção de Subconsultas
3. selectSub: adiciona uma subconsulta diretamente na cláusula SELECT.
4. addSelect: adiciona uma subconsulta ao conjunto de colunas já selecionadas.

Filtragem de Registros
5. whereIn: filtra registos usando os resultados de uma subconsulta.
6. whereNotIn: filtra registos excluindo valores correspondam aos resultados de uma subconsulta.
7. whereColumn: compara valores de colunas sem necessidade de uma subconsulta complexa.

Combinação de Resultados
8. union: combina os resultados de duas ou mais consultas e remove registros duplicados do conjunto final (semelhante a um SELECT DISTINCT)
9. unionAll: combina os resultados de várias subconsultas e mantém registros duplicados no conjunto final.