<nav class="navbar navbar-expand-lg bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand">OnSales</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Products</a>
                </li>
                <?php
                if (isset($_SESSION["user"])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/panier/mon_panier">Panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/commandes/<?php echo $_SESSION["user"]["id"]; ?>">Commandes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Se deconnecter</a>
                    </li>
                    <div class="username">
                        <?php echo "Welcome <em>" . strtoupper($_SESSION["user"]["fullname"]) . "</em>" ?>
                    </div>
                <?php }
                if (!isset($_SESSION["user"])) {
                ?>
                    <div class="loginForm">
                        <form action="/login" method="POST">
                            <input type="email" name="email" class="usermail" placeholder="email" required>
                            <input type="password" name="pwd" class="userpwd" placeholder="password" required>
                            <input type="submit" value="log In">
                        </form>
                    </div>
                    <div class="SingupForm">
                        <button class="btn-warning" id="createAccountBt">Create Account</button>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<!--create account form-->

<div class="createAccountBox d-none">
    <form action="create_account" method="POST" id="createAccountForm">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="fullname" class="form-label">fullname</label>
            <input type="text" class="form-control" id="fullname" name="fullname" required>
        </div>
        <div class="d-flex gap-2 col-6 mx-auto">
            <button class="btn btn-warning flex-grow-1" type="submit">Create</button>
            <button class="btn btn-danger flex-grow-3 closeBt" type="button">close</button>
        </div>
    </form>
</div>