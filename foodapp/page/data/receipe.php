<?php
    if(isset($_POST['search'])){
        $recipe = $_POST['recipe'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.edamam.com/api/recipes/v2?q=' . $recipe . '&app_id=c4dba69c&app_key=5d5e06574582e5b414ab660f13e06279&type=public',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => 'CURL_HTTP_VERSION_1_1',
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: route=222fc2df52ebc04b5a35043498fc068c'
            ),
        ));

    $response = curl_exec($curl);

    curl_close($curl);
    $data = json_decode($response);
    
    }
?>

<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <h1 class="text-center">Recipe Database</h1>
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="recipe">
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary btn-lg btn-custom-search" name="search">Search recipe</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <?php
            if (empty($data->hits)){
                echo '<div class="col md-12">
                <div class="alert alert-danger">
                    No data
                </div>
            </div>';
            } else { ?>

            <?php foreach($data->hits as $recipeResult) { 
                    $source = str_replace(" ", "",$recipeResult->recipe->source);
                ?>
        <div class="col-md-3 mt-5">
            <div class="card shadow-lg content-card">
                <div class="card-body">
                    <div class="card-title text-center">
                        <img src="<?php echo $recipeResult->recipe->image ?>" alt="" class="img-fluid">
                    </div>
                    <div class="text-brand">
                        <?php echo $recipeResult->recipe->label ?>
                    </div>
                    <div class="card-text">

                        <div class="text-right btn-section">
                            <button type="button" class="btn btn-detail-custom" data-toggle="modal" data-target="#detail<?php echo $source ?>">Detail</button>
                        </div>

                        <!-- Modal -->
                            <div class="modal fade" id="detail<?php echo $source ?>" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $recipeResult->recipe->label ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-detail text-info">Health Label</div>
                                        <?php foreach($recipeResult->recipe->healthLabels as $health) {?>
                                            <span class="badge badge-primary"><?php echo $health ?></span>
                                            <?php }?>

                                            <div class="text-detail text-info">
                                                Ingredients
                                            </div>

                                            <div class="row">
                                                <?php foreach($recipeResult->recipe->ingredients as $ingredient) { ?>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="card-title">
                                                                    <img src="<?php echo $ingredient->image ?>" alt="image" class="img-fluid">
                                                                </div>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        Quantity: <?php echo $ingredient->quantity ?>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        Measure: <?php echo $ingredient->measure ?>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        Food: <?php echo $ingredient->food ?>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        Weight: <?php echo $ingredient->weight ?>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        Kategori: <?php echo $ingredient->foodCategory ?>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }?>
                                            </div>
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