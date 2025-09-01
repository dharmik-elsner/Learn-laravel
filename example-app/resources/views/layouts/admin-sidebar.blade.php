<div id="sidebar">
    <ul>
        <li><a href="{{ route('home') }}">🏠 Home</a></li>
        <li><a href="{{ route('view.users') }}">users Dashboard</a></li>
        <li><a href="{{ route('home') }}">🛒 shop change Dashboard</a></li>
        <li><a href="{{ route('home') }}">For Example Dashboard</a></li>
        @if(Auth::check() && Auth::user()->role === 'Admin')
            <li><a href="#">⚙️ Admin Panel</a></li>
        @endif
    </ul>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

    // Close sidebar if clicking outside
    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !toggleBtn?.contains(e.target)) {
            sidebar.classList.remove('active');
        }
    });
</script>

<style>
    #sidebar {
        position: fixed;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100%;
        background: #343a40;
        color: #fff;
        transition: left 0.3s ease;
        padding-top: 60px;
        z-index: 1050;
    }
    #sidebar.active {
        left: 0;
    }
    #sidebar ul {
        list-style: none;
        padding: 0;
    }
    #sidebar ul li {
        padding: 15px;
    }
    #sidebar ul li a {
        color: #fff;
        text-decoration: none;
        display: block;
    }
    #sidebar ul li a:hover {
        background: #495057;
    }
    #sidebarToggle {
        cursor: pointer;
        font-size: 1.5rem;
        margin-right: 15px;
    }
</style>
