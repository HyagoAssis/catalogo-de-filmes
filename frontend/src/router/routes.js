import Home from '@/components/pages/Home.vue';
import FavoritesMovies from '@/components/pages/FavoritesMovies.vue';
import NotFound from '@/components/pages/NotFound.vue';

export const routes = [
  {
    path: '/',
    component: Home,
    name: 'home',
    props: {
      showInMenu: true,
      title: 'Página Principal',
    },
  },
  {
    path: '/favorites',
    component: FavoritesMovies,
    name: 'favorites',
    props: {
      showInMenu: true,
      title: 'Favoritos',
    },
  },

  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
];
