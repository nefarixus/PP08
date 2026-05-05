function getCsrfToken() {
    const cookies = document.cookie.split(';');
    for (const cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'XSRF-TOKEN') {
            return decodeURIComponent(value);
        }
    }
    return null;
}

async function ensureCsrfToken() {
    let token = getCsrfToken();
    if (!token) {
        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
            headers: { 'Accept': 'application/json' },
        });
        token = getCsrfToken();
    }
    return token;
}

/**
 * GET request with proper headers so Laravel returns JSON errors (not HTML).
 */
export async function apiGet(url) {
    return fetch(url, {
        credentials: 'include',
        headers: {
            'Accept': 'application/json',
        },
    });
}

/**
 * POST request with CSRF token and JSON headers.
 */
export async function apiPost(url, data = {}) {
    const token = await ensureCsrfToken();
    return fetch(url, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-XSRF-TOKEN': token || '',
        },
        body: JSON.stringify(data),
    });
}
