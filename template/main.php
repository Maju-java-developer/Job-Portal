<main class="container-fluid float-left">
    <div class="row w-auto">

        <div class="col-xl-3">
            <h3 class="card-title bg-dark p-2 mt-2 mb-0 text-light">Categories</h3>
            <ul class="list-group list-text-dark mb-1">
                <?php
                    $getCategories = getCategories();
                    for ($i=0; $i < sizeof($getCategories); $i++) {
                        echo "<li class='list-group-item'><a href='?page=jobCategories&Jobcat_id=". $getCategories[$i][0]."'>" . $getCategories[$i][1] . "</a></li>";
                    }
                ?>
            </ul>
        </div>

        <div class="col-xl-9">
        <?php
            include_once('template/availlabelJobs.php');
        ?>
        </div>

    </div>
</main>
