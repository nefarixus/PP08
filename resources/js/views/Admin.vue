<template>
  <main class="adm-wrap">

    <div v-if="!isAdmin" class="adm-forbidden">
      <p>Доступ запрещён. Эта страница только для администраторов.</p>
    </div>

    <template v-else>
      <h1>Управление каталогом</h1>
      <p class="adm-subtitle">
        Добавление товаров в каталог. Изображение загружается автоматически.
      </p>

      <!-- Форма добавления -->
      <div class="adm-form">
        <h2>Новый товар</h2>

        <p v-if="formSuccess" class="adm-ok">{{ formSuccess }}</p>
        <p v-if="formError" class="adm-err">{{ formError }}</p>

        <form @submit.prevent="submitProduct">
          <label for="adm-name">Название</label>
          <input
            id="adm-name"
            v-model="form.name"
            type="text"
            maxlength="255"
            required
            placeholder="Название игры"
          >

          <label for="adm-desc">Описание</label>
          <textarea
            id="adm-desc"
            v-model="form.description"
            placeholder="Необязательно"
          ></textarea>

          <label for="adm-price">Цена (₽), 0 = бесплатно</label>
          <input
            id="adm-price"
            v-model="form.price"
            type="number"
            min="0"
            step="0.01"
            required
          >

          <label for="adm-img">Обложка (изображение)</label>
          <input
            id="adm-img"
            type="file"
            accept="image/*"
            required
            @change="onFileChange"
          >

          <div v-if="previewUrl" class="adm-preview">
            <img :src="previewUrl" alt="Превью обложки">
          </div>

          <button type="submit" :disabled="submitting">
            {{ submitting ? 'Добавление...' : 'Добавить в каталог' }}
          </button>
        </form>
      </div>

      <!-- Таблица продуктов -->
      <div class="adm-table-header">
        <h2>Текущие позиции</h2>
        <span class="adm-count">{{ activeProducts.length }} активных · {{ deletedProducts.length }} удалённых</span>
      </div>

      <div v-if="loadingProducts" class="adm-loading">Загрузка...</div>

      <table v-else class="adm-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Обложка</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Файл</th>
            <th>Статус</th>
            <th>Действия</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in products" :key="p.id" :class="{ 'adm-row-deleted': p.deleted_at }">
            <td>{{ p.id }}</td>
            <td>
              <img
                :src="`/images/${p.img}`"
                :alt="p.name"
                class="adm-thumb"
                @error="onImgError"
              >
            </td>
            <td>{{ p.name }}</td>
            <td>{{ p.price > 0 ? formatPrice(p.price) + ' ₽' : 'Бесплатно' }}</td>
            <td class="adm-filename">{{ p.img }}</td>
            <td>
              <span v-if="p.deleted_at" class="adm-badge adm-badge-deleted">Удалён</span>
              <span v-else class="adm-badge adm-badge-active">Активен</span>
            </td>
            <td>
              <button
                v-if="!p.deleted_at"
                class="adm-btn adm-btn-danger"
                @click="deleteProduct(p.id)"
                :disabled="actionId === p.id"
              >
                {{ actionId === p.id ? '...' : 'Удалить' }}
              </button>
              <button
                v-else
                class="adm-btn adm-btn-restore"
                @click="restoreProduct(p.id)"
                :disabled="actionId === p.id"
              >
                {{ actionId === p.id ? '...' : 'Восстановить' }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </template>
  </main>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { apiGet, apiPostForm, apiDelete } from '../utils/api';
import { useAuth } from '../stores/auth';

const { isAdmin } = useAuth();

const products = ref<any[]>([]);
const loadingProducts = ref(true);
const actionId = ref<number | null>(null);

const form = ref({ name: '', description: '', price: 0 });
const imgFile = ref<File | null>(null);
const previewUrl = ref('');
const formSuccess = ref('');
const formError = ref('');
const submitting = ref(false);

const activeProducts = computed(() => products.value.filter(p => !p.deleted_at));
const deletedProducts = computed(() => products.value.filter(p => p.deleted_at));

const formatPrice = (price: number) =>
  new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price);

const onFileChange = (e: Event) => {
  const input = e.target as HTMLInputElement;
  imgFile.value = input.files?.[0] ?? null;
  if (imgFile.value) {
    previewUrl.value = URL.createObjectURL(imgFile.value);
  } else {
    previewUrl.value = '';
  }
};

const onImgError = (e: Event) => {
  const img = e.target as HTMLImageElement;
  img.style.display = 'none';
};

const loadProducts = async () => {
  loadingProducts.value = true;
  try {
    const res = await apiGet('/api/admin/products');
    if (res.ok) {
      products.value = await res.json();
    }
  } finally {
    loadingProducts.value = false;
  }
};

const submitProduct = async () => {
  formSuccess.value = '';
  formError.value = '';

  if (!imgFile.value) {
    formError.value = 'Выберите файл обложки.';
    return;
  }

  submitting.value = true;
  try {
    const fd = new FormData();
    fd.append('name', form.value.name);
    fd.append('description', form.value.description);
    fd.append('price', String(form.value.price));
    fd.append('img_file', imgFile.value);

    const res = await apiPostForm('/api/admin/products', fd);
    const data = await res.json();

    if (res.ok) {
      formSuccess.value = data.message;
      form.value = { name: '', description: '', price: 0 };
      imgFile.value = null;
      previewUrl.value = '';
      // Сброс input[type=file]
      const fileInput = document.getElementById('adm-img') as HTMLInputElement;
      if (fileInput) fileInput.value = '';
      await loadProducts();
    } else {
      if (data.errors) {
        const first = Object.values(data.errors)[0] as string[];
        formError.value = Array.isArray(first) ? first[0] : String(first);
      } else {
        formError.value = data.message || 'Ошибка при добавлении товара.';
      }
    }
  } catch {
    formError.value = 'Сетевая ошибка. Попробуйте ещё раз.';
  } finally {
    submitting.value = false;
  }
};

const deleteProduct = async (id: number) => {
  if (!confirm('Удалить этот товар?')) return;
  actionId.value = id;
  try {
    const res = await apiDelete(`/api/admin/products/${id}`);
    if (res.ok) {
      await loadProducts();
    }
  } finally {
    actionId.value = null;
  }
};

const restoreProduct = async (id: number) => {
  actionId.value = id;
  try {
    const res = await apiPostForm(`/api/admin/products/${id}/restore`, new FormData());
    if (res.ok) {
      await loadProducts();
    }
  } finally {
    actionId.value = null;
  }
};

onMounted(() => {
  if (isAdmin.value) {
    loadProducts();
  }
});
</script>

<style scoped>
.adm-wrap {
  max-width: 980px;
  margin: 44px auto 60px;
  padding: 24px 8px 32px;
  color: #fff;
}

.adm-forbidden {
  text-align: center;
  padding: 80px 0;
  color: #f87171;
  font-size: 18px;
}

.adm-wrap h1 {
  font-size: 26px;
  margin: 0 0 4px;
  font-family: var(--font-display);
}

.adm-subtitle {
  color: #9ca3af;
  font-size: 13px;
  margin-bottom: 24px;
}

.adm-form {
  background: rgba(20, 20, 20, 0.72);
  padding: 22px 26px 26px;
  border-radius: 18px;
  margin-bottom: 32px;
  border: 1px solid rgba(55, 65, 81, 0.9);
  box-shadow: 0 28px 60px rgba(15, 23, 42, 0.9);
}

.adm-form h2 {
  margin: 0 0 14px;
  font-size: 18px;
  font-family: var(--font-display);
  font-weight: 700;
}

.adm-form label {
  display: block;
  margin-top: 14px;
  color: #9ca3af;
  font-size: 13px;
}

.adm-form input[type="text"],
.adm-form input[type="number"],
.adm-form textarea {
  width: 100%;
  box-sizing: border-box;
  margin-top: 4px;
  padding: 10px 12px;
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.16);
  background: rgba(0, 0, 0, 0.28);
  color: #e5e7eb;
  font-family: inherit;
  font-size: 14px;
}

.adm-form input[type="file"] {
  display: block;
  margin-top: 6px;
  color: #9ca3af;
  font-size: 13px;
}

.adm-form textarea {
  min-height: 110px;
  resize: vertical;
}

.adm-form input:focus,
.adm-form textarea:focus {
  outline: none;
  border-color: rgba(255, 255, 255, 0.3);
}

.adm-preview {
  margin-top: 12px;
  border-radius: 10px;
  overflow: hidden;
  max-width: 280px;
}

.adm-preview img {
  width: 100%;
  height: auto;
  display: block;
  object-fit: cover;
  max-height: 160px;
}

.adm-form button {
  margin-top: 22px;
  padding: 12px 26px;
  border-radius: 999px;
  border: none;
  background: #2a2a2a;
  color: #fff;
  cursor: pointer;
  font-size: 15px;
  font-weight: 600;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
  transition: box-shadow 0.2s, transform 0.2s;
}

.adm-form button:hover:not(:disabled) {
  box-shadow: 0 20px 55px rgba(0, 0, 0, 0.55);
  transform: translateY(-1px);
}

.adm-form button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.adm-ok {
  color: #4ade80;
  margin-bottom: 10px;
  font-size: 13px;
}

.adm-err {
  color: #f87171;
  margin-bottom: 10px;
  font-size: 13px;
}

.adm-table-header {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  gap: 12px;
  margin-bottom: 10px;
}

.adm-table-header h2 {
  font-size: 18px;
  font-family: var(--font-display);
  font-weight: 700;
  margin: 0;
}

.adm-count {
  font-size: 13px;
  color: #9ca3af;
}

.adm-loading {
  text-align: center;
  color: #9ca3af;
  padding: 32px 0;
}

table.adm-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
  border-radius: 14px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.10);
  background: rgba(20, 20, 20, 0.72);
}

table.adm-table thead {
  background: rgba(0, 0, 0, 0.22);
}

table.adm-table th,
table.adm-table td {
  padding: 10px 12px;
  text-align: left;
  vertical-align: middle;
}

table.adm-table th {
  color: #9ca3af;
  font-weight: 500;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  font-size: 13px;
}

table.adm-table tbody tr {
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  transition: background 0.15s;
}

table.adm-table tbody tr:nth-child(odd) {
  background: rgba(0, 0, 0, 0.12);
}

table.adm-table tbody tr:nth-child(even) {
  background: rgba(0, 0, 0, 0.20);
}

table.adm-table tbody tr:hover {
  background: rgba(255, 255, 255, 0.05);
}

.adm-row-deleted td {
  opacity: 0.45;
}

.adm-thumb {
  width: 56px;
  height: 36px;
  object-fit: cover;
  border-radius: 6px;
  display: block;
  background: #1a1a1a;
}

.adm-filename {
  font-size: 12px;
  color: #6b7280;
  max-width: 180px;
  word-break: break-all;
}

.adm-badge {
  display: inline-block;
  padding: 2px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
}

.adm-badge-active {
  background: rgba(34, 197, 94, 0.12);
  color: #4ade80;
  border: 1px solid rgba(34, 197, 94, 0.25);
}

.adm-badge-deleted {
  background: rgba(239, 68, 68, 0.12);
  color: #f87171;
  border: 1px solid rgba(239, 68, 68, 0.25);
}

.adm-btn {
  padding: 5px 14px;
  border-radius: 999px;
  border: none;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: opacity 0.15s;
}

.adm-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.adm-btn-danger {
  background: rgba(239, 68, 68, 0.18);
  color: #f87171;
  border: 1px solid rgba(239, 68, 68, 0.3);
}

.adm-btn-danger:hover:not(:disabled) {
  background: rgba(239, 68, 68, 0.28);
}

.adm-btn-restore {
  background: rgba(34, 197, 94, 0.14);
  color: #4ade80;
  border: 1px solid rgba(34, 197, 94, 0.28);
}

.adm-btn-restore:hover:not(:disabled) {
  background: rgba(34, 197, 94, 0.24);
}
</style>
