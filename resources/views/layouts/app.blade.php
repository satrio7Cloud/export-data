<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'My App')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            overflow-x: hidden;
            font-family: Arial, sans-serif;
        }
        /* Sidebar styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #343a40;
            color: #f8f9fa;
            padding-top: 30px;
            transform: translateX(0);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        .sidebar.closed {
            transform: translateX(-250px);
        }
        .sidebar h4 {
            color: #f8f9fa;
            padding-left: 20px;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #f8f9fa;
            font-size: 0.95rem;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #007bff;
            color: #ffffff;
        }
        /* Main content styling */
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }
        .main-content.expanded {
            margin-left: 0;
        }
        /* Header styling */
        header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        /* Toggle button styling */
        .toggle-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            cursor: pointer;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }
        .toggle-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Toggle Button -->
    <button class="toggle-btn" onclick="toggleSidebar()">☰ Menu</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4>Navigation</h4>
        <a href="{{ route('tasks.index') }}">Tasks</a>
        <a href="{{ route('anggota.index') }}">Data Anggota</a>
        {{-- <a href="{{ route('anggota.index') }}">Statsu saat ini</a> --}}
        <a href="{{ route('karyawan.index') }}">Data Karyawan</a>
        <a href="{{ route('shift.index') }}">Shift</a>
        <a href="{{ route('cuti.index') }}">Cuti</a>
        <a href="{{ route('libur.index') }}">Libur</a>
        <a href="{{ route('absensi.index') }}">Absensi</a>
        <a href="{{ route('izin.index') }}">Izin</a>
        <a href="{{ route('attendance.report') }}">Laporan Kehadiran</a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <header>My Application</header>
        <main class="container my-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('expanded');
        }
    </script>
</body>
</html>
