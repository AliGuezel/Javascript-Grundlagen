<?php
  
  $bildnummer = $_GET['bildnummer'] ?? 0;

  switch ($bildnummer) {
    case 1:
      echo "Bild einer Katze";
      break;
    case 2:
      echo "Bild eines Hundes";
      break;
    case 3:
      echo "Bild von Meerschweinchen";
      break;
    case 4:
      echo "Bild eines Vogels";
  }
?>