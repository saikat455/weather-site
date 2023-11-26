<?php
$status = "no";
$msg = "";
$city = "";

if (isset($_POST['submit'])) {
    $city = $_POST['city'];
    $apiKey = "7655a6e78d803532eba770dcecff00cc"; // Replace with your OpenWeatherMap API key
    $url = "http://api.openweathermap.org/data/2.5/forecast?q=$city&appid=$apiKey";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result, true);

    if ($result['cod'] == "200") {
        $status = "yes";
    } else {
        $msg = $result['message'];
    }
}
?>

<html lang="en" class=" -webkit-">
<head>
    <meta charset="UTF-8">
    <title>5-Day Weather Forecast</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .form {
            text-align: center;
            padding: 20px;
        }

        .text {
            padding: 10px;
            font-size: 16px;
        }

        .submit {
            height: 39px;
            width: 100px;
            border: 0px;
            background-color: #4285f4;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .submit:hover {
            background-color: #357ae8;
        }

        .error-message {
            color: #d9534f;
            margin-top: 10px;
        }

        .forecast-container {
            margin: 20px;
            text-align: center;
        }

        .widget {
            display: inline-block;
            margin: 10px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .weatherIcon img {
            width: 60px;
            height: 60px;
            margin-top: 10px;
        }

        .temperature span {
            font-size: 24px;
            font-weight: bold;
        }

        .description {
            padding: 10px;
        }

        .weatherCondition {
            font-size: 18px;
            font-weight: bold;
        }

        .place {
            font-size: 14px;
        }

        .date {
            background-color: #4285f4;
            color: white;
            padding: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
    </style>
</head>
<body>
<div class="form">
    <form style="width:100%;" method="post">
        <input type="text" class="text" placeholder="Enter city name" name="city" value="<?php echo $city ?>"/>
        <input type="submit" value="Submit" class="submit" name="submit"/>
        <?php echo $msg ?>
    </form>
</div>

<?php if ($status == "yes") { ?>
    <div class="forecast-container">
        <h2>5-Day Weather Forecast for <?php echo $result['city']['name']; ?></h2>
        <?php foreach ($result['list'] as $forecast) { ?>
            <article class="widget">
                <div class="weatherIcon">
                    <img src="http://openweathermap.org/img/wn/<?php echo $forecast['weather'][0]['icon'] ?>@4x.png"/>
                </div>
                <div class="weatherInfo">
                    <div class="temperature">
                        <span><?php echo round($forecast['main']['temp'] - 273.15) ?>°</span>
                    </div>
                    <div class="description">
                        <div class="weatherCondition"><?php echo $forecast['weather'][0]['main'] ?></div>
                        <div class="place"><?php echo $result['city']['name'] ?></div>
                    </div>
                </div>
                <div class="date">
                    <?php echo date('d M', $forecast['dt']) ?>
                </div>
            </article>
        <?php } ?>
    </div>
<?php } ?>
</body>
</html>
