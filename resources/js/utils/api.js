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

async function fetchCsrfToken() {
  try {
    const response = await fetch("/sanctum/csrf-cookie", {
      method: "GET",
      credentials: "include",
    });
    
    if (response.ok) {
      const token = getCsrfToken();
      if (token) {
        return token;
      }
    }
    console.error("Failed to fetch CSRF token from sanctum endpoint");
    return null;
  } catch (error) {
    console.error("Error fetching CSRF token:", error);
    return null;
  }
}

async function ensureCsrfToken() {
  // Check if we already have a token
  let token = getCsrfToken();
  if (token) {
    return token;
  }

  // If we don't have a token, check if we're already fetching one
  if (!csrfTokenPromise) {
    csrfTokenPromise = fetchCsrfToken();
  }

  // Wait for the token fetch to complete
  token = await csrfTokenPromise;
  
  // Reset the promise so we can fetch again if needed
  csrfTokenPromise = null;
  
  return token;
}

/**
 * GET request with proper headers so Laravel returns JSON errors (not HTML).
 */
export async function apiGet(url) {
  const token = await ensureCsrfToken();
  return fetch(url, {
    credentials: "include",
    headers: {
      Accept: "application/json",
      "X-XSRF-TOKEN": token || "",
    },
  });
}

/**
 * POST request with CSRF token and JSON headers.
 */
export async function apiPost(url, data = {}) {
  const token = await ensureCsrfToken();
  return fetch(url, {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      "X-XSRF-TOKEN": token || "",
    },
    body: JSON.stringify(data),
  });
}