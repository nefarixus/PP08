let csrfTokenPromise = null;

function getCsrfToken() {
  const cookies = document.cookie.split(";");
  for (const cookie of cookies) {
    const [name, value] = cookie.trim().split("=");
    if (name === "XSRF-TOKEN") {
      return decodeURIComponent(value);
    }
  }
  return null;
}

function getCsrfTokenFromMeta() {
  const meta = document.querySelector('meta[name="csrf-token"]');
  return meta ? meta.getAttribute("content") : null;
}

async function fetchCsrfToken() {
  try {
    const response = await fetch("/sanctum/csrf-cookie", {
      method: "GET",
      credentials: "include",
    });

    if (response.ok) {
      // Небольшая задержка, чтобы браузер успел установить куку
      await new Promise((resolve) => setTimeout(resolve, 50));

      let token = getCsrfToken();
      if (token) {
        return token;
      }

      // Запасной вариант: токен из мета-тега blade-шаблона
      token = getCsrfTokenFromMeta();
      if (token) {
        return token;
      }
    }

    console.warn("CSRF token not available from cookie or meta tag. Status:", response.status);
    return null;
  } catch (error) {
    console.warn("Error fetching CSRF token (server may be unreachable):", error.message);
    return null;
  }
}

async function ensureCsrfToken() {
  let token = getCsrfToken();
  if (token) {
    return token;
  }

  // Попробуем взять из мета-тега перед запросом
  token = getCsrfTokenFromMeta();
  if (token) {
    return token;
  }

  if (!csrfTokenPromise) {
    csrfTokenPromise = fetchCsrfToken();
  }

  token = await csrfTokenPromise;
  csrfTokenPromise = null;

  return token;
}

/**
 * GET-запрос с нужными заголовками (Accept: application/json).
 */
export async function apiGet(url) {
  const token = await ensureCsrfToken();
  return fetch(url, {
    credentials: "include",
    headers: {
      Accept: "application/json",
      ...(token ? { "X-XSRF-TOKEN": token } : {}),
    },
  });
}

/**
 * POST-запрос с CSRF-токеном и JSON-заголовками.
 */
export async function apiPost(url, data = {}) {
  const token = await ensureCsrfToken();
  return fetch(url, {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      ...(token ? { "X-XSRF-TOKEN": token } : {}),
    },
    body: JSON.stringify(data),
  });
}
