<!doctype html>
<html class="no-js" lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SCHOOL Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-style-mode" content="1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-jvectormap-2.0.5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/fontawesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/rating.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/waves.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nano.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="body-area">

    <div class="preloader" id="preloader">
        <div class="loading">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    @php
        $role = auth()->user()->role ?? null;

        if ($role === 'admin') {
            $dashboardRoute = 'admin.dashboard';
        } elseif ($role === 'professeur') {
            $dashboardRoute = 'teacher.dashboard';
        } elseif ($role === 'comptable') {
            $dashboardRoute = 'accountant.dashboard';
        } elseif ($role === 'secretaire') {
            $dashboardRoute = 'secretary.dashboard';
        } elseif ($role === 'parent') {
            $dashboardRoute = 'parent.dashboard';
        } else {
            $dashboardRoute = 'student.dashboard';
        }
    @endphp

    <div class="page__full-wrapper">

        <!-- SIDEBAR -->
        <div class="app-sidebar" id="sidebar">

            <div class="main-sidebar-header">
                <a href="{{ route($dashboardRoute) }}" class="header-logo">
                 
                    <h2>G-SCHOOL</h2>
                </a>
            </div>

            <div class="main-sidebar" id="sidebar-scroll">

                <nav class="main-menu-container nav nav-pills flex-column sub-open">

                    <div class="sidebar-left" id="sidebar-left"></div>

                    <ul class="main-menu">

                        @if(in_array($role, ['admin', 'secretaire']))

                            <li class="sidebar__menu-category">
                                <span class="category-name">Main</span>
                            </li>

                            <!-- DASHBOARD -->
                            <li class="slide">
                                <a class="sidebar__menu-item"
                                   href="{{ route($dashboardRoute) }}">

                                    <div class="side-menu__icon">
                                        <i class="icon-house"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Tableau de bord
                                    </span>

                                </a>
                            </li>

                            <!-- ÉLÈVES -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-solid fa-user-graduate"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Élèves
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('etudiants.create') }}">
                                            <i class="fa-light fa-user-plus me-2"></i>
                                            Ajouter un étudiant
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('etudiants.index') }}">
                                            <i class="fa-light fa-users me-2"></i>
                                            Liste des étudiants
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- ANNÉE SCOLAIRE -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Année scolaire
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('anneescolaire.create') }}">
                                            <i class="fa-light fa-calendar-plus me-2"></i>
                                            Nouvelle année
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('anneescolaire.index') }}">
                                            <i class="fa-light fa-calendar-list me-2"></i>
                                            Liste
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- CLASSES -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-sharp fa-light fa-chalkboard"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Classes
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('classes.index') }}">
                                            <i class="fa-light fa-list me-2"></i>
                                            Liste des classes
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('classes.create') }}">
                                            <i class="fa-light fa-chalkboard-user me-2"></i>
                                            Ajouter une classe
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- INSCRIPTIONS -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-light fa-file-signature"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Inscriptions
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('inscriptions.index') }}">
                                            <i class="fa-light fa-clipboard-list me-2"></i>
                                            Liste des inscriptions
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- NOTES -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-sharp fa-light fa-note-sticky"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Notes
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('notes.create') }}">
                                            <i class="fa-light fa-pen-to-square me-2"></i>
                                            Saisie des notes
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('notes.index') }}">
                                            <i class="fa-light fa-list-check me-2"></i>
                                            Liste des notes
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('notes.bulletin') }}">
                                            <i class="fa-light fa-file-certificate me-2"></i>
                                            Bulletin de notes
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- MATIÈRES -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-sharp fa-light fa-books"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Matières
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('matieres.create') }}">
                                            <i class="fa-light fa-book-medical me-2"></i>
                                            Ajouter une matière
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('matieres.index') }}">
                                            <i class="fa-light fa-books me-2"></i>
                                            Nos matières
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- MATIÈRES ET COEFFICIENTS -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-sharp fa-light fa-calculator"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Matières et coefficients
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('matiere_coeficients.create') }}">
                                            <i class="fa-light fa-link me-2"></i>
                                            Affecter une matière
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('matiere_coeficients.index') }}">
                                            <i class="fa-light fa-list-ol me-2"></i>
                                            Nos affectations
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- ENSEIGNANTS -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-sharp fa-light fa-chalkboard-user"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Enseignants
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('professeurs.create') }}">
                                            <i class="fa-light fa-user-plus me-2"></i>
                                            Ajouter un professeur
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('professeurs.index') }}">
                                            <i class="fa-light fa-chalkboard-user me-2"></i>
                                            Nos professeurs
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- EMPLOI DU TEMPS -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="fa-sharp fa-light fa-calendar-clock"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Emploi du temps
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('emploi_du_temps.create') }}">
                                            <i class="fa-light fa-calendar-plus me-2"></i>
                                            Créer l'emploi du temps
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('emploi_du_temps.index') }}">
                                            <i class="fa-light fa-calendar-days me-2"></i>
                                            Voir l'emploi du temps
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                          href="{{ route('emploi_du_temps.index') }}">
                                            <i class="fa-light fa-file-lines me-2"></i>
                                            Fiche
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- ÉVALUATIONS -->
                            <li class="slide has-sub">

                                <a href="javascript:void(0);" class="sidebar__menu-item">

                                    <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                    <div class="side-menu__icon">
                                        <i class="icon-tickets1"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Évaluations
                                    </span>

                                </a>

                                <ul class="sidebar-menu child1">

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('evaluations.create') }}">
                                            <i class="fa-light fa-file-circle-plus me-2"></i>
                                            Ajouter une évaluation
                                        </a>
                                    </li>

                                    <li class="slide">
                                        <a class="sidebar__menu-item"
                                           href="{{ route('evaluations.index') }}">
                                            <i class="fa-light fa-clipboard-check me-2"></i>
                                            Voir les évaluations
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <!-- UTILISATEURS ADMIN UNIQUEMENT -->
                            @if($role === 'admin')

                                <li class="slide has-sub">

                                    <a href="javascript:void(0);" class="sidebar__menu-item">

                                        <i class="fa-regular fa-angle-down side-menu__angle"></i>

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-users"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Utilisateurs
                                        </span>

                                    </a>

                                    <ul class="sidebar-menu child1">

                                        <li class="slide">
                                            <a class="sidebar__menu-item"
                                               href="{{ route('users.create') }}">
                                                <i class="fa-light fa-user-plus me-2"></i>
                                                Ajouter un utilisateur
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a class="sidebar__menu-item"
                                               href="{{ route('users.index') }}">
                                                <i class="fa-light fa-users me-2"></i>
                                                Voir les utilisateurs
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('settings.index') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-gear"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Paramètres système
                                        </span>

                                    </a>
                                </li>

                            @endif

                        @else

                            <!-- ESPACE PERSONNEL -->
                            <li class="sidebar__menu-category">
                                <span class="category-name">
                                    Mon espace
                                </span>
                            </li>

                            @if($role === 'professeur')

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('teacher.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-gauge-high"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Tableau de bord
                                        </span>

                                    </a>
                                </li>

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('teacher.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-pen-to-square"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Mes évaluations et notes
                                        </span>

                                    </a>
                                </li>

                            @elseif($role === 'comptable')

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('accountant.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-gauge-high"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Tableau de bord
                                        </span>

                                    </a>
                                </li>

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('accountant.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-money-bill-wave"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Inscriptions & paiements
                                        </span>

                                    </a>
                                </li>

                            @elseif($role === 'parent')

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('parent.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-gauge-high"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Tableau de bord
                                        </span>

                                    </a>
                                </li>

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('parent.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-children"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Mes enfants
                                        </span>

                                    </a>
                                </li>

                            @elseif($role === 'etudiant')

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('student.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-gauge-high"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Tableau de bord
                                        </span>

                                    </a>
                                </li>

                                <li class="slide">
                                    <a class="sidebar__menu-item"
                                       href="{{ route('student.dashboard') }}">

                                        <div class="side-menu__icon">
                                            <i class="fa-light fa-graduation-cap"></i>
                                        </div>

                                        <span class="sidebar__menu-label">
                                            Mes notes & résultats
                                        </span>

                                    </a>
                                </li>

                            @endif

                        @endif

                        <!-- DÉCONNEXION -->
                        <li class="slide mt-2">

                            <form method="POST"
                                  action="{{ route('logout') }}">

                                @csrf

                                <button type="submit"
                                        class="sidebar__menu-item border-0 bg-transparent w-100 text-start">

                                    <div class="side-menu__icon">
                                        <i class="fa-light fa-right-from-bracket"></i>
                                    </div>

                                    <span class="sidebar__menu-label">
                                        Déconnexion
                                    </span>

                                </button>

                            </form>

                        </li>

                    </ul>

                </nav>

            </div>
        </div>

        <div class="app__offcanvas-overlay"></div>

        <!-- CONTENU -->
        <div class="page__body-wrapper">

            <!-- HEADER -->
            <div class="app__header__area">

                <div class="app__header-inner">

                    <div class="app__header-left">

                        <a id="sidebar__active"
                           class="app__header-toggle"
                           href="javascript:void(0)">

                            <div class="bar-icon-2">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                        </a>

                    </div>

                    <div class="app__header-right">

                        <div class="app__header-action">

                            <ul>

                                <li>
                                    <div class="nav-item p-relative">

                                        <a id="notifydropdown" href="#">

                                            <div class="notification__icon">

                                                <svg width="22"
                                                     height="22"
                                                     viewBox="0 0 22 22"
                                                     fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">

                                                    <path d="M9.1665 22C7.27185 22 5.729 20.4582 5.729 18.5625C5.729 18.183 6.037 17.875 6.4165 17.875C6.79601 17.875 7.104 18.183 7.104 18.5625C7.104 19.7002 8.02985 20.625 9.1665 20.625C10.3032 20.625 11.229 19.7002 11.229 18.5625C11.229 18.183 11.537 17.875 11.9165 17.875C12.296 17.875 12.604 18.183 12.604 18.5625C12.604 20.4582 11.0613 22 9.1665 22Z"
                                                          fill="#7A7A7A"/>

                                                    <path d="M16.7291 19.2499H1.60411C0.719559 19.2499 0 18.5304 0 17.6458C0 17.1764 0.204437 16.7319 0.560944 16.4266C0.583939 16.4065 0.608612 16.3882 0.634293 16.3715C1.97992 15.1973 2.75 13.5079 2.75 11.724V9.16655C2.75 6.18106 4.77306 3.61805 7.66975 2.93323C8.04002 2.84797 8.41046 3.07439 8.49757 3.44483C8.58452 3.81426 8.35541 4.18453 7.98698 4.27164C5.71266 4.80875 4.125 6.82174 4.125 9.16655V11.724C4.125 13.9388 3.15417 16.0343 1.46396 17.4724C1.4502 17.4835 1.43828 17.4936 1.42351 17.5037C1.39883 17.5349 1.375 17.5826 1.375 17.6458C1.375 17.7704 1.47957 17.8749 1.60411 17.8749H16.7291C16.8538 17.8749 16.9584 17.7704 16.9584 17.6458C16.9584 17.5815 16.9346 17.5349 16.9089 17.5037C16.8951 17.4936 16.8822 17.4835 16.8694 17.4724C16.0482 16.7722 15.3999 15.9271 14.9436 14.9599C14.7804 14.617 14.9269 14.2073 15.2707 14.0442C15.6173 13.881 16.0233 14.0296 16.1856 14.3723C16.5485 15.1387 17.0573 15.8116 17.7008 16.3744C17.7246 16.3908 17.7495 16.4083 17.7704 16.4266C18.129 16.7319 18.3334 17.1764 18.3334 17.6458C18.3334 18.5304 17.6138 19.2499 16.7291 19.2499Z"
                                                          fill="#7A7A7A"/>

                                                    <path d="M16.0417 11.9166C12.7565 11.9166 10.0835 9.24365 10.0835 5.95839C10.0835 2.67296 12.7565 0 16.0417 0C19.3271 0 22.0001 2.67296 22.0001 5.95839C22.0001 9.24365 19.3271 11.9166 16.0417 11.9166ZM16.0417 1.375C13.5145 1.375 11.4585 3.43112 11.4585 5.95839C11.4585 8.48566 13.5145 10.5416 16.0417 10.5416C18.569 10.5416 20.6251 8.48566 20.6251 5.95839C20.6251 3.43112 18.569 1.375 16.0417 1.375Z"
                                                          fill="#7A7A7A"/>

                                                    <path d="M16.2709 8.70828C15.8914 8.70828 15.5834 8.40028 15.5834 8.02078V5.0415H15.125C14.7455 5.0415 14.4375 4.73351 14.4375 4.354C14.4375 3.9745 14.7455 3.6665 15.125 3.6665H16.2709C16.6504 3.6665 16.9584 3.9745 16.9584 4.354V8.02078C16.9584 8.40028 16.6504 8.70828 16.2709 8.70828Z"
                                                          fill="#7A7A7A"/>

                                                </svg>

                                            </div>

                                        </a>

                                    </div>
                                </li>

                            </ul>

                        </div>

                        <!-- PROFIL UTILISATEUR -->
                        <div class="nav-item p-relative">

                            <a id="userportfolio" href="#">

                                <div class="user__portfolio">

                                    <div class="user__portfolio-thumb">

                                        <img src="{{ asset('assets/images/avatar/avatar.png') }}"
                                             alt="avatar">

                                    </div>

                                    <div class="user__content">

                                        <h5>
                                            {{ auth()->user()->identifiant ?? auth()->user()->email }}
                                        </h5>

                                        <span>
                                            {{ ucfirst(auth()->user()->role) }}
                                        </span>

                                    </div>

                                </div>

                            </a>

                            <div class="user__dropdown">

                                <ul>

                                    @if($role === 'admin')

                                        <li>
                                            <a href="{{ route('company.edit') }}">
                                                <i class="fa-light fa-school me-2"></i>
                                                Mon établissement
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('settings.index') }}">
                                                <i class="fa-light fa-gear me-2"></i>
                                                Paramètres système
                                            </a>
                                        </li>

                                    @endif

                                    <li>
                                        <a href="{{ route($dashboardRoute) }}">
                                            <i class="fa-light fa-gauge-high me-2"></i>
                                            Tableau de bord
                                        </a>
                                    </li>

                                    <li>

                                        <form method="POST"
                                              action="{{ route('logout') }}"
                                              class="m-0">

                                            @csrf

                                            <button type="submit"
                                                    class="dropdown-item border-0 bg-transparent w-100 text-start">

                                                <i class="fa-light fa-right-from-bracket me-2"></i>

                                                Déconnexion

                                            </button>

                                        </form>

                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="body__overlay"></div>

            <!-- CONTENU PAGE -->
            <div class="app__slide-wrapper">

                @yield('content')

            </div>

            <!-- FOOTER -->
            <footer class="footer">

                <div class="row">

                    <div class="col-xl-12">

                        <div class="card__footer d-flex justify-content-center">

                            <p>
                                Copyright ©
                                <span id="year"></span>
                                <span class="text-black">
                                    Manez.
                                </span>
                                All rights reserved.
                            </p>

                        </div>

                    </div>

                </div>

            </footer>

        </div>

    </div>

    <!-- BACK TO TOP -->
    <div class="progress-wrap">

        <svg class="progress-circle svg-content"
             width="100%"
             height="100%"
             viewBox="-1 -1 102 102">

            <path d="M50,1 a49,49 0,1,0 0,98 a49,49 0,1,0 0,-98"/>

        </svg>

    </div>

    <!-- JS -->
    <script src="{{ asset('assets/js/vendor/calendar-activision.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/isotope.pkgd.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.repeater.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/loader.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/world-merc.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar-active.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/backtotop.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/steps-form.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/custom.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bloodhound.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/tagify.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/custom-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/height-equal.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/custom-chart.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/rangeslider-script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.barrating.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/rating-script.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/sidebar.js') }}"></script>

</body>

</html>
