<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
head();
?>
<div class="container">
    <div class="arr_plan">
        <h1 class="text-center titre">Tous nos produits</h1>
        <div class="row">
            <div class="col-6 text-center">
                <form class="form-inline mb-3">
                    <label for="trier" class="mr-1">Trier par :</label>
                    <select name="tri" id="trier" class="form-control-sm">
                        <option value="pays">Pays</option>
                        <option value="decafeine">Décaféiné</option>
                        <option value="Bio">Bio</option>
                        <option value="grain">En grain</option>
                        <option value="moulu">Moulu</option>
                    </select>
                    <button type="submit" class="btn-marron rounded  ml-2 mb-2">Trier</button>
                </form>
            </div>
        </div>
        <div class="card-deck">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="card h-100 panneau">
                        <img src="../../public/img/cafe-vrac.png" class="card-img-top" alt="...">
                        <div class="card-body bg-marron2 d-flex flex-column justify-content-between">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <div class="d-flex justify-content-between">
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="read" name="action" class="d-none"/>
                                    <input type="text" value="gererMesBiens" name="page" class="d-none"/>
                                    <button class="btn btn-sm btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </form>
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="modify" name="action" class="d-none"/>
                                    <button class="btn btn-sm btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="card h-100 panneau">
                        <img src="../../public/img/cafe-vrac.png" class="card-img-top" alt="...">
                        <div class="card-body bg-marron2 d-flex flex-column justify-content-between">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            <div class="d-flex justify-content-between">
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="read" name="action" class="d-none"/>
                                    <input type="text" value="gererMesBiens" name="page" class="d-none"/>
                                    <button class="btn btn-sm btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </form>
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="modify" name="action" class="d-none"/>
                                    <button class="btn btn-sm btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="card h-100 panneau">
                        <img src="../../public/img/cafe-vrac.png" class="card-img-top" alt="...">
                        <div class="card-body bg-marron2  d-flex flex-column justify-content-between">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                            <div class="d-flex justify-content-between">
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="read" name="action" class="d-none"/>
                                    <input type="text" value="gererMesBiens" name="page" class="d-none"/>
                                    <button class="btn btn-sm btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </form>
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="modify" name="action" class="d-none"/>
                                    <button class="btn btn-sm btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="card h-100 panneau">
                        <img src="../../public/img/cafe-vrac.png" class="card-img-top" alt="...">
                        <div class="card-body bg-marron2  d-flex flex-column justify-content-between">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            <div class="d-flex justify-content-between">
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="read" name="action" class="d-none"/>
                                    <input type="text" value="gererMesBiens" name="page" class="d-none"/>
                                    <button class="btn btn-sm btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </form>
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="modify" name="action" class="d-none"/>
                                    <button class="btn btn-sm btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-auto">
                <nav aria-label="Page navigation example" id="pagination">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
</div>
<?php
footer();
