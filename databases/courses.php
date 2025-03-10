<?php

function getCourses(): mysqli_result|bool
{
    $conn = getConnection();
    $sql = '
        SELECT c.*, u.user_name 
        FROM courses c
        INNER JOIN users u ON c.user_id = u.user_id
    ';
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result;
}

function getCourseById(int $course_id): mysqli_result|bool
{
    $conn = getConnection();
    $sql = '
        SELECT c.*, u.user_name 
        FROM courses c
        INNER JOIN users u ON c.user_id = u.user_id
        WHERE c.course_id = ?
    ';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $course_id);
    $stmt->execute();
    
    $result = $stmt->get_result();

    return $result;
}

function getCourseByUserId(int $user_id): mysqli_result|bool
{
    $conn = getConnection();
    $sql = '
        SELECT c.*, u.user_name 
        FROM courses c
        INNER JOIN users u ON c.user_id = u.user_id
        WHERE c.user_id = ?
    ';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();

    return $result;
}

function createCourse(String $courseName, String $description, int $max, String $startDate, String $endDate, int $userId): bool
{
    $conn = getConnection();
    $sql = '
        INSERT INTO courses (course_name, description, max, start_date, end_date, user_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisss', $courseName, $description, $max, $startDate, $endDate, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function editCourse(int $course_id, string $course_name, string $description, int $max, string $start_date, string $end_date,): bool
{
    $conn = getConnection();
    $sql = '
        UPDATE courses
        SET course_name = ?, description = ?, max = ?, start_date = ?, end_date = ?
        WHERE course_id = ?
    ';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisss', $course_name, $description, $max, $start_date, $end_date, $course_id);
    $result = $stmt->execute();

    return $result;
}

function deleteCourse(int $course_id): bool
{
    $conn = getConnection();
    $sql = '
        DELETE FROM courses
        WHERE course_id = ?
    ';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $course_id);
    $result = $stmt->execute();

    return $result;
}

function searchCoursesWithSingleInput(string $searchInput): mysqli_result|bool
{
    $conn = getConnection();

    // แยกข้อความและวันที่จาก input
    $parts = explode(' ', $searchInput);
    $course_name = '';
    $search_date = null;

    foreach ($parts as $part) {
        // ตรวจสอบว่าส่วนนี้เป็นวันที่หรือไม่ (รูปแบบ YYYY/MM/DD)
        if (preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $part)) {
            $search_date = $part;
        } else {
            $course_name .= $part . ' ';
        }
    }

    // ลบช่องว่างส่วนเกิน
    $course_name = trim($course_name);

    // สร้าง SQL query
    $sql = '
        SELECT c.*, u.user_name 
        FROM courses c
        INNER JOIN users u ON c.user_id = u.user_id
        WHERE 1=1
    ';

    $params = [];
    $types = '';

    // เพิ่มเงื่อนไขชื่อคอร์ส
    if (!empty($course_name)) {
        $sql .= ' AND c.course_name LIKE ?';
        $params[] = "%$course_name%";
        $types .= 's';
    }

    // เพิ่มเงื่อนไขวันที่
    if (!empty($search_date)) {
        $sql .= ' AND ? BETWEEN c.start_date AND c.end_date';
        $params[] = $search_date;
        $types .= 's';
    }

    // เตรียมและ execute query
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}