# Sistema de Processamento de Pagamentos

Este é um projeto desenvolvido para o desafio de implementar um sistema de processamento de pagamentos integrado ao ambiente de homologação do Asaas. O sistema permite que o cliente selecione a opção de pagamento entre Boleto, Cartão ou Pix.

## Documentação

A documentação da API utilizada neste projeto pode ser encontrada em: [Documentação Asaas](https://asaasv3.docs.apiary.io/#)

## Credenciais de Sandbox

Para iniciar a integração, é necessário criar uma conta no Asaas Sandbox através do link: [Asaas Sandbox](https://sandbox.asaas.com/). Após a criação da conta, você poderá obter a API Key de Sandbox na seção "Configuração de Conta -> Integrações".

## Funcionalidades

O sistema foi desenvolvido com as seguintes funcionalidades:

- Opção de pagamento entre Boleto, Cartão de Crédito e Pix.
- Formulário com os campos necessários para processar o pagamento.
- Botão "Finalizar Pagamento" para submeter o formulário.
- Página de agradecimento exibida após o processamento do pagamento com sucesso.
- Tratamento dos dados enviados na requisição para evitar dados faltantes ou inválidos.
- Padronização das respostas das solicitações através da utilização de Resources.
- Integração com as APIs do Asaas para processar pagamentos.
- Exibição do link do boleto na página de agradecimento, caso o pagamento seja feito via boleto.
- Exibição do QRCode e opção de "Copia e Cola" na página de agradecimento, caso o pagamento seja feito via Pix.
- Exibição de mensagem amigável em caso de recusa do cartão ou erro na requisição de pagamento.
- Utilização de um framework Laravel, desenvolvido em PHP.
- Utilização de um layout básico usando Bootstrap.

## Requisitos

Antes de executar o projeto, verifique se você possui os seguintes requisitos:

- PHP (versão 7.2.5)
- Laravel (versão 7.0)
- Vue (versão 2.7.14)
- Bootsatrap (versão 4.6.2)
- Sweetalert (versão 2.1.2)
- Banco de dados relacional (recomendado: MariaDB)

## Executando o Projeto

Siga as etapas abaixo para executar o projeto em seu ambiente local:

1. Clone o repositório para o seu computador:

```
git clone https://github.com/williamsena13/api-processamento-pagamentos-asaas
```

2. Acesse o diretório do projeto:

```
cd api-processamento-pagamentos-asaas
```

3. Instale as dependências do projeto:

```
composer install
```

4. Gere a chave do Laravel

```
php artisan key:generate
```

5. Configure as informações do banco de dados

```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

6. Configure as credenciais do Asaas:

Edite o arquivo `.env` e insira sua API Key de Sandbox fornecida pelo Asaas:

```
KEY_API_ASAAS=sua-api-key
```
7. Execute as migrações do banco de dados:

```
php artisan migrate
```
8. Execute as Seeds no banco de daods:
```
php artisan db:seed
```
9. Instale as Dependencias npm 
```
npm install
```
10. Compile os arquivos do VueJS
```
npm run dev
```

11. Inicie o servidor de desenvolvimento:

```
php artisan serve
```

12. Acesse o aplicativo em seu navegador:

```
http://localhost:8000/register
```

13. Faça o [cadastro](http://localhost:8000/register) de seu usuário.

14. [Finalize](http://localhost:8000/checkout) a simulação da compra 

14.1 Se a forma de pagamento selecionada for "PIX", o usuário será redirecionado para uma tela de "Obrigado", onde será disponibilizado o QRCode para o pagamento.
14.2 Se a forma de pagamento selecionada for "Boleto", o usuário será redirecionado para uma tela de "Obrigado", onde poderá fazer o download do boleto.
14.3 Se a forma de pagamento selecionada for "Cartão de Crédito", será necessário preencher o endereço do usuário. Ao confirmar o pagamento, o usuário será direcionado para a tela de "Obrigado".

## Autor

[William B. Sena](https://github.com/williamsena13)

## Licença

Este projeto foi desenvolvido pelo [William B. Sena](https://github.com/williamsena13) 
