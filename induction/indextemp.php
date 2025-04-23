<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment Portal 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', 'Roboto', sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            margin: 0;
            padding: 0;
        }
        .glassmorph {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(229, 231, 235, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .glow-hover:hover {
            box-shadow: 0 0 20px rgba(79, 70, 229, 0.5);
            transform: translateY(-5px);
        }
        .modal {
            display: none; /* Changed from hidden class to explicit display for clarity */
            position: fixed;
            inset: 0;
            z-index: 50;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal.show {
            display: flex; /* Show modal when 'show' class is added */
        }
        .modal-animate {
            animation: modalPop 0.5s ease-out forwards;
        }
        @keyframes modalPop {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        #wave-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
        }
        @keyframes pulseSlow {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .animate-pulse-slow {
            animation: pulseSlow 2s infinite;
        }
    </style>
</head>
<body class="min-h-screen text-gray-800">
    <!-- Wave Background -->
    <canvas id="wave-background"></canvas>

    <div class="container mx-auto px-6 py-12 relative z-10">
        <!-- Navigation -->
        <nav class="flex justify-center mb-12">
            <a href="index.php" class="relative">
                <img src="images/logo.png" alt="FGEI Logo" class="h-24 transition-transform duration-500 logo-anim">
            </a>
        </nav>

        <!-- Result Modal -->
        <div id="resultModal" class="modal bg-gradient-to-br from-gray-900/90 to-indigo-900/90">
            <div class="glassmorph rounded-3xl p-8 max-w-lg w-full shadow-2xl modal-animate border border-indigo-300/50 relative overflow-hidden">
                <span class="close float-right text-4xl font-bold cursor-pointer text-gray-600 hover:text-indigo-700 transition-colors duration-200">×</span>
                <h2 class="text-3xl font-extrabold text-indigo-900 mb-6 tracking-tight flex items-center">
                    <i class="ri-megaphone-line text-3xl mr-3 text-indigo-600"></i>
                    EST Induction 2025 Update
                </h2>
                <p class="text-gray-700 leading-relaxed text-lg">
                    The test of EST Induction 2025 was conducted on <span class="font-semibold bg-indigo-100 px-2 py-1 rounded">23rd February 2025</span>. The result is finalized and uploaded on <span class="font-semibold bg-indigo-100 px-2 py-1 rounded">24th March 2025</span>. Results are now live!<br><br>
                    <span class="flex items-center">
                        <i class="ri-file-list-3-line text-2xl text-indigo-600 mr-3"></i>
                        Search your result here: 
                        <a href="result_search.php" target="_blank" class="ml-2 text-indigo-600 font-semibold bg-indigo-50 px-3 py-1 rounded-full hover:bg-indigo-100 transition-all duration-300">Results FGEI</a>
                    </span><br>
                    Interviews commence from <span class="font-semibold bg-indigo-100 px-2 py-1 rounded">8th April 2025</span>.
                </p>
                <button class="mt-8 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white px-8 py-3 rounded-full hover:from-indigo-700 hover:to-indigo-900 transition-all duration-300 w-full font-semibold text-lg shadow-md close">Close</button>
            </div>
        </div>

        <!-- Instructions Modal -->
        <div id="instructionsModal" class="modal bg-gray-800/60">
            <div class="glassmorph rounded-3xl p-8 max-w-lg w-full shadow-xl modal-animate border border-indigo-200/50 relative glow-hover">
                <span class="close float-right text-4xl font-bold cursor-pointer text-gray-500 hover:text-indigo-600 transition-colors duration-300">×</span>
                <h1 class="text-3xl font-extrabold text-indigo-900 mb-6 tracking-tight">Important Instructions</h1>
                <ul class="list-none pl-0 text-gray-700 text-base space-y-4">
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Review eligibility criteria before applying.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Fill form with accurate details.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Match details to matriculation certificate.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Enter SEQ/account number for challan.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Upload challan with bank receipts.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Submit after agreeing to Undertaking.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Profile locks post-submission.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Check portal for updates.</li>
                    <li class="flex items-start"><i class="ri-checkbox-circle-line text-indigo-500 mr-2 mt-1"></i> Verify data—FGEI not liable for errors.</li>
                </ul>
            </div>
        </div>

        <!-- Interview Schedule Modal -->
        <div id="interviewScheduleModal" class="modal bg-gray-800/60">
            <div class="glassmorph rounded-3xl p-8 max-w-lg w-full shadow-xl modal-animate border border-indigo-200/50 relative glow-hover">
                <span class="close float-right text-4xl font-bold cursor-pointer text-gray-500 hover:text-indigo-600 transition-colors duration-300">×</span>
                <h1 class="text-3xl font-extrabold text-indigo-900 mb-6 tracking-tight flex items-center">
                    <i class="ri-calendar-check-line text-3xl mr-3 text-indigo-600"></i>
                    Interview Schedule 2025
                </h1>
                <div>
                    <h2 class="text-xl font-semibold text-indigo-800 mb-4">Induction of Teaching Staff - 2025</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-indigo-100">
                                    <th class="border border-indigo-200 px-4 py-2 text-indigo-900 font-semibold">Station</th>
                                    <th class="border border-indigo-200 px-4 py-2 text-indigo-900 font-semibold">Date/Day</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="border border-indigo-200 px-4 py-2 text-gray-700">Rawalpindi</td><td class="border border-indigo-200 px-4 py-2 text-gray-700">08 - 15 Apr 2025</td></tr>
                                <tr><td class="border border-indigo-200 px-4 py-2 text-gray-700">Multan</td><td class="border border-indigo-200 px-4 py-2 text-gray-700">21 - 25 Apr 2025</td></tr>
                                <tr><td class="border border-indigo-200 px-4 py-2 text-gray-700">Karachi</td><td class="border border-indigo-200 px-4 py-2 text-gray-700">30 Apr - 03 May 2025</td></tr>
                                <tr><td class="border border-indigo-200 px-4 py-2 text-gray-700">Quetta</td><td class="border border-indigo-200 px-4 py-2 text-gray-700">05 May 2025</td></tr>
                                <tr><td class="border border-indigo-200 px-4 py-2 text-gray-700">Peshawar</td><td class="border border-indigo-200 px-4 py-2 text-gray-700">12 - 14 May 2025</td></tr>
                                <tr><td class="border border-indigo-200 px-4 py-2 text-gray-700">Lahore</td><td class="border border-indigo-200 px-4 py-2 text-gray-700">19 - 23 May 2025</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="mt-8 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white px-8 py-3 rounded-full hover:from-indigo-700 hover:to-indigo-900 transition-all duration-300 w-full font-semibold text-lg shadow-md close">Close</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-900 mb-4 tracking-tight drop-shadow-md title-anim">FGEI (C/G) Job Portal</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed drop-shadow-sm subtitle-anim">Empower education—nurturing independence, confidence, and excellence.</p>
        </div>

        <!-- Alert -->
        <div class="glassmorph border-l-4 border-indigo-400 text-indigo-800 p-4 rounded-r-xl mb-12 flex items-center justify-center shadow-md glow-hover">
            <i class="ri-information-line text-2xl mr-3 text-indigo-500"></i>
            <p class="text-base">Results available: <span class="font-semibold bg-indigo-100 px-3 py-1 rounded-full text-indigo-800">24th March 2025</span></p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="glassmorph p-6 rounded-xl shadow-md flex items-center justify-center stat-card">
                <i class="ri-earth-line text-4xl text-indigo-500 mr-4"></i>
                <div>
                    <h4 class="text-xl font-semibold text-indigo-900">Cities: <span class="counter" data-target="54">0</span></h4>
                </div>
            </div>
            <div class="glassmorph p-6 rounded-xl shadow-md flex items-center justify-center stat-card">
                <i class="ri-government-line text-4xl text-indigo-500 mr-4"></i>
                <div>
                    <h4 class="text-xl font-semibold text-indigo-900">Institutions: <span class="counter" data-target="358">0</span></h4>
                </div>
            </div>
            <div class="glassmorph p-6 rounded-xl shadow-md flex items-center justify-center stat-card">
                <i class="ri-team-line text-4xl text-indigo-500 mr-4"></i>
                <div>
                    <h4 class="text-xl font-semibold text-indigo-900">Employees: <span class="counter" data-target="12000">0</span>+</h4>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <a href="Advertisement-2025.pdf" target="_blank" class="group card-anim">
                <div class="glassmorph p-6 rounded-xl shadow-md text-center">
                    <i class="ri-advertisement-line text-5xl text-indigo-500 mb-4"></i>
                    <p class="text-base font-medium text-gray-700">Advertisement</p>
                </div>
            </a>
            <div id="instructionsLink" class="group card-anim cursor-pointer">
                <div class="glassmorph p-6 rounded-xl shadow-md text-center">
                    <i class="ri-book-open-line text-5xl text-indigo-500 mb-4"></i>
                    <p class="text-base font-medium text-gray-700">Instructions</p>
                </div>
            </div>
            <a href="#" target="_blank" class="group card-anim">
                <div class="glassmorph p-6 rounded-xl shadow-md text-center">
                    <i class="ri-file-text-line text-5xl text-indigo-500 mb-4"></i>
                    <p class="text-base font-medium text-gray-700">Syllabus</p>
                </div>
            </a>
            <a href="result_search.php" target="_blank" class="group relative card-anim">
                <div class="glassmorph p-6 rounded-xl shadow-md text-center bg-gradient-to-br from-indigo-100 to-indigo-50 border-2 border-indigo-400 animate-pulse-slow">
                    <span class="absolute -top-3 -right-3 bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">New</span>
                    <i class="ri-file-list-3-line text-5xl text-indigo-600 mb-4"></i>
                    <p class="text-base font-semibold text-indigo-800">Results</p>
                </div>
            </a>
            <div id="interviewScheduleLink" class="group relative card-anim cursor-pointer">
                <div class="glassmorph p-6 rounded-xl shadow-md text-center bg-gradient-to-br from-indigo-100 to-indigo-50 border-2 border-indigo-400 animate-pulse-slow">
                    <span class="absolute -top-3 -right-3 bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">New</span>
                    <i class="ri-calendar-check-line text-5xl text-indigo-600 mb-4"></i>
                    <p class="text-base font-semibold text-indigo-800">Interview Schedule</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Wave Background
        const canvas = document.getElementById('wave-background');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let time = 0;
        const waves = [
            { amplitude: 50, frequency: 0.02, speed: 0.05, color: 'rgba(79, 70, 229, 0.2)' },
            { amplitude: 30, frequency: 0.03, speed: 0.07, color: 'rgba(99, 102, 241, 0.2)' }
        ];

        function drawWaves() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            time += 0.02;

            waves.forEach(wave => {
                ctx.beginPath();
                ctx.fillStyle = wave.color;

                for (let x = 0; x < canvas.width; x++) {
                    const y = canvas.height / 2 + wave.amplitude * Math.sin(wave.frequency * x + time * wave.speed);
                    ctx.lineTo(x, y);
                }

                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.closePath();
                ctx.fill();
            });

            requestAnimationFrame(drawWaves);
        }
        drawWaves();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        // Modal Handlers
        const resultModal = document.getElementById("resultModal");
        const instructionsModal = document.getElementById("instructionsModal");
        const interviewScheduleModal = document.getElementById("interviewScheduleModal");
        const instructionsLink = document.getElementById("instructionsLink");
        const interviewScheduleLink = document.getElementById("interviewScheduleLink");

        // Show Result Modal on page load
        window.onload = () => {
            resultModal.classList.add("show");
            gsap.from(resultModal.querySelector(".glassmorph"), { scale: 0.9, opacity: 0, duration: 0.5, ease: "power2.out" });
        };

        // Close Modals
        document.querySelectorAll(".close").forEach(el => {
            el.addEventListener("click", () => {
                const modal = el.closest(".modal");
                gsap.to(modal.querySelector(".glassmorph"), { scale: 0.9, opacity: 0, duration: 0.5, ease: "power2.in", onComplete: () => modal.classList.remove("show") });
            });
        });

        // Open Instructions Modal
        instructionsLink.addEventListener("click", () => {
            instructionsModal.classList.add("show");
            gsap.from(instructionsModal.querySelector(".glassmorph"), { scale: 0.9, opacity: 0, duration: 0.5, ease: "power2.out" });
        });

        // Open Interview Schedule Modal
        interviewScheduleLink.addEventListener("click", () => {
            interviewScheduleModal.classList.add("show");
            gsap.from(interviewScheduleModal.querySelector(".glassmorph"), { scale: 0.9, opacity: 0, duration: 0.5, ease: "power2.out" });
        });

        // Close Modal on Background Click
        document.querySelectorAll(".modal").forEach(modal => {
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    gsap.to(modal.querySelector(".glassmorph"), { scale: 0.9, opacity: 0, duration: 0.5, ease: "power2.in", onComplete: () => modal.classList.remove("show") });
                }
            });
        });

        // GSAP Animations
        gsap.from(".logo-anim", { y: -100, opacity: 0, duration: 1.5, ease: "elastic.out(1, 0.5)" });
        gsap.from(".title-anim", { scale: 0.8, opacity: 0, duration: 1, delay: 0.5, ease: "power2.out" });
        gsap.from(".subtitle-anim", { y: 20, opacity: 0, duration: 1, delay: 1, ease: "power2.out" });
        gsap.from(".stat-card", { y: 50, opacity: 0, stagger: 0.3, duration: 1, delay: 1.5, ease: "back.out(1.7)" });
        gsap.from(".card-anim", { scale: 0.9, opacity: 0, stagger: 0.2, duration: 0.8, delay: 2, ease: "elastic.out(1, 0.8)" });

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            gsap.to(counter, {
                innerText: target,
                duration: 2,
                snap: { innerText: 1 },
                ease: "power1.out",
                scrollTrigger: {
                    trigger: counter,
                    start: "top 80%",
                }
            });
        });
    </script>
</body>
</html>