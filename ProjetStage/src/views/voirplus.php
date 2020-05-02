<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';

head();
?>
    <div class="container">
        <div class="arr_plan row justify-content-center">
            <h1 class="text-center titre">Nom du café</h1>
                <div class="row justify-content-between">
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3">
                        <img src="../../public/img/cafe-vrac.png" class="panneau w-100 bg-light rounded" alt="...">
                        <div class="d-flex justify-content-between mt-3">
                            <p><span>Pays:</span><span class="p-2 m-1 rounded bg-wheat font-weight-bold">Honduras</span></p>
                            <p><span>Type :</span><span class="p-2 m-1 rounded bg-light font-weight-bold">En grain</span></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                        <div class="d-flex justify-content-between mb-3 ">
                            <img src="../../public/img/deca.png" class="w-25">
                            <img src="../../public/img/bio.png" class="w-50">
                        </div>
                        <div class="bg-marron2 p-3 rounded">
                                <h5 class="card-title">Un café fort en goût</h5>
                                <p class="card-text">

                                    Aenean pharetra orci id vehicula efficitur. Nam euismod, neque quis pharetra luctus, felis sapien
                                    vestibulum erat, vel porta orci turpis et mi. Ut vel mauris vitae orci fermentum elementum.
                                    In efficitur, velit ac luctus eleifend, arcu massa lobortis erat, sed luctus libero odio eget orci.
                                    Nunc non velit mi. Suspendisse quis pulvinar lectus. Vestibulum blandit risus id risus consequat, a efficitur ex tempor.
                                    Vestibulum aliquet ullamcorper velit a efficitur. </p>
                        </div>
                        <div class="card-footer rounded mb-3">
                            <p>Prix:<span class="font-weight-bold p-2">25€</span> le sachet d'1kg<p>
                        </div>
                        <form method="post" action="panier.php" class="d-flex justify-content-between">
                            <div class="d-flex">
                                <label for="quantite" class="mr-2 col-form-label">Qté:</label>
                                <input type="number" name="quantite" id="quantite" class=" form-control w-25">
                            </div>
                            <button type="submit" class="btn btn-marron">Ajouter au panier</button>
                        </form>

                            </div>
                        </div>
                </div>
                    </div>

                </div>
        </div>
    </div>
<?php
footer();
