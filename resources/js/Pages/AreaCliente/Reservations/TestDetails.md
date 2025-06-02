# Cartões de Crédito de Teste para Desenvolvimento

Este ficheiro contém números de cartões de crédito **falsos e seguros** para testar sistemas de pagamento em **ambientes de desenvolvimento**.  
Estes cartões **não estão ligados a contas reais** e são fornecidos oficialmente por serviços como Stripe e PayPal (Braintree).

---

## 🟦 Cartões de Teste Stripe

| Tipo de Cartão     | Número                      | Validade | CVC  | Resultado da Transação |
|--------------------|-----------------------------|----------|------|-------------------------|
| Visa               | `4242 4242 4242 4242`       | 12/34    | 123  | Sucesso                 |
| Mastercard         | `5555 5555 5555 4444`       | 12/34    | 123  | Sucesso                 |
| American Express   | `3782 822463 10005`         | 12/34    | 1234 | Sucesso                 |
| Cartão Recusado    | `4000 0000 0000 9995`       | 12/34    | 123  | Transação recusada      |

> ⚠️ Estes cartões funcionam apenas no modo **sandbox** da Stripe.

---

## 🟨 Cartões de Teste PayPal (via Braintree)

| Tipo de Cartão     | Número                      | Validade | CVC  | Resultado da Transação |
|--------------------|-----------------------------|----------|------|-------------------------|
| Visa               | `4111 1111 1111 1111`       | 12/34    | 123  | Sucesso                 |
| Mastercard         | `5555 5555 5555 4444`       | 12/34    | 123  | Sucesso                 |
| American Express   | `3782 822463 10005`         | 12/34    | 1234 | Sucesso                 |
| Discover           | `6011 1111 1111 1117`       | 12/34    | 123  | Sucesso                 |
| Cartão Recusado    | `4000 0000 0000 0002`       | 12/34    | 123  | Transação recusada      |

> 🔐 Para testar com PayPal, deves ativar o modo **sandbox** no [PayPal Developer Dashboard](https://developer.paypal.com/).

---

## ⚙️ Notas de Implementação

- Os cartões são válidos apenas para **testes**.
- Usa data de validade futura e um CVC de 3 ou 4 dígitos.
- Implementa validação com o **Algoritmo de Luhn** para verificar estrutura.
- Usa placeholders visuais como `#### #### #### ####` para facilitar o input.

---

## 📚 Fontes Oficiais

- [Stripe Testing Docs](https://stripe.com/docs/testing)
- [PayPal Developer Docs](https://developer.paypal.com/tools/sandbox/)
- [Braintree Card Testing](https://developer.paypal.com/braintree/docs/guides/credit-cards/testing-go-live)

