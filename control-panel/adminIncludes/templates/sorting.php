<?php
        echo '<div class="row" id="sorting-container">';
          echo '<div class="col-xs-12 col-6">';
            echo '<i class="fas fa-sort"></i> Sorting type :';
            echo '<select>';
              foreach($sortingDirArray as $sort){
                echo "<option value='?sort=". $sort ."'>". $sort ."</option> ";
              }
            echo '</select>';
          echo '</div>';
          echo '<div class="col-xs-12 col-6">';
            echo '<i class="fas fa-sort-amount-up"></i> Sorting by :';
            echo '<select>';
              foreach($sortingByArray as $sort){
                echo "<option value='?sort=". $sortDir ."&by=". $sort ."'>". $sort ."</option>";
              }
            echo '</select>';
          echo '</div>';
        echo '</div>';
