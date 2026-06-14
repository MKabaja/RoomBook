import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import type { User } from '@/types';
import api from '@/api/axios';

type AuthToken = string | null;
type AuthUser = User | null;

type AuthResponse = {
  user: User;
  token: string;
};

function parseStoredUser(): AuthUser {
  try {
    return JSON.parse(localStorage.getItem('user') ?? 'null')
  } catch {
    return null
  }
}

export const useAuthStore = defineStore('auth', () => {
  const token = ref<AuthToken>(localStorage.getItem('token'));
  const user = ref<AuthUser>(parseStoredUser());
  const isAuthenticated = computed(() => !!token.value);

  async function login(email: string, password: string) {
    const response = await api.post<AuthResponse>('/login', { email, password });
    setAuth(response.data);
  }
  async function register(
    name: string,
    email: string,
    password: string,
    password_confirmation: string
  ) {
    const response = await api.post<AuthResponse>('/register', {
      name,
      email,
      password,
      password_confirmation
    });
    setAuth(response.data);
  }
  async function logout() {
    await api.post('/logout');
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    token.value = null;
    user.value = null;
  }
  function setAuth(data: AuthResponse) {
    localStorage.setItem('token', data.token);
    localStorage.setItem('user', JSON.stringify(data.user));
    token.value = data.token;
    user.value = data.user;
  }

  return { token, user, isAuthenticated, login, register, logout };
});
