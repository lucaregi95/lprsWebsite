<?php?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>
        Campus - Forum
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="brand" href="accueil.php">
            <img class="logo" src="img/logo.png">
        </a>
        <button class="navbar-toggler" data-bs-target="#m" data-bs-toggle="collapse">
          <span class="navbar-toggler-icon">
          </span>
        </button>
        <div class="collapse navbar-collapse" id="m">
            <ul class="navbar-nav ms-4 me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="accueil.php">
                        Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="evenement.php">
                        Évènement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="offre.php">
                        Offre
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="forum.php">
                        Forum
                    </a>
                </li>
            </ul>
            <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="profil.php">
            <span class="avatar">
              NK
            </span>
                <span class="small">
              Nassim K.
              <i class="bi bi-chevron-down">
              </i>
            </span>
            </a>
        </div>
    </div>
</nav>
<header class="hero">
    <div class="container d-flex justify-content-between align-items-end">
        <div>
            <div class="eyebrow">
                Campus · Forum
            </div>
            <h1>
                Forum
            </h1>
            <p>
                Pose tes questions, partage tes idées et échange avec la communauté.
            </p>
        </div>

    </div>
</header>
<main class="container mt-4">
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="box mb-3">
                <h6>
                    Nouveau post
                </h6>
                On peut essayer de mettre soit le formulaire ou un bouton qui ouvre une fenêtre du formulaure
                <textarea class="form-control form-control-sm mb-2" placeholder="Écris ton message…" rows="4"></textarea>
                <button class="btn btn-primary btn-sm w-100">
                    Publier
                </button>
            </div>

        </aside>
        <div class="col-lg-9">
            <input class="form-control form-control-sm mb-3" placeholder="Rechercher un post"/>
            <div class="tabs border-bottom mb-3">
                <a class="on" href="#">
                    Récents
                </a>
                <a href="#">
                    Sans réponse
                </a>
                <a href="#">
                    Mes posts
                </a>
            </div>
            <div class="row-i">
            <span class="avatar">
              L
            </span>
                <div class="flex-grow-1">
                    <b class="small-t">
                        Lucas Bernard
                    </b>
                    <span class="tag">
                Étudiant
              </span>
                    <div class="small-t my-1">
                        Quelqu'un voudrait former un groupe de travail pour le partiel de bases de données ?
                    </div>
                    <div class="muted small-t">
                        12/10/2026 à 14:32
                    </div>
                </div>
                <a class="small-t text-nowrap" href="#">
                    <i class="bi bi-chat-dots">
                    </i>
                    5 réponses
                </a>
            </div>
            <div class="row-i">
            <span class="avatar">
              S
            </span>
                <div class="flex-grow-1">
                    <b class="small-t">
                        Sofia Martin
                    </b>
                    <span class="tag">
                Alumni
              </span>
                    <div class="small-t my-1">
                        Conseils pour réussir son premier stage : soignez votre CV et préparez des questions.
                    </div>
                    <div class="muted small-t">
                        12/10/2026 à 09:10
                    </div>
                </div>
                <a class="small-t text-nowrap" href="#">
                    <i class="bi bi-chat-dots">
                    </i>
                    8 réponses
                </a>
            </div>
            <div class="row-i">
            <span class="avatar">
              K
            </span>
                <div class="flex-grow-1">
                    <b class="small-t">
                        Pr. Karim Diallo
                    </b>
                    <span class="tag">
                Professeur
              </span>
                    <div class="small-t my-1">
                        Rappel : les inscriptions aux tutorats sont ouvertes jusqu'à vendredi.
                    </div>
                    <div class="muted small-t">
                        11/10/2026 à 17:45
                    </div>
                </div>
                <a class="small-t text-nowrap" href="#">
                    <i class="bi bi-chat-dots">
                    </i>
                    2 réponses
                </a>
            </div>
            <div class="row-i">
            <span class="avatar">
              E
            </span>
                <div class="flex-grow-1">
                    <b class="small-t">
                        Emma Roux
                    </b>
                    <span class="tag">
                Étudiante
              </span>
                    <div class="small-t my-1">
                        Où trouver les annales de droit des contrats ?
                    </div>
                    <div class="muted small-t">
                        10/10/2026 à 20:05
                    </div>
                </div>
                <a class="small-t text-nowrap" href="#">
                    <i class="bi bi-chat-dots">
                    </i>
                    0 réponses
                </a>
            </div>

        </div>
    </div>
</main>
<footer>
    <div class="container d-flex flex-wrap justify-content-between">
        <b class="text-dark">
            LPRS
        </b>
        <div>
            <a href="#">
                Aide
            </a>
            <a href="#">
                Règles de la communauté
            </a>
            <a href="#">
                Mentions légales
            </a>
            <a href="#">
                Confidentialité
            </a>
        </div>
    </div>
    <div class="container mt-2">
        © 2026 Campus. Tous droits réservés.
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>
