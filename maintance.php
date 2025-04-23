<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Under Maintenance</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #3498db, #8e44ad);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin: 0;
        }
        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .container p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .countdown div {
            background: #fff;
            color: #3498db;
            padding: 15px;
            border-radius: 10px;
            font-size: 2em;
            min-width: 60px;
            text-align: center;
        }
        .countdown div span {
            display: block;
            font-size: 0.5em;
            color: #8e44ad;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Portal Opening Soon</h1>
        <p><strong>The portal will be available on July 28, 2024 at 6:45 PM.</strong></p>
        <h2>Time Remaining:</h2>
        <div class="countdown" id="countdown">
            <div><span>Days</span></div>
            <div><span>Hours</span></div>
            <div><span>Minutes</span></div>
            <div><span>Seconds</span></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Set the date and time for the portal opening
        var countDownDate = new Date("Jul 28, 2024 18:45:00").getTime();

        // Update the countdown every 1 second
        var countdownFunction = setInterval(function() {
            // Get the current date and time
            var now = new Date().getTime();
            
            // Calculate the distance between now and the countdown date
            var distance = countDownDate - now;
            
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Display the result in the countdown divs
            document.querySelector("#countdown div:nth-child(1)").innerHTML = days + "<span>Days</span>";
            document.querySelector("#countdown div:nth-child(2)").innerHTML = hours + "<span>Hours</span>";
            document.querySelector("#countdown div:nth-child(3)").innerHTML = minutes + "<span>Minutes</span>";
            document.querySelector("#countdown div:nth-child(4)").innerHTML = seconds + "<span>Seconds</span>";
            
            // If the countdown is over, write some text 
            if (distance < 0) {
                clearInterval(countdownFunction);
                document.querySelector("#countdown").innerHTML = "<div>The portal is now open!</div>";
            }
        }, 1000);
    </script>
</body>
</html>
