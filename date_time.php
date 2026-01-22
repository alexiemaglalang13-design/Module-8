<!--Maglalang, Alexie T. | WD 201-->
<?php
date_default_timezone_set("Asia/Manila");

$places = [
    "Clark" => ["country" => "Philippines", "desc" => "Major gateway in Central Luzon."],
    "Manila" => ["country" => "Philippines", "desc" => "Capital city and main gateway."],
    "Cebu" => ["country" => "Philippines", "desc" => "Economic and tourism hub."],
    "Palawan" => ["country" => "Philippines", "desc" => "Archipelago composed of main island and more than 1,700 islands"],
    "Tokyo" => ["country" => "Japan", "desc" => "Capital of Japan."],
    "Singapore" => ["country" => "Singapore", "desc" => "Global aviation hub."],
    "Dubai" => ["country" => "UAE", "desc" => "Major Middle East hub."],
    "Sydney" => ["country" => "Australia", "desc" => "Largest city in Australia."],
    "Busan" => ["country" => "Korea", "desc" => "Major port city of Korea."],
    "Davao" => ["country" => "Philippines", "desc" => "Largest city in Mindanao."],
    "Boracay" => ["country" => "Philippines", "desc" => "Island famous for its powdery white sand, clear turquoise waters, and stunning sunsets."]
];

$placeImages = [
    "Clark" => "clark.jpg",
    "Manila" => "manila.jpg",
    "Cebu" => "cebu.jpg",
    "Palawan" => "palawan.jpg",
    "Tokyo" => "tokyo.jpg",
    "Singapore" => "singapore.jpg",
    "Dubai" => "dubai.jpg",
    "Sydney" => "sydney.jpg",
    "Busan" => "busan.jpg",
    "Davao" => "davao.jpg",
    "Boracay" => "boracay.jpg"
];

$domestic = [
    ["Clark", "Manila", "06:30", "07:50"],
    ["Davao", "Palawan", "08:15", "09:40"],
    ["Manila", "Cebu", "10:00", "11:20"],
    ["Clark", "Boracay", "12:30", "13:50"],
    ["Palawan", "Manila", "15:00", "16:20"]
];

$international = [
    ["Manila", "Tokyo", "09:00", "14:30"],
    ["Cebu", "Singapore", "11:20", "14:10"],
    ["Clark", "Dubai", "18:00", "22:45"],
    ["Manila", "Sydney", "20:10", "06:30"],
    ["Davao", "Busan", "13:15", "18:20"]
];

function shortText($text, $limit = 60) {
    return strlen($text) > $limit ? substr($text, 0, $limit) . "..." : $text;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Flight Schedules</title>

<style>
    html { font-size: 62.5%; }

    body {
        margin: 0;
        background: #ECEFF1;
        font-family: "Segoe UI", Arial, sans-serif;
        color: #222;
    }

    .header {
        max-width: 1280px;
        margin: 20px auto;
        padding: 22px 26px;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 14px;
        color: #fff;
        box-shadow: 0 6px 18px rgba(0,0,0,.25);
    }

    .header h1 {
        font-size: 3.2rem;
        margin: 0;
        letter-spacing: .5px;
    }

    .time-box {
        font-size: 1.5rem;
        background: rgba(0,0,0,.35);
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 500;
    }

    .section-title {
        max-width: 1280px;
        margin: 40px auto 15px;
        font-size: 2.4rem;
        font-weight: 700;
        letter-spacing: .4px;
        border-left: 6px solid #2c5364;
        padding-left: 12px;
    }

    .card-container {
        max-width: 1280px;
        margin: auto;
        padding: 10px;
    }

    .flight-row {
        display: flex;
        align-items: center;
        margin-bottom: 26px;
        background: #fff;
        border-radius: 14px;
        padding: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,.08);
    }

    .card {
        width: 45%;
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 18px rgba(0,0,0,.12);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(0,0,0,.18);
    }

    .card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .content {
        padding: 16px;
    }

    .content h3 {
        font-size: 2.1rem;
        margin: 0 0 6px;
        letter-spacing: .3px;
    }

    .content p {
        font-size: 1.4rem;
        color: #555;
        margin: 4px 0;
    }

    .content strong {
        color: #2c5364;
    }

    .arrow {
        width: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.8rem;
        color: #2c5364;
    }

    .world-time {
        max-width: 1280px;
        margin: 50px auto;
        display: flex;
        gap: 20px;
    }

    .time-card {
        flex: 1;
        background: #fff;
        padding: 22px;
        text-align: center;
        border-radius: 14px;
        box-shadow: 0 6px 16px rgba(0,0,0,.1);
    }

    .time-card h3 {
        font-size: 2rem;
        margin-bottom: 8px;
        letter-spacing: .3px;
    }

    .time-card p {
        font-size: 1.6rem;
        font-weight: 600;
    }

    .time {
        font-size: 1.6rem;
        color: #222;
        font-weight: 600;
        margin-top: 4px;
    }

    footer {
        background: #0f2027;
        color: #fff;
        text-align: center;
        padding: 22px;
        font-size: 1.3rem;
        letter-spacing: .3px;
    }
</style>

</head>

<body>
<div class="header">
    <h1>✈ Flight Schedules</h1>
    <div class="time-box">
        <?= date("l, F j, Y | h:i:s A"); ?> (PH)
    </div>
</div>

<!-- Domestic Flights -->
<div class="section-title">Domestic Flights</div>
<div class="card-container">

<?php foreach ($domestic as $flight): ?>
<div class="flight-row">

    <div class="card">
        <img src="images/<?= $placeImages[$flight[0]]; ?>" alt="<?= $flight[0]; ?>">
        <div class="content">
            <h3><?= $flight[0]; ?></h3>
            <p><strong>Departure:</strong> <?= $flight[0]; ?>, <?= $places[$flight[0]]["country"]; ?></p>
            <p class="time"><strong>Time:</strong> <?= $flight[2]; ?></p>
            <p><?= shortText($places[$flight[0]]["desc"]); ?></p>
        </div>
    </div>

    <div class="arrow">✈</div>

    <div class="card">
        <img src="images/<?= $placeImages[$flight[1]]; ?>" alt="<?= $flight[1]; ?>">
        <div class="content">
            <h3><?= $flight[1]; ?></h3>
            <p><strong>Arrival:</strong> <?= $flight[1]; ?>, <?= $places[$flight[1]]["country"]; ?></p>
            <p class="time"><strong>Time:</strong> <?= $flight[3]; ?></p>
            <p><?= shortText($places[$flight[1]]["desc"]); ?></p>
        </div>
    </div>

</div>
<?php endforeach; ?>

</div>

<!-- International Flights-->
<div class="section-title">International Flights</div>
<div class="card-container">

<?php foreach ($international as $flight): ?>
<div class="flight-row">

    <div class="card">
        <img src="images/<?= $placeImages[$flight[0]]; ?>" alt="<?= $flight[0]; ?>">
        <div class="content">
            <h3><?= strtoupper($flight[0]); ?></h3>
            <p><strong>Departure:</strong> <?= $flight[0]; ?>, <?= $places[$flight[0]]["country"]; ?></p>
            <p class="time"><strong>Time:</strong> <?= $flight[2]; ?></p>
            <p><?= shortText($places[$flight[0]]["desc"]); ?></p>
        </div>
    </div>

    <div class="arrow">✈</div>

    <div class="card">
        <img src="images/<?= $placeImages[$flight[1]]; ?>" alt="<?= $flight[1]; ?>">
        <div class="content">
            <h3><?= strtoupper($flight[1]); ?></h3>
            <p><strong>Arrival:</strong> <?= $flight[1]; ?>, <?= $places[$flight[1]]["country"]; ?></p>
            <p class="time"><strong>Time:</strong> <?= $flight[3]; ?></p>
            <p><?= shortText($places[$flight[1]]["desc"]); ?></p>
        </div>
    </div>

</div>
<?php endforeach; ?>

</div>

<div class="section-title">Time Zones</div>
<div class="world-time">
    <div class="time-card">
        <h3>New York</h3>
        <p><?= date("h:i A", time() - 13 * 3600); ?></p>
    </div>
    <div class="time-card">
        <h3>London</h3>
        <p><?= date("h:i A", time() - 8 * 3600); ?></p>
    </div>
    <div class="time-card">
        <h3>Tokyo</h3>
        <p><?= date("h:i A", time() + 1 * 3600); ?></p>
    </div>
</div>

<footer>
    © <?= date("Y"); ?> Maglalang - Philippine Flight Schedule System
</footer>

</body>
</html>