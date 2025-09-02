<?php
include_once "inc/databaseFunctions.php";

// Retrieve all genres from the database
$genres = getAllGenre();
?>

<nav class="navbar navbar-expand-sm">
    <div class="container-fluid">
        <a href="/index.php" title="Home">
            <img src="/images/logo.png" width="114" height="67" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse p-3" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item top">
                    <a class="nav-link" href="../">Home</a>
                </li>
                <li class="nav-item top">
                    <a class="nav-link" href="../#bestgames">Best Games</a>
                </li>
                <li class="nav-item dropdown top">
                    <a class="nav-link dropdown-toggle" href="#dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Browse
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/browse.php?all=browse-all">Browse All</a></li>
                        <li><hr class="dropdown-divider"></li>
                            <?php foreach ($genres as $genre): ?>
                                <li><a class="dropdown-item" href="/browse.php?all=<?php echo strtolower(urlencode($genre['Genre'])); ?>"><?php echo htmlspecialchars($genre['Genre']); ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endforeach; ?>
                        
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center">
                    <div class="collapse" id="searchForm">
                    <form class="d-flex" role="search" method="get" action="/search_results.php">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
                        <button class="btn btn-outline-success me-2" type="submit">Search</button>
                    </form>
                    </div>
                    <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#searchForm" aria-expanded="false" aria-controls="searchForm">
                        <img src="/images/search.png" alt="Search" style="width: 30px; height: 30px;">
                    </button>
                </li>
                <?php if ($_SESSION['logged_in'] == true): ?>
                    <?php if ($_SESSION['admin'] == '1'): ?>
                        <li class="nav-item me-2 my-1">
                            <a href="/admin/admin.php" class="btn btn-outline-light">Admin Page</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item me-2 my-1">
                        <a href="/edit_profile.php" class="btn btn-outline-light">Profile Page</a>
                    </li>
                    <li class="nav-item my-1">
                        <a href="/logout.php" class="btn btn-outline-light">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item me-2 my-1">
                        <a id="navbar-register" href="/login.php#register" class="btn btn-outline-light">Register</a>
                    </li>
                    <li class="nav-item my-1">
                        <a id="navbar-login" href="/login.php" class="btn btn-outline-light">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 