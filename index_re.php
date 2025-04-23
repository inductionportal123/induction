<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Induction Portal FGEI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            font-family: 'Arial', sans-serif;
            text-align: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .content {
            max-width: 600px;
            padding: 20px;
            border-radius: 15px;
            background: rgba(0, 0, 0, 0.3);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .countdown {
            display: flex;
            justify-content: space-around;
            gap: 10px;
            font-size: 1.5rem;
            margin-top: 20px;
        }
        .countdown div {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Induction Portal FGEI</h1>
        <p>The portal will be live soon! Stay tuned.</p>
        <div id="countdown" class="countdown">
            <div><span id="days">0</span> Days</div>
            <div><span id="hours">0</span> Hours</div>
            <div><span id="minutes">0</span> Minutes</div>
            <div><span id="seconds">0</span> Seconds</div>
        </div>
    </div>

    <script>
        const targetDate = new Date('2025-01-19T00:00:00'); // Corrected date format: February 19, 2025

        function updateCountdown() {
            const now = new Date();
            const difference = targetDate - now;

            if (difference <= 0) {
                document.getElementById('countdown').innerHTML = '<div>Portal is now live!</div>';
                return;
            }

            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
