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
        await fetch('/sanctum/csrf-cookie', { credentials: 'include' });
        token = getCsrfToken();
    }
    return token;
}

export async function apiGet(url) {
    return fetch(url, { credentials: 'include' });
}

export async function apiPost(url, data = {}) {
    const token = await ensureCsrfToken();
    return fetch(url, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': token || '',
        },
        body: JSON.stringify(data),
    });
}
