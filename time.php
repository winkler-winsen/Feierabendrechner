
<?php
    session_start();

    if ( isset($_GET["clear"]) ) {
        session_destroy();
        session_start();
        $_SESSION["success"] = "Alles gelöscht.";
        header( 'Location:  time.php');
        return;
    }

    if ( isset($_POST["KO"]) ) {
        $_SESSION["KO"] = $_POST["KO"];
        $_SESSION["success"] = "KO gespeichert.";
        header( 'Location: time.php' );
        return;
    }

    if ( isset($_POST["SollNetto"]) ) {
        $_SESSION["SollNetto"] = $_POST["SollNetto"];
        $_SESSION["success"] = "Soll Netto gespeichert.";
        header( 'Location: time.php' );
        return;
    }

    if ( isset($_POST["Pause"]) ) {
        $_SESSION["Pause"] = $_POST["Pause"];
        $_SESSION["success"] = "Pause gespeichert.";
        header( 'Location: time.php' );
        return;
    }
?>

<html>
<head>
  <title>Feierabendrechner</title>
  <meta http-equiv="refresh" content="60">
</head>

<body style="font-family: sans-serif;">
<h1>Feierabendrechner</h1>
<?php
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }

    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>

<!-- App start -->
       <?php
        if ( isset($_SESSION["KO"]) ) {
          $KO = date("H:i", strtotime($_SESSION["KO"]));
        } else {
          $KO = date("H:i", strtotime("08:00"));
        }
        // echo "<pre>";
        //   var_dump($_SESSION);
        // echo "</pre>";
        // var_dump($KO);

        if ( isset($_SESSION["SollNetto"]) ) {
          $sollNetto = date("H:i", strtotime($_SESSION["SollNetto"]));
        } else {
          $sollNetto = date("H:i", strtotime("07:48"));
        }
        // var_dump($sollNetto);

        if ( isset($_SESSION["Pause"]) ) {
          $pause = date("H:i", strtotime($_SESSION["Pause"]));
        } else {
          $pause = date("H:i", strtotime("00:30"));
        }
        // var_dump($pause);


        $date = date("H:i", strtotime($KO));
        // var_dump($date);

        // $soll = date("H:i", strtotime('+7 hour +48 minutes +30 minutes', strtotime($date)));
        // $soll = date("H:i", ( strtotime($sollNetto) + strtotime($pause) ));
        // $soll = date("H:i", strtotime('+'.date("H", $sollNetto).' hour +'.date("i", $sollNetto).' minutes', strtotime($date)));
        $soll = date("H:i", strtotime("+".date("H", strtotime($pause))." hour"."+".date("i", strtotime($pause))." minutes", strtotime($date)));
        $soll = date("H:i", strtotime("+".date("H", strtotime($sollNetto))." hour"."+".date("i", strtotime($sollNetto))." minutes", strtotime($soll)));

        // var_dump($soll);

        $jetzt = date("H:i");
        // var_dump($jetzt);

        $diff = date_diff(date_create($soll), date_create($jetzt));
        // $diff = date_format($diff, "H:i");
//        $diff = date_interval_format($diff, "%R%h:%i");
	      $diffSign = date_interval_format($diff, "%R");
		    $diff = date_interval_format($diff, "%H:%I");
	
//         echo "<PRE>"; var_dump($diffSign);echo "</PRE>";

        $h10 = date("H:i", strtotime($KO)+(10*60*60)+(45*60)); // add 10h + 45min;  

        $h9 = date("H:i", strtotime($KO)+(9*60*60)+(30*60)); // add 9h + 30min;
       ?>

       <!-- <form method="post">
         <p>Soll: <input type="time" name="SollNetto" value="<?php echo $sollNetto; ?>"> Stunden</p>
         <p>Pause: <input type="time" name="Pause" value="<?php echo $pause; ?>"> Stunden</p>
         <p>KO: <input type="time" name="KO" value="<?php echo $date; ?>"> Uhr</p>
         <p>GE Soll: <?php echo $soll; ?> Uhr</p>
         <p>Differenz: <?php echo $diff; ?> Stunden</p>
         <p><input type="submit" value="Eingabe"></p>
       </form> -->
     <table>
       <tr><form method="post">
         <td>Soll:</td> <td align="right"><input type="time" name="SollNetto" value="<?php echo $sollNetto; ?>"> </td><td>Stunden</td> <td><input type="submit" value="Speichern"></td>
       </form></tr>
       <tr><form method="post">
         <td>Pause:</td> <td align="right"><input type="time" name="Pause" value="<?php echo $pause; ?>"> </td><td>Stunden</td> <td><input type="submit" value="Speichern"></td>
       </form></tr>
       <tr><form method="post">
         <td>KO:</td> <td align="right"><input type="time" name="KO" autofocus="true" value="<?php echo $date; ?>"> </td><td>Uhr</td> <td><input type="submit" value="Speichern"></td>
       </form></tr>
       <tr>
<!--         <td>GE Soll:</td> <td><?php echo $soll; ?> </td><td>Uhr</td><td></td></p>
-->
         <td>GE Soll:</td> <td align="right"><input type="time" name="GESoll" disabled value="<?php echo $soll; ?>" > </td><td>Uhr</td><td></td></p>

		  </tr>
       <tr>
<!--         <td>Differenz:</td> <td><?php echo $diff; ?> </td><td>Stunden</td><td></td></p>
-->
		  <td>Differenz:</td> <td align="right"><?php echo $diffSign; ?><input type="time" name="diff" disabled value="<?php echo $diff; ?>" > </td><td>Stunden</td><td></td></p>   
       </tr>
       <tr></tr>
       <tr>
		 <td><font color="grey">9h:</font></td> <td align="right"><input type="time" name="diff" disabled value="<?php echo $h9; ?>" > </td><td><font color="grey">Uhr</font></td><td></td></p>   
       </tr>
       <tr>
		 <td><font color="grey">10h max:</font></td> <td align="right"><input type="time" name="diff" disabled value="<?php echo $h10; ?>" > </td><td><font color="grey">Uhr</font></td><td></td></p>   
       </tr>
     </table>
     <p>Eingaben <a href="time.php?clear">löschen</a>.</p>
     <!-- App end  -->

</body>
</html>
