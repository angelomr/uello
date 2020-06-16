<p align="center"><img src="https://www.uello.com.br/images/favicon.png" width="150"></p>

## Teste de Desenvolvimento da Uello


### Criação de Clientes

> Disponibilizar projeto junto com dump SQL no github em modo público;
> Enviar link do repositório para fernando.sartori@uello.com.br;thiago@uello.com.br;marcelo.cerqueira@uello.com.br

**Requisitos negócio:**
- Criar estrutura banco de dados:    
- Importar um arquivo CSV de cliente(s);
- Parsear endereço (logradouro, número, complemento, bairro, cep, cidade);
- Buscar GeoLocalização (GeoCoding) utilizando API do Google;
- Salvar em Banco de dados;
- Exibir em um grid os dados importados no BD;
- Exportar dados do Grid em csv;
- Gerar uma sequência lógica de entregas entre os endereços importados do csv:
    - Utilizar o endereço Avenida Dr. Gastão Vidigal, 1132 - Vila Leopoldina - 05314-010 como ponto inicial;


**Requisitos Técnicos:**
- controle de versionamento (GIT)
- PHP 7;
- Utilizar Composer para libs externas;
- Framework;
- Mysql;
- Front Bootstrap;

**O que se espera:** 
- Utilização de Design Patterns (https://www.php-fig.org/psr/)
- Desenvolvimento da Lógica para leitura do CSV;
- Validação e cleanup dos dados(Parse endereço);
- Buscar geocoding;
- Estruturação da tabela;
- Salvar dados BD;

**Diferenciais:**
- Docker;
- Testes Unitários;

**Dados do arquivo:**
> nome;email;datanasc;cpf;endereco;cep
> thiago;thiago@uello.com.br;11/11/1911;123.456.789-01;R Almirante Brasil, 685 - Mooca - São Paulo;03162-010
> Marcelo Cerqueira;marcelo.cerqueira@uello.com.br;11/07/1952;987.654.321-09;Rua Itajaí, 125 Ap 1234 - Mooca - São Paulo;03162-060
> André;andre@uello.com.br;11/05/1988;987.654.321-09;Rua José Monteiro, 303 - Brás - São Paulo;03052-010
> Fernando Sartori;fernando.sartori@uello.com.br;11/03/1975;987.654.321-09;Rua Ipanema, 686 Conj 1 - Brás - São Paulo;03164-200

**Dados para Instalação:**
- Requisitos: Docker (https://docs.docker.com) e Docker Compose (https://docs.docker.com/compose/)
- git clone https://github.com/angelomr/uello.git
- cd uello
- sudo ./run.sh
- Acessar o navegador no endereço: http://localhost:4080

**Outras informações**
- Pasta docs contem o arquivo csv para teste e o dump do banco de dados para análise da estrutura.