import axios from 'axios';

const api = axios.create({
  baseURL: 'http://api.catalogo.site', // aqui o endpoint base
  headers: {
    'Content-Type': 'application/json',
  },
});

api.defaults.withCredentials = true;
api.defaults.withXSRFToken = true;

function resource(path, actions = {}) {
  return Object.assign(
    {
      get: (id, params = {}, config = {}) => api.get(`${path}/${id}`, { params, ...config }),
      query: (params = {}, config = {}) => api.get(path, { params, ...config }),
      delete: (id) => api.delete(`${path}/${id}`),
      save: (obj, params = {}, config = {}) => api.post(path, obj, { params, ...config }),
    },
    actions
  );
}

export const authService = {
  login: (obj, params = {}, config = {}) =>
    api.post(`/login`, obj, {
      params,
      ...config,
    }),
  register: (obj, params = {}, config = {}) =>
    api.post(`/register`, obj, {
      params,
      ...config,
    }),
  forgotPassword: (obj, params = {}, config = {}) =>
    api.post(`/forgot-password`, obj, {
      params,
      ...config,
    }),
  logout: (params = {}, config = {}) =>
    api.post(`/logout`, {
      params,
      ...config,
    }),
  getUser: (params = {}, config = {}) =>
    api.get(`/user`, {
      params,
      ...config,
    }),
  csrfToken: (params = {}, config = {}) =>
    api.get(`/sanctum/csrf-cookie`, {
      params,
      ...config,
    }),
};

export const tmdbService = {
  searchMovie: (params = {}, config = {}) =>
    api.get(`/api/search_movie`, {
      params,
      ...config,
    }),
};

export const favoriteMoviesService = resource('/api/favorite_movie', {
  deleteByMovieDbId: (id, params = {}, config = {}) =>
    api.delete(`/api/favorite_movie/delete_by_movie_db_id/${id}`, {
      params,
      ...config,
    }),
});

export const genresService = resource('/api/genres');
