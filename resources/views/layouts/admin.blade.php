<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title') - {{ config('app.name', 'ResuMate') }} Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-hover: #45a049;
            --bg-body: #F8FAFC;
            --bg-card: #FFFFFF;
            --bg-sidebar: #1E293B; 
            --text-main: #334155;
            --text-muted: #64748B;
            --text-sidebar: #94A3B8;
            --border-color: #E2E8F0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        [data-theme="dark"] {
            --bg-body: #0F172A;
            --bg-card: #1E293B;
            --bg-sidebar: #020617;
            --text-main: #F1F5F9;
            --text-muted: #94A3B8;
            --text-sidebar: #64748B;
            --border-color: #334155;
            --shadow-sm: none;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); transition: background 0.3s, color 0.3s; }
        a { text-decoration: none; }
        ul { list-style: none; }

        .admin-wrapper { display: flex; min-height: 100vh; }
        
        .main-content-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
            transition: margin-left 0.3s;
        }

        .content-body {
            padding: 30px;
            flex: 1;
        }

        @media (max-width: 768px) {
            .main-content-wrapper { margin-left: 0; width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <script>
        const savedTheme = localStorage.getItem('admin_theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

    <div class="admin-wrapper">
        @include('admin.partials.sidebar')

        <div class="main-content-wrapper">
            @include('admin.partials.header')

            <main class="content-body">
                @yield('content')
            </main>

            @include('admin.partials.footer')
        </div>
    </div>

    @stack('scripts')
    
    <script>
        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme');
            const target = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', target);
            localStorage.setItem('admin_theme', target);
            
            const icon = document.getElementById('theme-icon');
            if(target === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }
    </script>
</body>
</html>