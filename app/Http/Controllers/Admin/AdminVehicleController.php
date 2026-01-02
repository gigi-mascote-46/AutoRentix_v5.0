<?php

namespace App\Http\Controllers\Admin;

// Importações necessárias
use App\Http\Controllers\Controller;  // Controller base
use App\Models\BemLocavel;            // Modelo de bens locáveis (veículos)
use App\Models\Marca;                 // Modelo de marcas de veículos
use Illuminate\Http\Request;          // Classe de requisição HTTP
use Inertia\Inertia;                  // Integração com Inertia.js
use App\Http\Requests\StoreBemLocavelRequest;  // Form Request customizado para validação
use Illuminate\Support\Facades\Storage;  // Facade para manipulação de arquivos

class AdminVehicleController extends Controller
{
    /**
     * Exibe a listagem de veículos
     *
     * Método: GET
     * Rota: /admin/vehicles (normalmente)
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Obtém todos os veículos com seus relacionamentos de marca
        $bens = BemLocavel::with('marca')
            ->get()
            ->map(function ($bem) {
                // Formata os dados para a view
                return [
                    'id' => $bem->id,
                    'marca' => $bem->marca ? $bem->marca->only('nome') : null,  // Apenas o nome da marca
                    'modelo' => $bem->modelo,
                    'cor' => $bem->cor,
                    'preco_diario' => (float) $bem->preco_diario,  // Converte para float
                    // Outros campos podem ser adicionados conforme necessário
                ];
            });

        // Renderiza a view de listagem com os veículos formatados
        return Inertia::render('AreaAdmin/Admin/Vehicles/Index', [
            'bens' => $bens,
        ]);
    }

    /**
     * Mostra o formulário de criação de veículo
     *
     * Método: GET
     * Rota: /admin/vehicles/create
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Obtém todas as marcas para preencher o seletor no formulário
        $marcas = Marca::all();
        // Renderiza o formulário de criação com as marcas
        return Inertia::render('AreaAdmin/Admin/Vehicles/Create', compact('marcas'));
    }

    /**
     * Armazena um novo veículo no banco de dados
     *
     * Método: POST
     * Rota: /admin/vehicles
     *
     * @param StoreBemLocavelRequest $request - Request com dados validados
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBemLocavelRequest $request)
    {
        // Cria um novo registro usando dados validados
        BemLocavel::create($request->validated());

        // Redireciona com mensagem de sucesso
        return redirect()->route('admin.vehicles.index')->with('success', 'Viatura criada com sucesso!');
    }

    /**
     * Mostra o formulário de edição de veículo
     *
     * Método: GET
     * Rota: /admin/vehicles/{id}/edit
     *
     * @param int $id ID do veículo
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        // Procura o veículo com relacionamentos: marca e fotos
        $bem = BemLocavel::with('marca', 'photos')->findOrFail($id);
        // Obtém todas as marcas para o seletor
        $marcas = Marca::all();
        // Renderiza o formulário de edição com dados do veículo e marcas
        return Inertia::render('AreaAdmin/Admin/Vehicles/Edit', compact('bem', 'marcas'));
    }

    /**
     * Atualiza um veículo existente
     *
     * Método: PUT/PATCH
     * Rota: /admin/vehicles/{id}
     *
     * @param StoreBemLocavelRequest $request - Request com dados validados
     * @param int $id ID do veículo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreBemLocavelRequest $request, $id)
    {
        // Procura o veículo existente
        $bem = BemLocavel::findOrFail($id);
        // Atualiza os dados básicos do veículo
        $bem->update($request->validated());

        // Processa upload de novas fotos
        if ($request->hasFile('photos') && is_array($request->file('photos'))) {
            foreach ($request->file('photos') as $photo) {
                // Armazena cada foto no diretório 'public/vehicles'
                $path = $photo->store('vehicles', 'public');
                // Cria registro da foto associada ao veículo
                $bem->photos()->create(['photo_path' => $path]);
            }
        }

        // Redireciona com mensagem de sucesso
        return redirect()->route('admin.vehicles.index')->with('success', 'Viatura atualizada com sucesso!');
    }
}

// ### Observações:

// - **Falta do método `destroy`**: Este controlador não possui um método para excluir veículos. Se necessário, deve ser implementado.

// - **Fotos no `store`**: O método `store` não lida com o upload de fotos. Se for necessário adicionar fotos no momento da criação, não esquecer de incluir a mesma lógica de upload do método `update`.

// - **Eficiência**: No método `index`, o uso de `map` após o `get` pode ser ineficiente para muitos registros. Considerar futuramente usar paginação e otimizar as consultas.

// - **Caminhos dos componentes**: Pode haver alguma inconsistência dos caminhos dos componentes Inertia (ex: `AreaAdmin/Admin/Vehicles/...`). 

// Este controlador segue as práticas comuns do Laravel e Inertia, com uma estrutura clara para gerenciar veículos (bens locáveis).
