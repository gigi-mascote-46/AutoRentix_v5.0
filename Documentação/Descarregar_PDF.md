# Fazer Download 
Vamos gerar um conteúdo e permitir o download como um arquivo `.txt`. Em seguida, vamos gerar um `.pdf`.

## Objetivo
Criar uma rota que, ao ser acessada, gera um arquivo e inicia o download para o utilizador.

Para isto, precisamos implementar 
(1) uma função no controlador que construirá o arquivo e iniciará a descarga, 
(2) uma rota correspondente, e 
(3) um botão para chamar essa rota. 

### No controlador, implementamos a função de callback que será chamada para construir o arquivo e fazer a descarga.
Esta função precisa de 3 

Nesta função, precisamos realizar 3 operações:
1. Criar o `filename`: utilizamos a função `env()` para pegar o nome da aplicação e a função `date()` para incluir a data no nome do arquivo.
```php
$filename = 'nome'. env('APP_NAME') . '-'. date('Ymd') . 'txt'; 
```

2. Gerar o conteúdo com string. 
```php
$content = "Teste simples de conteúdo para download.\nLinha 2 do arquivo.";

//OU
$content = "Dados do Objeto:\n";
$content .= "ID: {$objeto->id}\n";
    // neste caso, já sabemos que objeto tem um relacionamento com User expressa nos modelos, então:
$content .= "Utilizador: {$objeto->user->name}\n"; 
$content .= "Email: {$objeto->user->email}\n";
    //continuando...
$content .= "Atributo do objeto: {$objeto->atributo_um}\n";
$content .= "Outro atributo do objeto: {$objeto->atributo_dois}\n";
```
Isso gera o conteúdo (uma string manipulável) que será exibida no arquivo de texto.

⚠️ Por hora, não é possível utilizar a função `View::make()` diretamente para renderizar uma view como string, pois isso pode gerar o erro `Object of class stdClass could not be converted to string`.

3. Retornar o conteúdo como um arquivo para download: utilizamos a função `response()` para construir a resposta `HTTP` e adicionamos os headers corretos para forçar o download do arquivo.
```php
return response($content)
    ->header('Content-Type', 'text/plain')
    ->header('Content-Disposition', 'attachement; filename="' . $filename'"');
```

Em resumo, teremos algo como: 
```php
public function criar_baixar_arquivo_txt(){
    
    $filename = 'objeto-' . env('APP_NAME') . '-' . date('Ymd') . '.txt';

    $content = "Dados do objeto:\n";
        $content .= "ID: {$objeto->id}\n";
        $content .= "Usuário: {$objeto->user->name}\n";
        $content .= "Email: {$objeto->user->email}\n";
        $content .= "Data de Início: {$objeto->data_inicio}\n";
        $content .= "Data de Fim: {$objeto->data_fim}\n";
    
    return response($content)
        ->header('Content-Type', 'text/plain')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
}
```

### No `web.php`
```php
Route::get('/print', [Controller::class, 'criar_baixar_arquivo_txt'])>name('print');
```

### Na view, adicionamos um botão ou um link para iniciar o download
```html
<a href="{{ route('print') }}" class="btn btn-outline-primary">
    Download (.txt)
</a>
```

## PDF
### Instalar o pacote
```bash
composer require barryvdh/laravel-dompdf
```
Este pacote disponibiliza a classe `Pdf`, que permite gerar um PDF a partir de uma view, com o método `loadView`.

### No Controller
Adaptamos a função do controlador para (veja o exemplo link abaixo).
```php
use Barryvdh\DomPDF\Facade\Pdf;

public function downloadArquivo()
{
    if (!session()->has('id')) {
            return redirect()->route('dashboard');
        }
    $objeto_id = session('id');
    
    //Verifica se $reservaId contém um objeto. 
    //Se for um objeto, ela acessa sua propriedade id; caso contrário, mantém $reservaId como está.
    //Ou seja, se $objeto_id foi gravado em um array ou não (Veja o comentário no final deste .md)
    $objeto_id = is_object($objeto_id) ? $objeto_id->id : $objeto_id;

    //busca do objeto pelo id
    $objeto = $this->reserva->getObjeto($objeto_id);
    
    if (!$objeto) {
        return redirect()->route('dashboard')->with('error', 'Objeto não encontrado.');
    }
        
    $pdf = Pdf::loadView('pdf.print', compact('objeto'));

    return $pdf->download('objeto-' . env('APP_NAME') . '-' . date('Ymd') . '.pdf');
}
```

### Manter a rota

### Criar uma view
A view deve estar como na referência `pdf.print` (ou seja, pasta pdf, arquivo print.blade.php).
Nesta view, personalizamos o pdf. 

Veja o exemplo da funcao no controlador e a view correspondente
[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Download/print.blade.php)

[🔗 Abrir Exemplo](file:///C:/Users/CESAE/Desktop/Download/Controller)


### Comentário (linha 98)
Lembre-se: uma sessão pode armazenar dados de duas formas diferentes. 
Como um array associativo:
```php
    session(['objeto_id' => [
        'objeto_id' => $id,
    ]]);
```
Ou diretamente:
```php
    session(['objeto_id' => $id]);
```

Deste modo, a verificação
```php
    $objeto_id = is_object($objeto_id) ? $objeto_id->id : $objeto_id;
```
Verifica se `$objeto_id` e um objeto. Se sim, acessa a sua propriedade `id`; caso contrário, mantém o valor atual (`$objeto_id` como está).
