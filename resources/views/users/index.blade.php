<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg: #f5f5f5;
            --text: #333;
            --card-bg: #fff;
            --border: #ccc;
            --th-bg: #eee;
        }

        body.dark-mode {
            --bg: #121212;
            --text: #e0e0e0;
            --card-bg: #1e1e1e;
            --border: #333;
            --th-bg: #2d2d2d;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            padding: 20px;
            transition: background 0.3s, color 0.3s;
        }

        .header-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h2 {
            margin: 0;
            text-align: center;
            flex-grow: 1;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: var(--card-bg);
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background 0.3s;
        }

        .chart-container {
            width: 100%;
            max-width: 350px;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            color: var(--text);
        }

        th, td {
            border: 1px solid var(--border);
            padding: 8px;
            text-align: center;
        }

        th {
            background: var(--th-bg);
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
            display: inline-block;
        }

        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .btn-delete { background: #ff4d4d; }
        .btn-toggle { background: #007bff; }
        .btn-dark { background: #343a40; color: #fff; }

        .btn:hover { opacity: 0.85; }

        .search-form {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .search-form input {
            flex: 1;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--text);
        }

        .trash-section {
            margin-top: 40px;
            padding: 20px;
            border: 1px dashed #dc3545;
            border-radius: 6px;
            background: rgba(220, 53, 69, 0.05);
        }

        #toastr {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 200px;
        }

        #toastr div {
            margin-bottom: 10px;
            padding: 10px;
            color: #fff;
            border-radius: 4px;
            animation: fadein 0.5s, fadeout 0.5s 2.5s forwards;
        }

        .success { background: #28a745; }

        @keyframes fadein {
            from { opacity: 0; transform: translateX(100%); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeout {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-wrap">
            <h2>Users Dashboard</h2>
            <button class="btn btn-dark" onclick="toggleTheme()" id="theme-btn">Dark Mode</button>
        </div>

        @if(isset($analytics))
        <div class="chart-container">
            <canvas id="userChart"></canvas>
        </div>
        @endif

        <form method="GET" action="{{ route('users.index') }}" class="search-form">
            <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-success">Search</button>
            <a href="{{ route('users.export') }}" class="btn btn-success">Export CSV</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="btn {{ $user->status ? 'btn-success' : 'btn-danger' }}" style="padding: 4px 8px; font-size: 12px; cursor: default;">
                                {{ $user->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-toggle">Toggle</button>
                            </form>
                            <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Move this user to trash?');">
                                @csrf
                                <button type="submit" class="btn btn-delete">Trash</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 15px;">Total Users: {{ $users->total() }}</p>
        <div>{{ $users->links() }}</div>

        @if(isset($trashedUsers) && $trashedUsers->count() > 0)
        <div class="trash-section">
            <h3 style="text-align: center; color: #dc3545; margin-top: 0;">Trash Bin</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Restore</button>
                                </form>
                                <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user permanently?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div id="toastr">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
    </div>

    <script>
        function toggleTheme() {
            const isDark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            document.getElementById('theme-btn').innerText = isDark ? 'Light Mode' : 'Dark Mode';
            updateChartTheme();
        }

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            document.getElementById('theme-btn').innerText = 'Light Mode';
        }

        const toast = document.querySelector('#toastr div');
        if (toast) {
            setTimeout(() => { toast.style.display = 'none'; }, 3000);
        }

        let myChart;
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('userChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Inactive', 'Trashed'],
                    datasets: [{
                        data: [
                            {{ $analytics['active'] ?? 0 }}, 
                            {{ $analytics['inactive'] ?? 0 }}, 
                            {{ $analytics['trashed'] ?? 0 }}
                        ],
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                        borderWidth: 2,
                        borderColor: getComputedStyle(document.body).getPropertyValue('--card-bg').trim()
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: getComputedStyle(document.body).getPropertyValue('--text').trim()
                            }
                        }
                    }
                }
            });
        });

        function updateChartTheme() {
            if (myChart) {
                myChart.options.plugins.legend.labels.color = getComputedStyle(document.body).getPropertyValue('--text').trim();
                myChart.data.datasets.borderColor = getComputedStyle(document.body).getPropertyValue('--card-bg').trim();
                myChart.update();
            }
        }
    </script>
</body>
</html>