import { ref, computed } from 'vue';
import { apiGet, apiPost } from '../utils/api';

// Модульный уровень — синглтон, общий для всех компонентов
const isLoggedIn = ref(false);
const userLogin = ref('');
const userEmail = ref('');
const userRole = ref('');
const isAdmin = computed(() => userRole.value === 'admin');

const _setUser = (userData: any) => {
  isLoggedIn.value = true;
  userLogin.value = userData.login || '';
  userEmail.value = userData.email || '';
  userRole.value = userData.role || '';
};

const _clearUser = () => {
  isLoggedIn.value = false;
  userLogin.value = '';
  userEmail.value = '';
  userRole.value = '';
};

export const checkAuth = async () => {
  try {
    const response = await apiGet('/api/user');
    if (response.ok) {
      _setUser(await response.json());
    } else {
      _clearUser();
    }
  } catch {
    _clearUser();
  }
};

export const logout = async () => {
  try {
    await apiPost('/api/logout');
  } catch {}
  _clearUser();
};

export function useAuth() {
  return { isLoggedIn, userLogin, userEmail, userRole, isAdmin, checkAuth, logout };
}
