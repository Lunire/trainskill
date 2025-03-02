<?php
$searchInput = isset($_GET['q']) ? $_GET['q'] : null;
$courses = [];

if ($searchInput) {
    // ค้นหากิจกรรม
    $result = searchCoursesWithSingleInput($searchInput);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
    }
} else {
    // หากไม่มีการค้นหา ให้ดึงข้อมูลกิจกรรมทั้งหมด
    $courses = $data['courses']; // ข้อมูลกิจกรรมทั้งหมดจาก $data
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1; /* ดัน footer ไปด้านล่าง */
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['timestamp'])) {
    ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Home</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="/course_create">Create an activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="/course_own">Your activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="/profile">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="/history">History</a></li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" name="q" placeholder="ค้นหากิจกรรม">
                        <button class="btn btn-outline-light" type="submit">ค้นหา</button>
                    </form>
                    <button class="btn btn-outline-light ms-2">
                        <a href="/logout" class="text-light text-decoration-none">Sign out</a>
                    </button>
                </div>
            </div>
        </nav>
    <?php
    }
    ?>