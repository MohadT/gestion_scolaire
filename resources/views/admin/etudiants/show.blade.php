@extends('admin.layout.master')

@section('content')
<div class="col-xxl-12">
    <div class="card__wrapper">
        <!-- Barre d'actions -->
        <div class="card__header d-flex justify-content-between align-items-center mb-4 no-print">
            <div>
                <h4 class="card__header-title mb-1">Détails de l'étudiant</h4>
                <p class="text-muted small mb-0">Fiche d'information complète</p>
            </div>
            <div class="d-flex gap-2">

                <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-action">
                    <i class="fa-regular fa-pen-to-square me-1"></i>Modifier
                </a>
                <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary btn-action">
                    <i class="fa-regular fa-arrow-left me-1"></i>Retour
                </a>
            </div>
        </div>

        <!-- CONTENU IMPRIMABLE -->
        <div id="printArea">

            <!-- EN-TÊTE IMPRESSION -->
            <div class="print-only" style="text-align: center; margin-bottom: 20px; border-bottom: 3px double #1a237e; padding-bottom: 15px;">
                <h1 style="font-size: 20pt; font-weight: 900; color: #1a237e; margin: 0; letter-spacing: 2px;">GESTION SCOLAIRE</h1>
                <p style="font-size: 12pt; color: #333; margin: 5px 0;">Fiche de Renseignements - Étudiant</p>
                <p style="font-size: 9pt; color: #666;">N° Fiche : #{{ str_pad($etudiant->id, 6, '0', STR_PAD_LEFT) }} | Date : {{ now()->format('d/m/Y') }}</p>
            </div>

            <!-- VERSION ÉCRAN -->
            <div class="screen-content">
                <div class="row g-4">
                    <!-- Carte Profil -->
                    <div class="col-lg-4">
                        <div class="card-profile text-center">
                            <div class="card-profile-cover"></div>
                            <div class="card-profile-body">
                                <img src="{{ $etudiant->photo ? asset('storage/' . $etudiant->photo) : asset('assets/images/avatar/avatar3.png') }}"
                                     class="avatar-xl" alt="Photo">
                                <h4 class="mt-3 mb-1">{{ $etudiant->prenom_etudiant }} {{ $etudiant->nom_etudiant }}</h4>
                               

                                <div class="profile-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">Matricule</span>
                                        <span class="stat-value">#{{$etudiant->code_etudiant }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Inscrit le</span>
                                        <span class="stat-value">{{ $etudiant->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Modifié le</span>
                                        <span class="stat-value">{{ $etudiant->updated_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cartes Infos -->
                    <div class="col-lg-8">
                        <!-- Étudiant -->
                        <div class="info-card mb-4">
                            <div class="info-card-header">
                                <i class="fa-regular fa-graduation-cap"></i>
                                <span>Informations de l'étudiant</span>
                            </div>
                            <div class="info-card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="info-field">
                                            <label>Nom</label>
                                            <p>{{ $etudiant->nom_etudiant }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="info-field">
                                            <label>Prénom</label>
                                            <p>{{ $etudiant->prenom_etudiant }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-field">
                                            <label>Adresse</label>
                                            <p>{{ $etudiant->adresse_etudiant }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tuteur -->
                        <div class="info-card">
                            <div class="info-card-header bg-success">
                                <i class="fa-regular fa-user-tie"></i>
                                <span>Informations du tuteur</span>
                            </div>
                            <div class="info-card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="info-field">
                                            <label>Nom du tuteur</label>
                                            <p>{{ $etudiant->nom_du_tuteur }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="info-field">
                                            <label>Téléphone</label>
                                            <p><a href="tel:{{ $etudiant->numero_du_tuteur }}">{{ $etudiant->numero_du_tuteur }}</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between mt-4 no-print">
                            <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST"
                                  onsubmit="return confirm('Supprimer définitivement cet étudiant ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-action">
                                    <i class="fa-regular fa-trash me-1"></i>Supprimer
                                </button>
                            </form>
                            <div class="d-flex gap-2">
                                <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-action">
                                    <i class="fa-regular fa-pen-to-square me-1"></i>Modifier
                                </a>
                                <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary btn-action">
                                    <i class="fa-regular fa-list me-1"></i>Retour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VERSION IMPRESSION -->
            <div class="print-only">
                <table class="print-table">
                    <tr>
                        <td style="width: 65%; vertical-align: top; padding-right: 20px;">
                            <!-- Section Identité -->
                            <div class="print-section">
                                <h3>1. IDENTITÉ DE L'ÉTUDIANT</h3>
                                <table class="print-details">
                                    <tr><td class="plabel">Matricule</td><td class="pvalue">#{{ str_pad($etudiant->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                                    <tr><td class="plabel">Nom</td><td class="pvalue">{{ strtoupper($etudiant->nom_etudiant) }}</td></tr>
                                    <tr><td class="plabel">Prénom(s)</td><td class="pvalue">{{ $etudiant->prenom_etudiant }}</td></tr>
                                    <tr><td class="plabel">Adresse</td><td class="pvalue">{{ $etudiant->adresse_etudiant }}</td></tr>
                                    <tr><td class="plabel">Date d'inscription</td><td class="pvalue">{{ $etudiant->created_at->format('d/m/Y') }}</td></tr>
                                    <tr><td class="plabel">Statut</td><td class="pvalue"><strong>ACTIF</strong></td></tr>
                                </table>
                            </div>

                            <!-- Section Tuteur -->
                            <div class="print-section">
                                <h3>2. TUTEUR / RESPONSABLE LÉGAL</h3>
                                <table class="print-details">
                                    <tr><td class="plabel">Nom complet</td><td class="pvalue">{{ strtoupper($etudiant->nom_du_tuteur) }}</td></tr>
                                    <tr><td class="plabel">Téléphone</td><td class="pvalue">{{ $etudiant->numero_du_tuteur }}</td></tr>
                                    <tr><td class="plabel">Lien de parenté</td><td class="pvalue">_________________</td></tr>
                                </table>
                            </div>

                            <!-- Section Scolarité -->
                            <div class="print-section">
                                <h3>3. SCOLARITÉ</h3>
                                <table class="print-details">
                                    <tr><td class="plabel">Classe</td><td class="pvalue">_________________</td></tr>
                                    <tr><td class="plabel">Année scolaire</td><td class="pvalue">_________________</td></tr>
                                </table>
                            </div>
                        </td>
                        <td style="width: 35%; vertical-align: top; text-align: center; border-left: 2px solid #1a237e; padding-left: 20px;">
                            <!-- Photo -->
                            <div style="margin-bottom: 20px;">
                                <img src="{{ $etudiant->photo ? asset('storage/' . $etudiant->photo) : asset('assets/images/avatar/avatar3.png') }}"
                                     style="width: 120px; height: 140px; object-fit: cover; border: 2px solid #333;" alt="Photo">
                                <p style="font-size: 8pt; margin-top: 5px;">Photo d'identité</p>
                            </div>

                            <!-- Cadre signatures -->
                            <div class="print-section">
                                <h3>4. SIGNATURES</h3>
                                <div style="margin-top: 25px;">
                                    <div style="border-top: 1px solid #000; padding-top: 5px; margin-bottom: 25px;">
                                        <p style="font-size: 9pt; margin: 0;">Signature du Tuteur</p>
                                        <p style="font-size: 7pt; color: #666; margin: 2px 0;">(Lu et approuvé)</p>
                                    </div>
                                    <div style="border-top: 1px solid #000; padding-top: 5px;">
                                        <p style="font-size: 9pt; margin: 0;">Cachet de l'Administration</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Pied de page -->
                <div style="border-top: 1px solid #999; margin-top: 25px; padding-top: 8px; text-align: center; font-size: 8pt; color: #999;">
                    Document généré le {{ now()->format('d/m/Y à H:i') }} | Gestion Scolaire © {{ now()->year }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ========== DESIGN ÉCRAN ========== */
.screen-content { display: block; }
.print-only { display: none; }

/* Carte Profil */
.card-profile {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}
.card-profile-cover {
    height: 80px;
    background: linear-gradient(135deg, #4361ee, #6610f2);
}
.card-profile-body {
    padding: 0 25px 25px;
    margin-top: -50px;
}
.avatar-xl {
    width: 100px; height: 100px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    object-fit: cover;
    background: #f0f0f0;
}
.badge-status {
    display: inline-block;
    background: #d4edda;
    color: #155724;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 8px;
}
.profile-stats {
    margin-top: 20px;
    text-align: left;
    border-top: 1px solid #eee;
    padding-top: 15px;
}
.stat-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px dashed #eee;
}
.stat-item:last-child { border: none; }
.stat-label { font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-value { font-weight: 600; color: #333; font-size: 0.85rem; }

/* Cartes Info */
.info-card {
    background: white;
    border-radius: 14px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    overflow: hidden;
}
.info-card-header {
    background: #4361ee;
    color: white;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.info-card-header.bg-success { background: #2ec4b6; }
.info-card-body { padding: 20px; }
.info-field {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 12px 16px;
    border-left: 3px solid #4361ee;
}
.info-field label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #999;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
    display: block;
}
.info-field p {
    margin: 0;
    font-weight: 600;
    color: #222;
    font-size: 0.95rem;
}
.info-field a { color: #4361ee; text-decoration: none; }
.info-field a:hover { text-decoration: underline; }

.btn-action {
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-action:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

/* ========== DESIGN IMPRESSION ========== */
@media print {
    body, body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
    .screen-content { display: none !important; }
    .print-only { display: block !important; }

    .no-print, .btn-action, .card__header, .sidebar, .main-sidebar,
    .navbar, .main-header, .main-footer, nav, header, footer, aside,
    form, button, .modal, [class*="sidebar"], [class*="navbar"],
    [class*="menu"], [class*="nav"] {
        display: none !important; visibility: hidden !important;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { background: white; font-family: 'Times New Roman', serif; font-size: 11pt; }

    @page { size: A4; margin: 12mm; }

    .print-section {
        margin-bottom: 15px;
        page-break-inside: avoid;
    }
    .print-section h3 {
        background: #1a237e;
        color: white;
        padding: 5px 10px;
        font-size: 10pt;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .print-details {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ccc;
    }
    .print-details td {
        border: 1px solid #ccc;
        padding: 5px 8px;
        font-size: 10pt;
    }
    .plabel {
        background: #f5f5f5;
        font-weight: bold;
        width: 35%;
        color: #333;
    }
    .pvalue {
        color: #000;
    }
    .print-table {
        width: 100%;
        border-collapse: collapse;
    }
    .print-table td {
        vertical-align: top;
    }
}
</style>


@endsection
