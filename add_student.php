<?php
include "config/database.php";
include "classes/student.php";

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);

if($_SERVER['REQUEST_METHOD']=='POST'){
  $student->name = $_POST['name'];
  $student->email = $_POST['email'];
  $student->course = $_POST['course'];

  if($student->create()){
    header("location:index.php");
  }else{
    echo "Something went wrong";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <style>
        :root {
            --bg: #f8f9fa;
            --text: #212529;
            --muted: #6c757d;
            --card: #ffffff;
            --border: #dee2e6;
            --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);

            --primary: #0d6efd;
            --success: #198754;
            --secondary: #6c757d;
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
        .container { width: min(100% - 2rem, 960px); margin-inline: auto; }
        .mt-5 { margin-top: 3rem; }
        .row { display: flex; flex-wrap: wrap; margin: -0.75rem; }
        .justify-content-center { justify-content: center; }
        .col-md-6 { width: 100%; padding: 0.75rem; max-width: 540px; }

        /* Card */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .shadow { box-shadow: var(--shadow); }
        .card-header { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); }
        .card-body { padding: 1.25rem; }

        .bg-primary { background: var(--primary); }
        .text-white { color: #fff; }
        .mb-0 { margin-bottom: 0; }

        /* Form */
        .mb-3 { margin-bottom: 1rem; }
        .form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; }
        .form-control {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            font-size: 1rem;
            outline: none;
            background: #fff;
        }
        .form-control:focus {
            border-color: rgba(13, 110, 253, 0.55);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        /* Buttons */
        .d-grid { display: grid; }
        .gap-2 { gap: 0.5rem; }
        .btn {
            display: inline-block;
            text-align: center;
            padding: 0.625rem 0.9rem;
            border-radius: 0.375rem;
            border: 1px solid transparent;
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
            user-select: none;
        }
        .btn-success { background: var(--success); color: #fff; }
        .btn-secondary { background: var(--secondary); color: #fff; }
        .btn:hover { filter: brightness(0.95); }
        .btn:active { transform: translateY(1px); }

        /* Small screen spacing */
        @media (max-width: 480px) {
            .container { width: min(100% - 1.25rem, 960px); }
            .card-body { padding: 1rem; }
        }
    </style>

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Student</h4>
                </div>
                <div class="card-body">

                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="Enter full name">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <input type="text" name="course" class="form-control" required placeholder="e.g. Computer Science">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Save Student</button>
                            <a href="index.php" class="btn btn-secondary">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>