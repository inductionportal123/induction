<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FGEI (C/G) - Recruitment</title>

    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZJVRV1CL4V"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-ZJVRV1CL4V');
    </script>

    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        .blinking-text {
            animation: blink 3s infinite;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Navbar -->
        <nav class="flex justify-center mb-8">
            <a href="index.php">
                <img src="images/logo.png" alt="FGEI Logo" class="w-48">
            </a>
        </nav>

        <!-- Main Content -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-blue-900 mb-4">Welcome to FGEI (C/G) Job Portal</h1>
            <p class="text-gray-700 text-lg">
                Join FGEI and contribute to creating an unparalleled educational system that empowers students to achieve independence, confidence, and academic success.
            </p>
        </div>

        <!-- Pop-up Modal -->
        <div id="instructionsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg w-full max-w-2xl p-6 overflow-y-auto max-h-screen">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-blue-900">Important Instructions</h2>
                    <span id="closeModal" class="text-3xl cursor-pointer">&times;</span>
                </div>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Roll number slips will be available at the portal on <strong>18 February 2025</strong>.</li>
                    <li>Candidates who want to change their test center are requested to call <strong>150-4252080</strong> by <strong>17 February 2025, at 1800 hrs</strong>. No changes will be made after the due date.</li>
                    <li>Candidates who submitted their fee before <strong>10 February 2025</strong>, but were unable to submit their application are requested to call us at <strong>051-4252080</strong> by <strong>17 February 2025, at 1800 hrs</strong>.</li>
                    <li>The test will be conducted on <strong>23 February 2025</strong>.</li>
                    <li>Print and bring the roll number slip along with your original CNIC and Bank Deposit Slip to the examination hall.</li>
                    <li>Bring your own writing material and clipboard.</li>
                    <li>No mobile phones, smartwatches, gadgets, or bags are allowed inside the examination hall. No collection point will be available.</li>
                    <li>Candidates reporting after the reporting time will not be allowed to appear in the examination.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Show the modal on page load
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("instructionsModal");
            modal.classList.remove("hidden");

            // Close modal when the close button is clicked
            const closeModal = document.getElementById("closeModal");
            closeModal.addEventListener("click", () => {
                modal.classList.add("hidden");
            });

            // Close modal when clicking outside the modal
            window.addEventListener("click", (event) => {
                if (event.target === modal) {
                    modal.classList.add("hidden");
                }
            });
        });
    </script>
</body>
</html>