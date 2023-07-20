<!DOCTYPE html>
<html>
<head>
    <title>Hybrid Date Scheduling</title>
</head>
<body>
    <h2>Hybrid Date Scheduling</h2>
    <form method="post">
        <label for="num_persons">Number of Persons:</label>
        <input type="number" name="num_persons" id="num_persons" min="1" value="3">
        <input type="submit" name="generate" value="Generate Schedules">
    </form>
    
 <?php
    function get_random_weekday() {
        $weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        return $weekdays[array_rand($weekdays)];
    }

    function generate_hybrid_dates($start_date, $num_weeks, $other_person_dates) {
        $hybrid_dates = array();
        $current_date = new DateTime($start_date);
        for ($i = 0; $i < $num_weeks; $i++) {
            while (true) {
                $weekday = get_random_weekday();
                $hybrid_date = clone $current_date;
                $hybrid_date->modify("next " . $weekday);
                $hybrid_date_str = $hybrid_date->format("Y-m-d");
                if (!in_array($hybrid_date_str, $hybrid_dates) && !in_array($hybrid_date_str, $other_person_dates)) {
                    break;
                }
            }
            $hybrid_dates[] = $hybrid_date_str;
            $current_date->modify("+1 week");
        }
        return $hybrid_dates;
    }

    if (isset($_POST['generate'])) {
        $num_persons = intval($_POST['num_persons']);
        $start_date = '2023-08-01';  // Tuesday, August 1, 2023
        $num_weeks = 10;

        $all_hybrid_dates = array();
        for ($person_num = 1; $person_num <= $num_persons; $person_num++) {
            $other_person_dates = array();
            foreach ($all_hybrid_dates as $hybrid_dates) {
                $other_person_dates = array_merge($other_person_dates, $hybrid_dates);
            }
            $hybrid_dates = generate_hybrid_dates($start_date, $num_weeks, $other_person_dates);
            $all_hybrid_dates[] = $hybrid_dates;
            echo "<h3>Person {$person_num}'s Hybrid Dates:</h3>";
            echo implode(', ', $hybrid_dates) . "<br><br>";
        }
    }
    ?>

</body>
</html>
