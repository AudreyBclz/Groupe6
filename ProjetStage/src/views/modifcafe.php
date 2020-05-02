<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
head();
?>
<div class="container">
    <div class="arr_plan justify-content-center">
        <h1 class="text-center titre">Admin: Modification Café</h1>
        <form method="post" action="ajoutcafe.php" enctype="multipart/form-data">
            <div class="row justify-content-between">
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div >
                        <label for="nomCafe" class="col-form-label">Nom du Café :</label>
                        <input type="text" name="nomCafe" id="nomCafe" class="form-control ">
                    </div>
                    <div>
                        <label for="paysCafe" class="col-form-label">Provenance :</label>
                        <input type="text" name="paysCafe" id="paysCafe" class="form-control ">
                    </div>
                    <div>
                        <label for="type" class="labelcafe col-form-label">Type :</label>
                        <select name="type" id="type" class="form-control w-50">
                            <option value="En grain">En grain</option>
                            <option value="Moulu">Moulu</option>
                        </select>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                            <label for="decaffeine" class="mr-3 col-form-label">Décafféiné :</label>
                            <input type="checkbox" value="Decaffeine" id="decaffeine">
                        </div>
                        <div class="form-check form-check-inline">
                            <label for="bio" class="mr-3 col-form-label">Bio :</label>
                            <input type="checkbox" value="Bio" id="bio">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="mt-3">
                            <label for="prix" class="labelcafe">Prix :</label>
                            <input type="number" name="prix" id="prix" class="form-control">
                        </div>
                        <div class="mt-3">
                            <div class="form-check form-check-inline">
                                <label for="bio" class="mr-3 col-form-label">Epuisé :</label>
                                <input type="checkbox" value="Bio" id="bio">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div>
                        <label for="resume" class="col-form-label">Résumé :</label>
                        <input type="text" name="resume" id="resume" class="form-control">
                    </div>
                    <div>
                        <label for="description" class="col-form-label">Description :</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="image" class="col-form-label">Photos :</label>
                        <input type="file" name="image" id="image" class="w-100"/>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-marron">Ajouter</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="text-center">
            <img src="../../public/img/cafe-vrac.png" class="w-25"/>
        </div>
    </div>
</div>
<?php
footer();
