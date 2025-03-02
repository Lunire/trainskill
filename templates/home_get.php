<?php

if (isset($_SESSION['timestamp'])) {
    $courses = $data['courses'];
?>

    <head>
        <title>TrainSkill-รายการกิจกรรม</title>
    </head>
    <div class="container mt-4">
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
                            <a href="/course?id=<?= $activity['course_id'] ?>" class="btn btn-primary">รายละเอียด</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php
} else {
?>
    <div class="container text-center mt-5">
        <?= header('Location: /login') ?>
    </div>
<?php

}
