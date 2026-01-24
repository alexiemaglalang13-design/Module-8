<!--Maglalang, Alexie T. | WD 201-->
<?php
date_default_timezone_set("Asia/Manila");
require 'includes/header.php';

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

$localFlights = [
    ["flightNo" => "DG 6241", "airline" => "CRK | Philippine Airlines", "from" => "Clark", "to" => "Manila", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2025-12-25 06:30", "duration" => 60],
    ["flightNo" => "5J 501", "airline" => "MNL | Cebu Pacific", "from" => "Manila", "to" => "Cebu", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-02-01 10:00", "duration" => 75],
    ["flightNo" => "PR 1020", "airline" => "DVO | Air Asia", "from" => "Davao", "to" => "Palawan", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-01-01 08:15", "duration" => 100],
    ["flightNo" => "5J 611", "airline" => "CRK | Cebu Pacific", "from" => "Clark", "to" => "Boracay", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-05-14 12:30", "duration" => 80],
    ["flightNo" => "PR 502", "airline" => "PPS | Philippine Airlines", "from" => "Palawan", "to" => "Manila", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2027-03-14 15:00", "duration" => 90]
];

$foreignFlights = [
    ["flightNo" => "PR 1013", "airline" => "ANA | Japan Airlines", "from" => "Manila", "to" => "Tokyo", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Tokyo", "dep" => "2026-06-13 09:00", "duration" => 130],
    ["flightNo" => "5J 019", "airline" => "SIN | Singapore Air", "from" => "Cebu", "to" => "Singapore", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Singapore", "dep" => "2026-01-10 11:20", "duration" => 270],
    ["flightNo" => "EK 473", "airline" => "DXB | Emirates", "from" => "Clark", "to" => "Dubai", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Dubai", "dep" => "2025-11-01 18:00", "duration" => 185],
    ["flightNo" => "QF 389", "airline" => "SYD | Qantas", "from" => "Manila", "to" => "Sydney", "originTZ" => "Asia/Manila", "destTZ" => "Australia/Sydney", "dep" => "2026-03-13 20:10", "duration" => 440],
    ["flightNo" => "KE 850", "airline" => "IIA | Korean Air", "from" => "Davao", "to" => "Busan", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Seoul", "dep" => "2026-09-01 13:15", "duration" => 105]
];

function flightTime($dep, $tz, $duration){
    $origin = new DateTime($dep, new DateTimeZone($tz));
    $arrival = (clone $origin)->modify("+{$duration} minutes");
    $diff = $origin->diff($arrival);

    return [
        "dep" => $origin->format("M d, Y | h:i A"),
        "arr" => $arrival->format("M d, Y | h:i A"),
        "dur" => $diff->format("%h hr %i min")
    ];
}

function flightStatus($dep, $tz){
    $now = new DateTime("now", new DateTimeZone($tz));
    $flight = new DateTime($dep, new DateTimeZone($tz));
    $sec = $now->getTimestamp() - $flight->getTimestamp();

    if ($sec < -1800) return "ON TIME";
    if ($sec <= 0) return "BOARDING";
    return "DEPARTED";
}

function renderFlightCard($flight, $placeImages){
    $time = flightTime($flight["dep"], $flight["originTZ"], $flight["duration"]);
    $status = flightStatus($flight["dep"], $flight["originTZ"]);
    $class = strtolower(str_replace(" ", "-", $status));
    ?>
    <div class="flight-row">
        <div class="card">
            <img src="img/<?= $placeImages[$flight["from"]]; ?>" alt="<?= $flight["from"]; ?>">
            <span class="status-circle <?= $class; ?>"><?= $status; ?></span>
            <div class="content">
                <div class="place-row">
                    <h3><?= $flight["from"]; ?></h3>
                    <span class="badge"><?= $flight["airline"]; ?></span>
                </div>
                <p><strong>Flight No:</strong> <?= $flight["flightNo"]; ?></p>
                <p><strong>Departure:</strong> <?= $time["dep"]; ?></p>
                <p><strong>Timezone:</strong> <?= $flight["originTZ"]; ?></p>
            </div>
        </div>

        <div class="arrow">✈</div>

        <div class="card">
            <img src="img/<?= $placeImages[$flight["to"]]; ?>" alt="<?= $flight["to"]; ?>">
            <div class="content">
                <div class="place-row">
                    <h3><?= $flight["to"]; ?></h3>
                    <span class="badge"><?= $flight["airline"]; ?></span>
                </div>
                <p><strong>Arrival:</strong> <?= $time["arr"]; ?></p>
                <p><strong>Duration:</strong> <?= $time["dur"]; ?></p>
                <p><strong>Timezone:</strong> <?= $flight["destTZ"]; ?></p>
            </div>
        </div>
    </div>
    <?php
}
?>

<main>
    <section class="section-title">Domestic Flights</section>
    <div class="card-container">
        <?php foreach ($localFlights as $flight) renderFlightCard($flight, $placeImages); ?>
    </div>

    <section class="section-title">International Flights</section>
    <div class="card-container">
        <?php foreach ($foreignFlights as $flight) renderFlightCard($flight, $placeImages); ?>
    </div>

    <section class="section-title">Other Timezones</section>
    <div class="world-time">
        <?php
        $zones = ["America/New_York" => "New York", "Europe/London" => "London", "Asia/Tokyo" => "Tokyo"];
        foreach ($zones as $tz => $city) {
            echo "<div class='time-card'><h3>$city</h3><p>" . (new DateTime("now", new DateTimeZone($tz)))->format("h:i A") . "</p></div>";
        }
        ?>
    </div>
</main>

<?php require 'includes/footer.php'; ?>
