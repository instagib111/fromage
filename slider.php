<div class="row hidden-xs">
  <div class="col-xs-12 col-md-push-1 col-md-10 col-lg-push-2 col-lg-8">
    <div id="carousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php 
          $d = $conn->prepare("SELECT id_fromage, image, description, nom FROM produits WHERE slider = 1");
          $d->execute();
          $r = $d->fetchAll();
          $i = 0;
          foreach ($r as $key => $value) {
            if ($i == 0)
              echo "<li data-target='#carousel' data-slide-to='". $i ."' class='dot active'></li>";
            else 
              echo "<li data-target='#carousel' data-slide-to='". $i ."' class='dot'></li>";
            $i++;
          }
          $i = 0;
        ?>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <?php
          foreach ($r as $key => $value) {
            if ($i == 0)
              echo "<div class='item col-xs-12 active'>";
            else 
              echo "<div class='item col-xs-12'>";

            echo "  <div class='lnkSlider' data-value='". $value['id_fromage'] ."' >
                      <div class='carDivImg col-xs-6'>
                        <img class='carouselImg' src='" . $value['image'] . "' alt='". $value['nom'] ."'/>
                      </div>
                      <div class='col-xs-5'>
                        <h3 class='col-xs-12'>".$value['nom']."</h3>
                        <span class='text col-xs-12'>". $value['description'] ."</span>
                      </div>
                    </div>
                  </div>";
              $i++;
          }
        ?>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
  <form id="hiddenForm" action="" method="post">
    <input id="hiddenAttr" name="id" type="hidden">
  </form>
	<script src="cont/js/slider.js"></script>
</div>
