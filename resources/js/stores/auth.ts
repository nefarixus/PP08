import { ref, computed } from 'vue';
import { apiGet, apiPost } from '../utils/api';

const STORAGE_KEY = 'auth_user';

const isLoggedIn = ref(false);
const userLogin = ref('');
const userEmail = ref('');
const userRole = ref('');
const isAdmin = computed(() => userRole.value === 'admin');

let _authPromise: Promise<void> | null = null;

export const setUser = (userData: any) => {
  isLoggedIn.value = true;
  userLogin.value = userData.login || '';
  userEmail.value = userData.email || '';
  userRole.value = userData.role || '';
  localStorage.setItem(STORAGE_KEY, JSON.stringify({
    login: userLogin.value,
    email: userEmail.value,
    role: userRole.value,
  }));
};

const _clearUser = () => {
  isLoggedIn.value = false;
  userLogin.value = '';
  userEmail.value = '';
  userRole.value = '';
  localStorage.removeItem(STORAGE_KEY);
};

const _loadFromStorage = (): boolean => {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (!raw) return false;
    const data = JSON.parse(raw);
    isLoggedIn.value = true;
    userLogin.value = data.login || '';
    userEmail.value = data.email || '';
    userRole.value = data.role || '';
    return true;
  } catch {
    return false;
  }
};

export const checkAuth = (): Promise<void> => {
  if (_authPromise) return _authPromise;

  const hadStoredSession = _loadFromStorage();

  if (!hadStoredSession) {
    _authPromise = Promise.resolve();
    return _authPromise;
  }

  _authPromise = apiGet('/api/user')
    .then(response => {
      if (response.ok) {
        return response.json().then(setUser);
      } else {
        _clearUser();
      }
    })
    .catch(() => {
      _clearUser();
    });

  return _authPromise;
};

export const logout = async () => {
  try {
    await apiPost('/api/logout');
  } catch {}
  _clearUser();
  _authPromise = null;
};

export function useAuth() {
  return { isLoggedIn, userLogin, userEmail, userRole, isAdmin, checkAuth, logout, setUser };
}
