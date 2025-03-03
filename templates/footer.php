<?php
if (isset($_SESSION['timestamp'])) {
?>
    <footer class="bg-dark text-light text-center py-3 mt-4">
        <p>&copy; <?= date('Y') ?> My Awesome Website</p>
    </footer>
<?php
} else
?>

</body>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
            var currentPath = window.location.pathname; // ดึง URL ปัจจุบัน
            var navLinks = document.querySelectorAll(".nav-link"); // ค้นหาเมนูทั้งหมด

            navLinks.forEach(link => {
                if (link.getAttribute("href") === currentPath) {
                    link.classList.add("active");
                }
                });
            });

            function confirmDelete() {
                return confirm("คุณแน่ใจแล้วใช่ไหมที่จะลบกิจกรรมนี้?");
            }

            function confirmAlright() {
                return confirm("คุณแน่ใจแล้วใช่ไหมที่จะกดยอมรับ?");
            }

            function confirmReject() {
                return confirm("คุณแน่ใจแล้วใช่ไหมที่จะกดปฏิเสธ?");
            }
        </script>

</html>