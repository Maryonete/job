<?php
if (!empty($_SESSION['connecte'])) {
    redirectTo('admin-dashboard');
}
?>
<div class="row align-items-center g-lg-5 py-5">
    <div class="col-lg-7 text-center text-lg-start">
        <p class="col-lg-10 fs-4">
            <img src="./assets/flamant.png" class="img-fluid border rounded-3 shadow-lg mb-4"
                alt="Flamand" width="700" height="500" loading="lazy">
        </p>
    </div>
    <div class="col-md-10 mx-auto col-lg-5">
        <div class="mb-3 text-center">
            <h1>Connexion</h1>
        </div>
        <form method="post">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="votre email">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="votre mot de passe">
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>
        </form>
    </div>
</div>