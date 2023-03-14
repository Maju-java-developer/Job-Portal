<?php
    $get_companies = get_companies();
    ?>
    <div class="container-fluid">
        <div class='row'>
        <?php
            foreach($get_companies as $company){
                $image  = "images/". $company[3];
                ?>
                    <div class="col-md-3">
                        <article class="card mt-2 mb-2">
                            <div class="ml-3">
                            <img src="<?php echo $image?>" class="w-50 mt-2" lt="Sample photo">
                            <h3><?php echo $company[1]?></h3>
                            <p><?php echo $company[2]?></p>
                            <button class=" btn bg-dark text-light rounded-lg mb-2 " style="width: 97%;">Details</button>
                            </div>
                        </article>
                    </div>

                <?php
            }
        ?>
        </div>
    </div>
    <?php
  