# Web Crawler

## Como testar

1. Após baixar o código deste repositório, extraia os arquivos e mova-os para onde desejar
2. Abra o terminal de comandos, aponte para a pasta escolhida e rode o comando [composer install]
3. Rode o comando [php artisan serve] para que o servidor de desenvolvimento do Laravel seja iniciado
4. Utilize um ambiente de desenvolvimento de APIs (como o Postman) para efetuar requisições para o endereço [localhost:8000/api/]

## Rotas

### [GET] api/detalhes/{marca}/{modelo}/{anos}/{codigo}
Rota utilizada para buscar os detalhes de um anúncio específico.

#### Entrada
- marca: string
- modelo: string
- anos: string(9) "YYYY-YYYY"
- codigo: int


### [GET] api/pesquisa/{veiculo}/{marca}/{modelo}/{estado_conservacao?}/{cidade?}/{valor1?}/{valor2?}/{ano1?}/{ano2?}/{usuario?}
Rota utilizada para buscar a lista de anúncios que correspondem aos parâmetros fornecidos

#### Entrada
- veiculo: "carro" || "moto" || "caminhao" (*)
- estado_conservacao: "0km" || "seminovo"
- marca: string (*)
- modelo: string (*)
- cidade: int
- valor1: int
- valor2: int
- ano1: int
- ano2: int
- usuario: "particular" || "revenda"
- pagina: int\
(*) Campos obrigatórios


