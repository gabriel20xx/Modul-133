<?php include_once 'includes/connect-db.php';
include 'includes/date.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aufgabe 1</title>
</head>
<body>
    <form action="functions/get-method.php", method="get">
        <!-- ein einzeiliges Textfeld mit der Beschriftung „Name“ -->
        <label for="name">Name</label><br>
        <input type="text" id="name" name="name"><br>

        <!-- ein einzeiliges Textfeld mit der Beschriftung „Personalnummer“ -->
        <label for="personalnummer">Personalnummer</label><br>
        <input type="text" id="personalnummer" name="personalnummer"><br>

        <!--  ein einzeiliges Textfeld mit der Beschriftung „Mailadresse“ -->
        <label for="mailadresse">Mailadresse</label><br>
        <input type="text" id="mailadresse" name="mailadresse"><br>

        <!--  ein mehrzeiliges (5 Zeilen) Textfeld mit der Bezeichnung „Kommentar“ -->
        <label for="kommentar">Kommentar</label><br>
        <textarea name="kommentar", rows="5"></textarea><br>
        <label for="passwort">Passwort</label><br>
        <input type="password" id="passwort" name="passwort"><br>

        <!--  ein Optionsblock (Radiobutton) mit den Optionen „öffentlich“, „schulintern“, „Klasse“ und „privat“ –privat ist default! -->
        <input type="radio" id="oeffentlich" name="privacy" value="oeffentlich">
        <label for="oeffentlich">öffentlich</label><br>
        <input type="radio" id="schulintern" name="privacy" value="schulintern">
        <label for="schulintern">schulintern</label><br>
        <input type="radio" id="klasse" name="privacy" value="klasse">
        <label for="klasse">Klasse</label><br>
        <input type="radio" id="privat" name="privacy" value="privat" checked>
        <label for="privat">Privat</label><br>
        
        <!--# ein Optionsblock (Radiobutton) mit den Optionen „öffentlich“, „schulintern“, „Klasse“ und „privat“ –privat ist default!-->
        <fieldset>
            <legend>Berufsrichtung</legend>
        
            <div>
              <input type="checkbox" id="AI" name="AI" checked>
              <label for="AI">Applikationsentwickler</label>
            </div>
        
            <div>
              <input type="checkbox" id="ST" name="ST">
              <label for="ST">Systemtechniker</label>
            </div>

            <div>
              <input type="checkbox" id="BI" name="BI">
              <label for="BI">Betriebsinformatiker</label>
            </div>

            <div>
              <input type="checkbox" id="IP" name="IP">
              <label for="IP">Informatikpraktikant</label>
            </div>
        </fieldset>

        <p>Erfasst von: </p>
        <input type="radio" id="BI20c" name="class" value="BI20c">
        <label for="BI20c">BI20c</label><br>
        <input type="radio" id="BI20d" name="class" value="BI20d">
        <label for="BI20d">BI20d</label><br>
        <input type="radio" id="other" name="class" value="other">
        <label for="other">Other: </label>
        <textarea name="other", rows="1" ></textarea><br>
      
        <!-- Ein Button mit der Beschriftung „Ausgabe“, der ein alert-Window mit den im Teil 2 definierten Angaben ausgibt. -->
        <button type="button" onclick="ausgabe()">Ausgabe</button><br>

       <?php 
          $date = Datum();
          echo '<p>' . $date . '</p>';
        ?>

    </form>
</body>
</html>
