# Como Criar Componentes no Laravel
No Laravel, os Componentes Blade permitem reaproveitar trechos de HTML com suporte à lógica PHP de forma organizada. São ideais para criar elementos reutilizáveis, como cartões, botões, modais, etc., mantendo as views limpas e modulares.

## Comando para Criar um Componente
```bash
php artisan make:component NomeComponente
```
Este comando cria dois arquivos:
- Classe do componente: `app/View/Components/NomeComponente.php`
- View (Blade): `resources/views/components/nome-componente.blade.php`

Também podemos criar somente uma view, com o comando:
```bash
php artisan make:component --view NomeComponente
```


## Implementação
Na Classe PHP herdeira de `Component`, vamos implementar a lógica do componente. 
A classe gerada estende Illuminate\View\Component. Ela já vem com dois métodos:
- `__construct()`: define os parâmetros que podem ser passados ao componente (com valores opcionais ou obrigatórios). Os parâmetros públicos do construtor se tornam automaticamente disponíveis na view Blade.
- `render()`: retorna a view Blade que será usada para renderizar o componente, ex:`return view('components.nome-component');`.

Na view, organizamos o HTML e a lógica de exibição. Assim, podemos usar as variáveis definidas na classe.

[Abrir Exemplos](file:///C:\Users\CESAE\Desktop\Components\CardComponent.php
file:///C:\Users\CESAE\Desktop\Components\card-payment.blade.php)

Podemos definir propriedades públicas diretamente no construtor do componente, e esses atributos ficam automaticamente disponíveis na view Blade do componente, sem necessidade de declarar separadamente na classe.

### Também no componente, podemos implementar propriedades que são chamadas no construtor com o this. 

Se optar por criar somente uma view blade (sem classe derivada de Component), podemos usar a diretiva `@props` como fallback para garantir determinar variáveis e valores default, como:
```php
@props([
    'href' => null,
    'method' => 'GET',
    'buttonText' => 'Comprar',
])
```
Com esta diretiva dizemos "Se essas variáveis não forem passadas pelo componente, use esses valores como padrão.":
Essa diretiva define valores padrão somente para o Blade.

⚠️ No caso da criação de view e classe: se os mesmos parâmetros também forem definidos com valores padrão na classe PHP, os da classe predominam sobre os definidos em `props`.

## Chamar um componente 
Após a implementação do componente, na view onde deseja incluir o componente:
```php
<x-nome-componente parametro='valor' />
```
Portanto, para os exemplos acima:
```php
<x-card-payment method="POST" buttonText="Pagar" :list="['Opção 1', 'Opção 2']" />
```


## Observações
- Também é possível utilizar a diretiva `{{ $slot }}` se quiser permitir conteúdo interno personalizado ao usar o componente.
Exemplo no `blade.php` do `componente`:
```php
<div class="box">
    {{ $slot }}
</div>
```
Exemplo na chamada do componente:
```php
<x-nome-componente>
    <p>Conteúdo interno do componente</p>
</x-nome-componente>
```
Ou seja, o `{{ $slot }}` permite que a view que chama o componente insira conteúdo HTML personalizado dentro da marcação do componente. Esse conteúdo será automaticamente renderizado onde o `{{ $slot }}` estiver definido.


- Slots nomeados: permitem passar várias seções de conteúdo para diferentes partes do componente.

- Componentes aninhados: um componente pode chamar outro dentro da sua view.

- Métodos personalizados: você pode declarar métodos na classe e usá-los no Blade com $component->nomeDoMetodo().