<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNIC Roll No Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZJVRV1CL4V"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZJVRV1CL4V');
</script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-2xl rounded-xl p-8 w-full max-w-md transition-transform transform hover:scale-105 animate-fadeIn">
        
        <!-- Logo -->
        <div class="flex justify-center mb-5">
            <a href="index.php">
                <img src="images/logo.png" alt="Logo" class="w-32 md:w-40 transition-transform transform hover:scale-110">
            </a>
        </div>

        <h2 class="text-2xl font-extrabold text-center text-gray-800">🔍 Search Roll No Slip</h2>
        <p class="text-center text-gray-500 text-sm mb-5">Enter your CNIC below to retrieve your Roll No Slip.</p>

        <!-- Form -->
        <form id="cnicForm" action="newsearch_roll_no.php" method="GET">
            <div class="relative">
                <input type="text" id="cnic" name="cnic" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-lg pr-10"
                    placeholder="XXXXX-XXXXXXX-X" required>
                <button type="button" id="clearCnic" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 hidden">
                    ✖
                </button>
            </div>

            <p id="error-message" class="text-red-500 text-sm text-center mt-2 hidden">⚠️ Invalid CNIC format!</p>

            <button type="submit"
                class="w-full bg-blue-500 text-white font-bold p-3 rounded-lg mt-4 transition-all duration-300 hover:bg-blue-600 hover:shadow-lg">
                🔎 Search
            </button>
        </form>

        <!-- Result Display -->
        <?php
        if (isset($_GET['cnic'])) {
            $cnic = $_GET['cnic'];
            $cnic_clean = str_replace("-", "", $cnic);

            if (preg_match('/^\d{13}$/', $cnic_clean)) {
                echo "<div class='mt-6 text-center text-gray-800 font-semibold bg-green-100 p-4 rounded-lg shadow-sm'>";
                echo "<p class='text-lg'>✅ Roll No: <span class='text-blue-700'>$cnic_clean</span></p>";
                echo "</div>";
            } else {
                echo "<div class='mt-6 text-center text-red-600 font-semibold bg-red-100 p-4 rounded-lg shadow-sm'>";
                echo "<p>⚠️ Invalid CNIC format! Please try again.</p>";
                echo "</div>";
            }
        }
        ?>
    </div>

    <script>
        $(document).ready(function() {
            $("#cnic").inputmask("99999-9999999-9"); // Apply mask

            $("#cnicForm").submit(function(e) {
                let cnicValue = $("#cnic").val().replace(/-/g, "");

                if (!/^\d{13}$/.test(cnicValue)) { 
                    $("#error-message").removeClass("hidden");
                    e.preventDefault();
                } else {
                    $("#error-message").addClass("hidden");
                }
            });

            // Show clear button when typing
            $("#cnic").on("input", function() {
                if ($(this).val().length > 0) {
                    $("#clearCnic").removeClass("hidden");
                } else {
                    $("#clearCnic").addClass("hidden");
                }
            });

            // Clear input field
            $("#clearCnic").on("click", function() {
                $("#cnic").val("").focus();
                $(this).addClass("hidden");
            });
        });
    </script>

</body>
</html>
