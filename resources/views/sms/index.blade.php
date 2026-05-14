<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Gateway</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Wyślij SMS</h1>
    <form id="smsForm" class="bg-white p-6 rounded shadow mb-8">
        <div class="mb-4">
            <label for="to" class="block text-sm font-medium mb-1">Numer telefonu</label>
            <input type="text"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" id="to"
                   name="to" required>
        </div>
        <div class="mb-4">
            <label for="message" class="block text-sm font-medium mb-1">Treść wiadomości</label>
            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                      id="message" name="message" rows="2" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Wyślij</button>
        <div id="formMessage" class="mt-2"></div>
    </form>

    <h2 class="text-xl font-semibold mb-4">Lista SMS</h2>
    <form id="filtersForm" class="flex flex-wrap gap-2 mb-4 items-end">
        <div>
            <label for="status" class="block text-xs font-medium mb-1">Status</label>
            <select id="status" class="border rounded px-2 py-1" name="status">
                <option value="">-- Status --</option>
                <option value="sent">Wysłane</option>
                <option value="queued">W kolejce</option>
                <option value="failed">Błąd</option>
            </select>
        </div>
        <div>
            <label for="sort" class="block text-xs font-medium mb-1">Sortowanie</label>
            <select id="sort" class="border rounded px-2 py-1" name="sort">
                <option value="sent_at:desc">Sortuj: Najnowsze</option>
                <option value="sent_at:asc">Sortuj: Najstarsze</option>
            </select>
        </div>
        <button id="applyFilters" type="button" class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-800">
            Filtruj
        </button>
    </form>
    <div id="smsList"></div>
    <div id="pagination" class="mt-4 flex flex-wrap gap-2"></div>
</div>
<script>
    let currentPage = 1;
    const smsList = document.getElementById('smsList');
    const pagination = document.getElementById('pagination');
    const formMessage = document.getElementById('formMessage');

    async function loadSms(page = 1) {
        currentPage = page;
        const status = document.getElementById('status').value;
        const sort = document.getElementById('sort').value;
        let url = `/api/sms?page=${page}`;
        if (status) url += `&status=${status}`;
        if (sort) url += `&sort=${sort}`;
        const response = await fetch(url);
        const data = await response.json();
        renderSmsList(data.data);
        renderPagination(data.meta);
    }

    function renderSmsList(list) {
        if (!list.length) {
            smsList.innerHTML = '<div class="bg-blue-100 text-blue-800 p-3 rounded">Brak wiadomości</div>';
            return;
        }
        let html = '<div class="overflow-x-auto"><table class="min-w-full bg-white rounded shadow"><thead><tr><th class="px-3 py-2 border-b">Numer</th><th class="px-3 py-2 border-b">Treść</th><th class="px-3 py-2 border-b">Status</th><th class="px-3 py-2 border-b">Provider</th><th class="px-3 py-2 border-b">Data wysłania</th></tr></thead><tbody>';
        for (const sms of list) {
            html += `<tr><td class="px-3 py-2 border-b">${sms.to}</td><td class="px-3 py-2 border-b">${sms.message}</td><td class="px-3 py-2 border-b">${sms.status}</td><td class="px-3 py-2 border-b">${sms.provider}</td><td class="px-3 py-2 border-b">${sms.sentAt}</td></tr>`;
        }
        html += '</tbody></table></div>';
        smsList.innerHTML = html;
    }

    function renderPagination(meta) {
        pagination.innerHTML = '';
        for (let i = 1; i <= meta.last_page; i++) {
            pagination.innerHTML += `<button onclick="loadSms(${i})" class="px-3 py-1 rounded border ${i === meta.page ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-100'}">${i}</button>`;
        }
    }

    document.getElementById('applyFilters').addEventListener('click', () => loadSms(1));
    document.getElementById('smsForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        formMessage.innerHTML = '';
        const form = e.target;
        const payload = {
            to: form.to.value,
            message: form.message.value,
        };
        const response = await fetch('/api/sms', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        });
        if (response.ok) {
            form.reset();
            formMessage.innerHTML = `<div class="text-green-700 bg-green-100 p-2 rounded mt-2">SMS queued successfully.</div>`;
            loadSms(currentPage);
        } else {
            const data = await response.json();
            formMessage.innerHTML = `<div class="text-red-700 bg-red-100 p-2 rounded mt-2">${data.message ?? 'Error'}</div>`;
        }
    });

    window.addEventListener('DOMContentLoaded', () => loadSms());
</script>
</body>
</html>