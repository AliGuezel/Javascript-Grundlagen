<?php
  error_reporting(0);
  $headers = getallheaders();
  if ($headers['Content-Type'] == "application/json") {
    function dbAufbau () {
      $db = new mysqli('localhost', 'root', '', 'personal');
      if ($db->connect_error) {
        die('Fehler bei der Datenbankverbindung: ' . $db->connect_error);
      }
      if (!$db->set_charset('utf8')) {
        echo 'Fehler beim setzten von UTF-8';
      }
      return $db;
    }
    $db = dbAufbau ();
    $sendData = file_get_contents("php://input");
    $daten = json_decode($sendData, true);
  
    $aktion = $daten['aktion'] ?? 'doNothing';
  
    switch ($aktion) {

      case 'delete':
        $id = $daten['id'] ?? 0;
        if ($id > 0) {
          $statement = $db->prepare("UPDATE angestellte SET deleted = 1 WHERE id = ?");
          $statement->bind_param('i', $id);
          if ($statement->execute()) echo 'ok';
          else echo 'Fehler beim löschen der Daten';
        }
        break;
      
      case 'laden':
        $statement = $db->prepare("SELECT id, vorname, nachname, anrede, UNIX_TIMESTAMP(geburtsdatum) AS geb FROM angestellte WHERE deleted != 1");
        $statement->execute();
        $ergebnis = $statement->get_result();
        $ausgabe = '{"Angestellte" : {';
  
        while ($person = $ergebnis->fetch_assoc()) {
          $ausgabe .= ' "' . ( substr('000' . $person['id'], -4) ). '" : ';
          $ausgabe .= ($person['anrede'] == 1) ? '{"anrede" : "Frau",' : '{"anrede" : "Herr",';
          $ausgabe .= '"vorname" : "' . $person['vorname'] . '",';
          $ausgabe .= '"nachname" : "' . $person['nachname'] . '",';
          $ausgabe .= '"geburtsdatum" : "' . date('d.m.Y', $person['geb']) . '"},';
        } 
        $ausgabe = rtrim($ausgabe, ',') . '}}';
        echo $ausgabe;
        break;

        case 'new':
          $anrede = $daten['anrede'] ?? 0;
          $vorname = $daten['vorname'] ?? '';
          $nachname = $daten['nachname'] ?? '';
          $gebdat = $daten['gebdat'] ?? '';
          $statement = $db->prepare("INSERT INTO angestellte (anrede, vorname, nachname, geburtsdatum) VALUES (?, ?, ?, ?)");
          $statement->bind_param('isss', $anrede, $vorname, $nachname, $gebdat);
          if ($statement->execute()) echo 'ok';
          else echo 'Fehler beim Anlegen eines neuen Datensatzes';
          break;
      case 'new':
        $anrede = $daten['anrede'] ?? 0;
        $vorname = $daten['vorname'] ?? '';
        $nachname = $daten['nachname'] ?? '';
        $gebdat = $daten['gebdat'] ?? '';
        $statement = $db->prepare("INSERT INTO angestellte (anrede, vorname, nachname, geburtsdatum) VALUES (?, ?, ?, ?)");
        $statement->bind_param('isss', $anrede, $vorname, $nachname, $gebdat);
        if ($statement->execute()) echo 'ok';
        else echo 'Fehler beim Anlegen eines neuen Datensatzes';
        break;
      
      case 'update':
          $pId =  $daten['pId'] ?? 0;
          $anrede = $daten['anrede'] ?? 0;
          $vorname = $daten['vorname'] ?? '';
          $nachname = $daten['nachname'] ?? '';
          $gebdat = $daten['gebdat'] ?? '';
          $statement = $db->prepare("UPDATE angestellte SET anrede = ?, vorname = ?, nachname = ?, geburtsdatum = ? WHERE id = ?");
          $statement->bind_param('isssi', $anrede, $vorname, $nachname, $gebdat, $pId);
          if ($statement->execute()) echo 'ok';
          else echo 'Fehler beim Aktualisieren eines Datensatzes';
          break;
  
        default:
        echo 'Can not do ' . $aktion;
      }
  } else {
    echo 'Ungültiger Aufruf der Datei';
  }

  
