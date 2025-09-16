# Cátalodo de Filmes

Aplicação para gerenciamento de filmes favoritos, construída com **Laravel** (backend) e **Vue.js 3** (frontend),
integrando com a **API do TMDB**.

---

## 🚀 Como rodar o projeto localmente com Docker

### Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)

### Passo a passo

1. Clone o repositório:
    ```bash
    git clone https://github.com/seu-usuario/catalogo-de-filmes.git
    cd catalogo-de-filmes

2. Copie o arquivo .env.example para .env do Backend:
    ```bash
    cd backend
    cp .env.example .env
    cd ..
    ```

3. Edite o arquivo hosts do sistema operacional
    - Tutorial : https://docs.rackspace.com/docs/como-modifico-meus-arquivos-de-hosts
    - Insira as linhas abaixo:
   ```bash
    127.0.0.1 catalogo.site
    127.0.0.1 api.catalogo.site
   ```

4. Obtenha uma chave para API do TMDB

- Acesse: https://developer.themoviedb.org/reference/intro/getting-started
- Clique em GET API Key, realize login, siga os passos e obtenha uma API Key,
- Tutorial detalhado: https://www.educative.io/courses/movie-database-api-python/set-up-the-credentials
- Insira ela no seu arquivo .env localizado na pasta backend

    ```dotenv
    TMDB_API_KEY={SUA_API_KEY}
    ```

6. Realize o login no Docker e suba os containers da aplicação
    ```bash
    cd docker
    docker login
    docker composer up -d
   ````

    - A aplicação já poderá ser acessada em http://catalogo.site.
    - Todos demais comandos, instalações e importações já foram realizadas nos arquivos entrypoints de cada container
      docker.
    - Testes podem ser realizados pelo seguinte comando:
    ```bash
    docker exec -it backend  php artisan test
    ```
7. Tendo seguido todos passos corretamente, todas as vezes que for necessário rodar a aplicação, basta subir os
   containers, não sendo necessário repetir todos passos somente se for fazer uma nova instalação do zero.
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

## Utilização

1. É possível pesquisar filmes na tela inicial:
    - Exemplo realizando a pesquisa pelos filmes do Harry Potter, usando a barra de busca.
    - Para favoritar é necessário estar logado, e pode ser feito clicando no ícone de coração de cada card.
    - Filmes favoritados podem sem encontrados na página "Favoritos" ('/favorites') que fica protegida a usuários
      logados.
    - Filmes favoritos podem ser removidos ao desmarcar o ícone de coração.

## Organização

1. O projeto foi realizado separando-se o frontend, backend e docker da aplicação, tendo as seguintes principais
   estruturas:
    ```bash
   catálogo-de-filmes/
    ├── backend/                     # Backend Laravel 12
    │   ├── app/
    │   │   ├── Http/
    │   │   │   └── Controllers/
    │   │   │       ├── FavoriteMovieController.php   # Controller do CRUD de Filmes Favoritos
    │   │   │       └── TmdbController.php            # Controller da busca à API do TMDB
    │   │   ├── Models/
    │   │   │   ├── FavoriteMovie.php       # Model dos Filmes Favoritos
    │   │   │   ├── Genre.php               # Model dos gêneros de filmes
    │   │   │   └── FavoriteMovieGenre.php  # Model das relações entre gêneros e filmes favoritos
    │   │   ├── Libs/
    │   │   │   └── TMDB/
    │   │   │       └── TmdbClient.php     # Cliente da API do TMDB
    │   ├── tests/
    │   │   └── Feature/
    │   │       ├── FavoriteMovie/    # Testes de Filmes Favoritos
    │   │       └── Tmdb/             # Testes de API TMDB
    │   ├── routes/
    │   │   ├── api.php    # Rotas da APi de filmes favoritos e de consulta a API do TMDB
    │   │   └── auth.php   # Rotas de autenticação   
    ├── frontend/                    # Frontend Vue.js 3
    │   ├── src/
    │   │   ├── components/
    │   │   │   ├── pages/           # Páginas da aplicação
    │   │   │   ├── movies/          # Componentes relacionados aos filmes
    │   │   │   ├── auth/            # Componentes relacionados à autenticação
    │   │   │   └── common/          # Componentes diversos utilizados
    │   │   ├── services/
    │   │   │   └── resource.js       # Consumo das APIs do backend
    │   │   ├── router/               # Roteamento da aplicação
    │   │   │   ├── index.js          # Arquivo principal do Router
    │   │   │   └── routes.js         # Definição de rotas
    │   │   ├── global-scopes/        # Escopos globais
    │   │   │   ├── alerts.js         # Alerts personalizados
    │   │   │   ├── auth-modal.js     # Abertura de modal de notificação
    │   │   │   └── user.js           # Controle de sessão
    │   │   ├── App.vue
    │   │   └── main.js
    └── docker/                        # Docker Compose
        ├── nginx/                     # Configurações do Nginx
        └── docker-compose.yml         # Arquivo .yml do Docker Compose
   ```  






