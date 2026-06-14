import { createRouter, createWebHistory } from 'vue-router';

const AuthView = () => import('@/views/AuthView.vue');
const RoomsView = () => import('@/views/RoomsView.vue');
const BookingsView = () => import('@/views/BookingsView.vue');
const BookingCreateView = () => import('@/views/BookingCreateView.vue');

const routes = [
  { path: '/auth', component: AuthView, meta: { guest: true } },
  { path: '/rooms', component: RoomsView, meta: { auth: true } },
  {
    path: '/bookings/create',
    component: BookingCreateView,
    meta: { auth: true }
  },
  { path: '/bookings', component: BookingsView, meta: { auth: true } },
  { path: '/', redirect: '/rooms' }
];
const router = createRouter({
  history: createWebHistory(),
  routes
});
router.beforeEach((to, _from) => {
  const token = localStorage.getItem('token');
  if (to.meta.auth && !token) {
    return '/auth';
  }
  if (to.meta.guest && token) return '/rooms';
});

export default router;
