<head>
    <title>TrainSkill-กิจกรรมของคุณ</title>
</head>
<?php
$searchInput = isset($_GET['q']) ? $_GET['q'] : null;
$courses = [];

if (isset($_SESSION['timestamp'])) {
    $user_id = $_SESSION['user_id'];

    if ($searchInput) {
        $result = searchCoursesWithSingleInput($searchInput);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['user_id'] == $user_id) {
                    $courses[] = $row;
                }
            }
        }
    } else {
        $courses = getCourseByUserId($user_id);
    }
?>
    <div class="container mt-4 content">
        <?php if ($searchInput): ?>
            <h1>ผลการค้นหา: <?= htmlspecialchars($searchInput) ?></h1>
        <?php endif; ?>

        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $activity): ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-2 d-flex align-items-center">
                            <?php
                            $imageData = base64_encode($activity['image1']);
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" class="img-fluid rounded-start" alt="กิจกรรม">';
                            ?>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title">ชื่อกิจกรรม: <?= $activity['course_name'] ?></h5>
                                <p class="card-text">ผู้สร้าง: <?= $activity['user_name'] ?></p>
                                <p class="card-text">รายละเอียด: <?= $activity['description'] ?></p>
                                <p class="card-text">จำกัดจำนวน: <?= $activity['max'] ?> คน</p>
                                <a href="/course_participant?id=<?= $activity['course_id'] ?>" class="btn btn-info">ดูผู้เข้าร่วม</a>
                                <a href="/course_edit?id=<?= $activity['course_id'] ?>" class="btn btn-primary">แก้ไข</a>
                                <a href="/course_delete?id=<?= $activity['course_id'] ?>" class="btn btn-danger" onclick="return confirmDelete()">ลบ</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>ไม่พบกิจกรรมที่ตรงกับเงื่อนไข</p>
        <?php endif; ?>
    </div>

<?php
} else {
?>
    <div class="container text-center mt-5">
        <?= header('Location: /login') ?>
    </div>
<?php

}
