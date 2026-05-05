<template>
  <aside class="fixed top-0 left-0 w-80 h-screen bg-[#1a1a1a] z-1000 shadow-[0_16px_50px_rgba(0,0,0,0.55)] flex flex-col overflow-hidden">
    <div class="flex items-center justify-center p-5 mb-6">
      <RouterLink to="/" class="flex items-center">
        <img src="/images/logo.svg" alt="СайдКвест" class="w-8 h-8">
        <span class="text-white uppercase ml-3 font-bold text-lg font-display tracking-widest">SIDQUEST</span>
      </RouterLink>
    </div>

    <div class="flex-1 overflow-y-auto px-9 py-6">
      <nav class="mb-8">
        <ul class="space-y-2">
          <li>
            <RouterLink to="/" class="flex items-center text-white hover:text-gray-400 transition-colors">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              Каталог
            </RouterLink>
          </li>
          <li v-if="isLoggedIn">
            <RouterLink to="/library" class="flex items-center text-white hover:text-gray-400 transition-colors">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              Моя библиотека
            </RouterLink>
          </li>
          <li v-if="isAdmin">
            <RouterLink to="/admin" class="flex items-center text-white hover:text-gray-400 transition-colors">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Админка
            </RouterLink>
          </li>
        </ul>
      </nav>

      <div v-if="isLoggedIn" class="border-t border-[#383838] pt-5 mt-5">
        <div class="flex items-center justify-between mb-3">
          <span class="text-white font-medium">{{ userLogin }}</span>
          <button @click="logout" class="text-gray-400 hover:text-white text-sm transition-colors">Выйти</button>
        </div>
      </div>
      
      <nav v-else class="mt-5">
        <ul class="space-y-2">
          <li>
            <RouterLink to="/login" class="flex items-center text-white hover:text-gray-400 transition-colors">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
              </svg>
              Войти
            </RouterLink>
          </li>
          <li>
            <RouterLink to="/register" class="flex items-center text-white hover:text-gray-400 transition-colors">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Регистрация
            </RouterLink>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';

const router = useRouter();
const isLoggedIn = ref(false);
const userLogin = ref('');
const userRole = ref('');

const isAdmin = computed(() => userRole.value === 'admin');

const checkAuth = async () => {
  try {
    // This will be implemented after API routes are created
    // For now, it's a placeholder
    const response = await fetch('/api/user', {
      credentials: 'include'
    });
    if (response.ok) {
      const userData = await response.json();
      isLoggedIn.value = true;
      userLogin.value = userData.login;
      userRole.value = userData.role;
    } else {
      isLoggedIn.value = false;
    }
  } catch (error) {
    console.error('Auth check failed:', error);
    isLoggedIn.value = false;
  }
};

const logout = async () => {
  try {
    // This will be implemented after API routes are created
    await fetch('/api/logout', {
      method: 'POST',
      credentials: 'include'
    });
    isLoggedIn.value = false;
    userLogin.value = '';
    userRole.value = '';
    router.push('/login');
  } catch (error) {
    console.error('Logout failed:', error);
  }
};

onMounted(() => {
  checkAuth();
});
</script>

<style scoped>
/* All styles are now handled by the global style.css */
.font-display {
  font-family: var(--font-display);
}
</style>