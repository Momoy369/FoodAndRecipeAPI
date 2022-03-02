<?php
    if(isset($_POST['search'])){
        $food = $_POST['food'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.edamam.com/api/food-database/v2/parser?app_id=5584c155&app_key=cb172332615d0ee83750c310c7485654&ingr=' . $food,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: route=222fc2df52ebc04b5a3504398fc068c'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response);
    }
?>

<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <h1 class="text-center">Food Database</h1>
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="food">
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button class="btn btn-secondary btn-lg btn-custom-search" type="submit" name="search">Search Receipe</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <?php
            if (empty($data->text)){
                echo '<div class="col md-12">
                <div class="alert alert-danger">
                    No data
                </div>
            </div>';
            } else { ?>

            <?php foreach($data->hints as $foodResult) { ?>
        <div class="col-md-3 mt-5">
            <div class="card shadow-lg content-card">
                <div class="card-body">
                    <div class="card-title text-center">
                        <img src="assets/img/burger.jpg" alt="" style="width:200px">
                    </div>
                    <div class="text-brand">
                        <?php echo $foodResult->food->label ?>
                    </div>
                    <div class="card-text">
                        <div class="badge-section">
                            <span class="badge badge-category"><?php echo $foodResult->food->category ?></span>
                            <span class="badge badge-category-label"><?php echo $foodResult->food->categoryLabel ?></span>
                        </div>

                        <div class="text-right btn-section">
                            <button type="button" class="btn btn-detail-custom" data-toggle="modal" data-target="#exampleModal<?php echo $foodResult->food->foodId ?>">Detail</button>
                        </div>

                        <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo $foodResult->food->foodId ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $foodResult->food->label ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-detail">
                                            Nutrisi
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item">Energy: <?php echo (empty($foodResult->food->nutrients->ENERC_KCAL)) ? 'Tidak ada data' : $foodResult->food->nutrients->ENERC_KCAL ?></li>
                                            <li class="list-group-item">Protein: <?php echo (empty($foodResult->food->nutrients->PROCNT)) ? 'Tidak ada data' : $foodResult->food->nutrients->PROCNT ?></li>
                                            <li class="list-group-item">Fat: <?php echo (empty($foodResult->food->nutrients->FAT)) ? 'Tidak ada data' : $foodResult->food->nutrients->FAT ?></li>
                                            <li class="list-group-item">Carbs: <?php echo (empty($foodResult->food->nutrients->CHOCDF)) ? 'Tidak ada data' : $foodResult->food->nutrients->CHOCDF ?></li>
                                            <li class="list-group-item">Fiber: <?php echo (empty($foodResult->food->nutrients->FIBTG)) ? 'Tidak ada data' : $foodResult->food->nutrients->FIBTG ?></li>
                                        </ul>

                                        <ul class="list-group mt-3">
                                            <li class="list-group-item">Kategori: <?php echo (empty($foodResult->food->category)) ? 'Tidak ada data' : $foodResult->food->category ?></li>
                                            <li class="list-group-item">Kategori Label: <?php echo (empty($foodResult->food->categoryLabel)) ? 'Tidak ada data' : $foodResult->food->categoryLabel ?></li>
                                            <li class="list-group-item">Food Content Label: <?php echo (empty($foodResult->food->foodContentsLabel)) ? 'Tidak ada data' : $foodResult->food->foodContentsLabel ?></li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End modal -->
                    </div>
                </div>
            </div>
        </div>
          <?php } }?>
    </div>
</div>