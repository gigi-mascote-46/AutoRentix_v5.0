# 📧 Configuração de Mailtrap no Laravel

Este guia explica como configurar o Mailtrap no Laravel para capturar e testar emails enviados pela aplicação.

## ✅ Pré-requisitos

- Conta no [Mailtrap](https://mailtrap.io)
- Projeto Laravel instalado e funcional
- `.env` configurado corretamente

---

## 1. 🔐 Criar conta e obter credenciais

1. Vai a [https://mailtrap.io](https://mailtrap.io)
2. Cria uma conta (ou faz login)
3. Cria uma inbox (se necessário)
4. Clica em **SMTP Settings**
5. Copia os dados para o Laravel (Laravel 9+ profile)

---

## 2. 🛠️ Configurar o `.env`

Substitui ou adiciona as seguintes variáveis no ficheiro `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=admin@autorentix.pt
MAIL_FROM_NAME="${APP_NAME}"
```

> 🔒 Substitui `your_mailtrap_username` e `your_mailtrap_password` pelos valores reais do painel Mailtrap.

---

## 3. 🧪 Testar envio de email

### Criar uma rota de teste:

```php
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('Este é um email de teste!', function ($message) {
        $message->to('teste@exemplo.pt')->subject('Teste de Email');
    });
    return 'Email enviado!';
});
```

Acede ao navegador: [http://localhost:8000/test-email](http://localhost:8000/test-email)

> O email irá aparecer automaticamente na tua inbox Mailtrap.

---

## 4. 📥 Ver email na inbox Mailtrap

1. Vai ao teu painel Mailtrap
2. Abre a inbox onde configuraste o SMTP
3. Vê o email de teste

---

## 5. ✅ Notas Finais

- Ideal para ambiente de desenvolvimento
- Os emails **não** são enviados para destinatários reais
- Permite testar design e conteúdo de emails

---

🧠 Dica: Usa Mailtrap com notificações, jobs e autenticação para testar toda a stack de emails antes de enviar para produção.
