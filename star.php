<?php
error_reporting(0);
include "jio_creds.php";
$ASUR = jitendraunatti();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "JIOTV+  " . $ASUR['hname']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $ASUR['himg']; ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: black;
        }
        .channels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px
        }
        .channel {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .channel:hover {
            transform: translateY(-5px);
        }
        .channel img {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }
        .channel-info {
            text-align: center;
        }
        .channel-info h2 {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }
        .channel-info p {
            margin: 5px 0;
            color: #666;
        }
        .channel-info a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .channel-info a:hover {
            background-color: #0056b3;
        }
        .filter {
            margin-bottom: 20px;
        }
        .filter select {
            padding: 8px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <center>

<div class="channels">
<?php
$fileContent = file_get_contents($ASUR['star']);

$lines = explode("\n", $fileContent);

foreach ($lines as $line) {
    if (strpos($line, "#EXTINF") === 0) {
        preg_match('/tvg-id="([^"]+)".*tvg-name="([^"]+)".*tvg-logo="([^"]+)".*group-title="([^"]+)",([^ ]+) (.*)/', $line, $matches);
        $tvgId = $matches[1];
        $tvgname = $matches[2];
        $logo = $matches[3];
        $groupTitle = $matches[4];
        $nameAndStreamUrl = $matches[5];

        echo '<div class="channel">';
        echo '<img src="' . $logo . '" alt="' . $tvgname . ' Logo">';
        echo '<div class="channel-info">';
        echo '<h2>' . $tvgname . '</h2>'; 
        echo '<a href="pplay.php?id=' . $tvgId . '" target="">Watch Now</a>';
        echo '</div>';
        echo '</div>';
          }
    }

?>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const languageSelect = document.getElementById("language");
        const typeSelect = document.getElementById("type");
        const channels = document.querySelectorAll(".channel");

        languageSelect.addEventListener("change", filterChannels);
        typeSelect.addEventListener("change", filterChannels);

        function filterChannels() {
            const selectedLanguage = languageSelect.value;
            const selectedType = typeSelect.value;

            channels.forEach(function(channel) {
                const channelLanguage = channel.getAttribute("data-language");
                const channelType = channel.getAttribute("data-type");

                if ((selectedLanguage === "" || channelLanguage === selectedLanguage) &&
                    (selectedType === "" || channelType === selectedType)) {
                    channel.style.display = "block";
                } else {
                    channel.style.display = "none";
                }
            });
        }
    });
</script>
</center>
</body>
</html>



        