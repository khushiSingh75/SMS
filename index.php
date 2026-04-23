<?php
include_once 'config/database.php';
include_once 'classes/student.php';

// Initialize database and student object
$database = new Database();
$db = $database->getConnection();
$student = new Student($db);

if(isset($_GET['search']) && !empty($_GET['search'])) {
    $keyword = $_GET['search'];
    $result = $student->search($keyword);
} else {
    $result = $student->readAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management System</title>
    <style>
        :root {
            --bg: #f8f9fa;
            --text: #212529;
            --muted: #6c757d;
            --card: #ffffff;
            --border: #dee2e6;
            --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);

            --primary: #0d6efd;
            --warning: #ffc107;
            --danger: #dc3545;
            --secondary: #6c757d;
            --dark: #212529;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            color: var(--text);
            background: var(--bg);
        }

        /* Layout helpers (Bootstrap-like) */
        .bg-light { background: var(--bg); }
        .container { width: min(100% - 2rem, 1100px); margin-inline: auto; }
        .mt-5 { margin-top: 3rem; }

        .d-flex { display: flex; }
        .justify-content-between { justify-content: space-between; }
        .align-items-center { align-items: center; }
        .mb-4 { margin-bottom: 1.5rem; }

        /* Buttons */
        .btn {
            display: inline-block;
            text-align: center;
            padding: 0.6rem 0.9rem;
            border-radius: 0.375rem;
            border: 1px solid transparent;
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
            user-select: none;
            line-height: 1.2;
        }
        .btn:hover { filter: brightness(0.95); }
        .btn:active { transform: translateY(1px); }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-warning { background: var(--warning); color: #111; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-secondary { background: var(--secondary); color: #fff; }
        .btn-sm { padding: 0.35rem 0.6rem; font-size: 0.875rem; }

        /* Search input */
        form { margin-bottom: 1rem; }
        .search-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        input[type="text"] {
            width: min(520px, 100%);
            padding: 0.625rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            font-size: 1rem;
            outline: none;
            background: #fff;
        }
        input[type="text"]:focus {
            border-color: rgba(13, 110, 253, 0.55);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .btn-icon {
            width: 42px;
            height: 42px;
            padding: 0;
            display: inline-grid;
            place-items: center;
            border-radius: 0.5rem;
            background: #fff;
            border-color: var(--border);
            color: var(--text);
        }
        .btn-icon svg { width: 18px; height: 18px; }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table th,
        .table td {
            padding: 0.75rem 0.85rem;
            border: 1px solid var(--border);
            vertical-align: top;
        }
        .table-bordered { border: 1px solid var(--border); }
        .table-striped tbody tr:nth-child(even) { background: #f9fbff; }

        .bg-white { background: #fff; }
        .shadow-sm { box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.08); }

        .table-dark th {
            background: var(--dark);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.12);
        }

        .text-center { text-align: center; }

        /* Make action buttons wrap nicely */
        td a.btn { margin-right: 0.35rem; margin-bottom: 0.35rem; }

        @media (max-width: 720px) {
            .d-flex { flex-direction: column; gap: 0.75rem; align-items: flex-start; }
            input[type="text"] { width: 100%; }
            /* On small screens, let icon reveal the input */
            .search-bar.collapsed input[type="text"] { display: none; }
        }
    </style>

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Student List</h2>
        <a href="add_student.php" class="btn btn-primary">Add New Student</a>
    </div>
    <form method="GET">
        <div class="search-bar" id="searchBar">
            <input
                type="text"
                id="searchInput"
                name="search"
                placeholder="Search by name or course"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            >
            <button type="submit" class="btn btn-icon" aria-label="Search">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M16.5 16.5 21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </form>
    <table class="table table-bordered table-striped bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?> 
                <?php while ($row = $result->fetch_assoc()): ?> 
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['course']; ?></td>
                        <td>
                            <!-- We will add edit/delete functionality next -->
                            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    (function () {
        var searchBar = document.getElementById('searchBar');
        var searchInput = document.getElementById('searchInput');

        function applyCollapsedState() {
            if (!searchBar || !searchInput) return;
            if (window.innerWidth <= 720 && !searchInput.value) {
                searchBar.classList.add('collapsed');
            } else {
                searchBar.classList.remove('collapsed');
            }
        }

        if (searchBar) {
            searchBar.addEventListener('click', function (e) {
                if (!searchBar.classList.contains('collapsed')) return;
                e.preventDefault();
                searchBar.classList.remove('collapsed');
                if (searchInput) searchInput.focus();
            });
        }

        window.addEventListener('resize', applyCollapsedState);
        applyCollapsedState();
    })();
</script>

</body>
</html>
