<?php function draw_give() { 
/**
 * Draws the give form.
 *
 */ 
?>
<body id ="giveaPet">
        
        <div class= "formGiveAPet">
            
            <form id="givePetId" action="../actions/action_give.php" method="post" enctype="multipart/form-data">
                <h3> Give a Pet </h3>
                <div id = "cameraName">
                <i class="fas fa-paw"></i>
                <label for="petName"> Name</label>
                <input id="petName" name="petName" type="text" placeholder="Name, Race (undefined)" required>
                <i class="fas fa-camera-retro"></i>
                <input type="file" id="petPhoto" name="petPhoto"  accept =".jpeg,.jpg,.png,.gif" required hidden>
                <label for="petPhoto" id ="selector">Upload a Photo</label><br> 
                </div>
                <div id = "clocky">
                <i class="far fa-clock"></i>
                <label for="petAge"> Age</label>
            </div>
            <input id="petAge" name="petAge" type="text" placeholder="X years Y months" required>
            <div>
                <i class="fas fa-map-marker-alt"></i>
                <label for="petCity"> City</label>
                </div>
                <input id="petCity" name ="petCity" type="text" placeholder="City/Country" required><br>
               
                <div class="petSpecies">
                    <i class=""></i>
                    <label for="petSpecies"> Species</label>
                    <input id ="petSpeciesDog" name="petSpecies" type="radio" value="dog" >
                    <label for="petSpeciesDog" class="config-select">Dog</label>
                    <input id ="petSpeciesCat" name="petSpecies" type="radio" value="cat" checked>
                    <label for="petSpeciesCat" class="config-select">Cat</label>
                    <input id= "petSpeciesPig" name="petSpecies" type="radio" value="pig" >
                    <label for="petSpeciesPig" class="config-select">Pig</label>
                    <input id= "petSpeciesOtherAnimals" name="petSpecies" type="radio" value="other animals" >
                    <label for="petSpeciesOtherAnimals" class="config-select">Other animals</label><br>
                </div>  
                <div class="petSize">
                    <i class="fas fa-weight-hanging"></i>
                    <label for="petSize"> Size</label>
                    <input id ="petSizeSmall" name="petSize" type="radio" value="small" >
                    <label for="petSizeSmall" class="config-select">Small</label>
                    <input id ="petSizeMedium" name="petSize" type="radio" value="medium" >
                    <label for="petSizeMedium" class="config-select">Medium</label>
                    <input id= "petSizeBig" name="petSize" type="radio" value="big" checked>
                    <label for="petSizeBig" class="config-select">Big</label><br>
                </div>
                
                <div class="petSex">
                    <i class="fas fa-venus-mars"></i>
                    <label for="petSex"> Sex</label>
                        <input id ="petSexMale" name="petSex" type="radio" value="male" checked>
                        <label for="petSexMale" class="config-select">Male</label>
                        <input id ="petSexFemale" name="petSex" type="radio" value="female" >
                        <label for="petSexFemale" class="config-select">Female</label>
                </div>
                <p><?php if(isset($_SESSION['give_error'])) echo "<span class='give_error'>" . $_SESSION['give_error'] . "</span>";?></p>
                <?php
                    unset($_SESSION['give_error']);
                ?>
                <footer>
                    <button type="submit" name="submit">Submit</button>
                </footer>
                
            </form>
    </div>
</body>

<?php } ?>