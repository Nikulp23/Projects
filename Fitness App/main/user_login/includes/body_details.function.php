<?php

function buildMenu() {
	// construct the menu, setting the current menu item 'selected' if 
	// we are on the page that matches the URL
	$menuOutput = '<ul id="menu">';
	foreach ($menu as $key => $value) {
		if($_SERVER['PHP_SELF'] == "$key.php") {
			$selected = ' class="selected"';
		} else {
			$selected = '';
		}
		$menuOutput .= '<li' . $selected . '><a href="' . $key . '.php" title="' . $value . '">' . $value . '</a></li>';
	}
	$menuOutput .= '</ul>';
  return $menuOutput;
}


function calculate_bmi($height, $weight) {
    $height_m = $height / 100;
    $bmi = $weight / ($height_m * $height_m);
    $bmi = round($bmi, 2);
    return $bmi;
  }
  
  function calculate_bmr($gender, $weight, $height, $age) {
      $height_m = $height / 100;
      if ($gender == "Male") {
          $bmr = 88.36 + (13.4 * $weight) + (4.8 * $height_m) - (5.7 * $age);
      } elseif ($gender == "Female") {
          $bmr = 447.6 + (9.2 * $weight) + (3.1 * $height_m) - (4.3 * $age);
      } else {
          $bmr = 0;
      }
      return number_format($bmr, 2);
  }


function calculate_body_fat_percentage($gender, $weight, $height, $age) {
    
    $bmi = calculate_bmi($height, $weight);

    
    if ($gender == "Male") {
        $body_fat_percentage = 1.20 * $bmi + 0.23 * $age - 16.2;
    } else {
        $body_fat_percentage = 1.20 * $bmi + 0.23 * $age - 5.4;
    }

    return number_format($body_fat_percentage, 2);
}

function calculate_lbm($gender, $weight, $body_fat) {
    if ($gender == "Male") {
        $lbm = (1.082 * $weight) - (4.15 * $body_fat) + 94.42;
    } elseif ($gender == "Female") {
        $lbm = (0.732 * $weight) - (4.15 * $body_fat) + 8.987;
    } else {
        $lbm = 0;
    }
    return number_format($lbm, 2);
}

function calculate_tbw($gender, $weight, $height, $age) {
    if ($gender == "Male") {
        $tbw = (2.447 - (0.09145 * $age) + (0.1074 * $height) + (0.3362 * $weight)) / 100;
    } elseif ($gender == "Female") {
        $tbw = (2.097 - (0.1069 * $age) + (0.2466 * $height) + (0.2466 * $weight)) / 100;
    } else {
        $tbw = 0;
    }
    return number_format($tbw, 2);
}


?>