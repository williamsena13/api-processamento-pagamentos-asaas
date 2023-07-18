# Sistema de Processamento de Pagamentos Integrado ao Asaas

O objetivo deste desafio é desenvolver um sistema de processamento de pagamentos integrado ao ambiente de homologação do Asaas. O sistema permitirá que o cliente selecione a opção de pagamento entre boleto, cartão de crédito ou Pix em uma página específica.

## Documentação

A documentação oficial do Asaas está disponível em: [https://asaasv3.docs.apiary.io/#](https://asaasv3.docs.apiary.io/#)

## Credenciais de Sandbox

Antes de iniciar a integração, é necessário criar uma conta no Asaas Sandbox em [https://sandbox.asaas.com/](https://sandbox.asaas.com/). Na seção "Configuração de Conta -> Integrações", você encontrará a API Key de Sandbox para utilizar durante a integração.

## Funcionalidades

O sistema a ser desenvolvido deverá oferecer as seguintes funcionalidades:

- Opção de pagamento através de boleto, cartão de crédito ou Pix.
- Formulário com campos necessários para processar o pagamento.
- Botão "Finalizar Pagamento" para realizar a transação.
- Página de agradecimento exibida após o processamento do pagamento com sucesso.

O sistema deverá atender aos seguintes requisitos:

- Desenvolvido em PHP utilizando o framework Laravel.
- Tratamento dos dados recebidos na requisição para garantir a integridade dos dados.
- Padronização das respostas da solicitação utilizando Resources conforme necessário.
- Padronização das requisições de integração com a API do Asaas.
- Processamento de pagamentos com boleto, cartão de crédito e Pix.
- Se o pagamento for realizado através de boleto, exibir um botão com o link do boleto na página de agradecimento.
- Se o pagamento for realizado através de Pix, exibir o QRCode e o texto para copiar e colar na página de agradecimento.
- Em caso de recusa do cartão de crédito ou erro na requisição, exibir uma mensagem amigável para facilitar o entendimento do não processamento do pagamento.
- O front-end não precisa ter alta qualidade, pode-se utilizar um framework básico como o Bootstrap.
- Utilização de boas práticas de programação.
- Utilização de boas práticas de controle de versão com o Git.
- Documentação de instruções para executar o projeto.

## Opcionais

Os seguintes itens são opcionais, mas serão considerados como diferenciais:

- Testes automatizados com informações sobre a cobertura de testes.
- Persistência dos dados em um banco de dados relacional, preferencialmente o MySQL.

## Avaliação

Todo o conhecimento aplicado neste teste será avaliado, portanto, não se limite apenas aos requisitos básicos.