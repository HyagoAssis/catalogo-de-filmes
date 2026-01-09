# Projeto Base

Projeto Base Laravel, Vue.js e Docker.

---

## 🚀 Como rodar o projeto localmente com Docker

### Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)

### Passo a passo

1. Clone o repositório:
    ```bash
    git clone https://github.com/HyagoAssis/projeto-base.git
    cd projeto-base

2. Copie o arquivo .env.example para .env do Backend:
    ```bash
    #Linux ou Mac
    cd backend
    cp .env.example .env
    cd ..
   
   #Windows
   cd backend
   copy .env.example .env
   cd ..
    ```

3. Edite o arquivo hosts do sistema operacional
    - Tutorial : https://docs.rackspace.com/docs/como-modifico-meus-arquivos-de-hosts
    - Insira as linhas abaixo:
   ```bash
    127.0.0.1 projeto.site
    127.0.0.1 api.projeto.site
   ```

5. Realize o login no Docker e suba os containers da aplicação (A primeira vez pode demorar um pouco)
    ```bash
    cd docker
    docker login
    docker composer up -d
   ````

    - A aplicação já poderá ser acessada em 'projeto.site'.
    - Todos demais comandos, instalações e importações já foram realizadas nos arquivos entrypoints de cada container
      docker.
    - Testes podem ser realizados pelo seguinte comando:
    ```bash
    docker exec -it backend  php artisan test
    ```
7. Tendo seguido todos passos corretamente, todas as vezes que for necessário rodar a aplicação, basta subir os
   containers, não sendo necessário repetir todos passos, somente se for fazer uma nova instalação do zero.
    ```bash
    cd docker
    docker composer up -d
   ````
8. Obervações:
    - Caso se tenha redirects do navegador, basta limpar o cache do mesmo, tendo como alternativa também usar a guia
      anônima.
    - Se necessário mudar nome/portas dos containers, é necessário trocar o DB_HOST e DB_PORT no .env do diretório
      backend
      para o caso do Banco de Dados e o arquivo de configuração do Nginx, caso seja referente ao Nginx.






# projeto-base
