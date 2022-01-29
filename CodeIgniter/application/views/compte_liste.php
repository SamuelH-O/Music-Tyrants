<h1><?php echo $titre;?></h1><!-- inactif -->
<br />

<?php 
    if($pseudos != NULL) {
        foreach($pseudos as $login){
            echo "<br />";
            echo " -- ";
            echo $login["cpt_pseudo"];
            echo " -- ";
            echo "<br />";
        }
    }
    else {echo "<br />";
    echo "Aucun compte !";
    }
?>
