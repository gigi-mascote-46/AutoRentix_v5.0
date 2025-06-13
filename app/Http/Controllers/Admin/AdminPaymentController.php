<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Inertia\Inertia;

class AdminPaymentController extends Controller
{
    /**
     * Exibe a lista de todos os pagamentos.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Obtém todos os pagamentos do banco de dados, carregando os relacionamentos com 'reservation'
        // (usando eager loading para otimizar as queries)
        $payments = Payment::with('reservation')->get();

        // Renderiza o componente Inertia para a página de listagem de pagamentos
        return Inertia::render('AreaAdmin/Admin/Payments/Index', compact('payments'));
    }

    /**
     * Exibe os detalhes de um pagamento específico.
     *
     * @param int $id ID do pagamento
     * @return \Inertia\Response
     */
    public function show($id)
    {
        // Procura um pagamento específico pelo ID. Se não encontrar, retorna erro 404.
        // Carrega o relacionamento com 'reservation'
        $payment = Payment::with('reservation')->findOrFail($id);

        // Renderiza o componente Inertia para a página de detalhes do pagamento
        return Inertia::render('Admin/Payments/Show', compact('payment'));
    }

    /**
     * Remove um pagamento do sistema.
     *
     * @param int $id ID do pagamento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Encontra o pagamento pelo ID ou retorna 404 se não existir
        $payment = Payment::findOrFail($id);

        // Exclui o registro do pagamento do banco de dados
        $payment->delete();

        // Redireciona de volta à página anterior com uma mensagem flash de sucesso
        return back()->with('success', 'Pagamento removido com sucesso!');
    }
}

### Possíveis melhorias:

// 1. **Paginação**: No método `index`, em vez de `get()`, usar `paginate()` para evitar sobrecarga com muitos registros.

// 2. **Tratamento de exceções**: Capturar exceções no método `destroy` e retornar uma resposta adequada em caso de erro.

// 3. **Caminhos consistentes**: Revisar os caminhos dos componentes Inertia para manter um padrão.
