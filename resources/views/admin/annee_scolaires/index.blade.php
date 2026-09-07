@extends('admin.layout.master')

@section('content')
<div class="col-xxl-12">
    <div class="card__wrapper">
        <!-- En-tête -->
        <div class="card__header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="card__header-title mb-1">Années Scolaires</h4>
                <p class="text-muted small mb-0">{{ $annee_scolaires->total() }} année(s) scolaire(s)</p>
            </div>
            <a href="{{ route('anneescolaire.create') }}" class="btn btn-primary">
                <i class="fa-regular fa-plus me-1"></i>
                Nouvelle année
            </a>
        </div>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-regular fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Barre de recherche -->
        <div class="search-box mb-4">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="fa-regular fa-search"></i>
                </span>
                <input type="text"
                       id="searchInput"
                       class="form-control"
                       placeholder="Rechercher une année scolaire..."
                       autocomplete="off">
                <span class="input-group-text bg-white" id="searchCount">
                    <span id="resultCount">{{ $annee_scolaires->count() }}</span> résultat(s)
                </span>
            </div>
        </div>

        <div class="table__wrapper table-responsive">
            <table class="table mb-20" id="anneeTable">
                <thead>
                    <tr class="table__title">
                        <th style="width: 80px;">#</th>
                        <th>
                            <i class="fa-regular fa-calendar me-2"></i>Année Scolaire
                        </th>
                        <th>
                            <i class="fa-regular fa-clock me-2"></i>Date de création
                        </th>
                        <th style="width: 120px;">
                            <i class="fa-regular fa-gear me-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="table__body">
                    @forelse($annee_scolaires as $annee)
                    <tr class="searchable-row">
                        <td>
                            <span class="badge-id">#{{ $annee->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="classe-icon bg-primary bg-opacity-10 rounded-3 me-3">
                                    <i class="fa-regular fa-calendar text-primary"></i>
                                </div>
                                <span class="fw-semibold searchable">{{ $annee->nom_annee_scolaire }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">
                                <i class="fa-regular fa-calendar-check me-1"></i>
                                {{ $annee->created_at->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <!-- Voir -->
                                <a href="{{ route('anneescolaire.show', $annee->id) }}"
                                   class="table__icon view"
                                   title="Voir détails">
                                    <i class="fa-regular fa-eye"></i>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('anneescolaire.edit', $annee->id) }}"
                                   class="table__icon edit"
                                   title="Modifier">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('anneescolaire.destroy', $annee->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer cette année scolaire ?');"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="table__icon delete border-0 bg-transparent"
                                            title="Supprimer">
                                        <i class="fa-regular fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="4" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fa-regular fa-calendar-xmark fa-2x mb-2 d-block"></i>
                                Aucune année scolaire trouvée
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($annee_scolaires->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Affichage de <strong>{{ $annee_scolaires->firstItem() }}</strong> à
                        <strong>{{ $annee_scolaires->lastItem() }}</strong> sur
                        <strong>{{ $annee_scolaires->total() }}</strong> années
                    </div>
                    <div>
                        {{ $annee_scolaires->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('anneeTable');
    const rows = table.querySelectorAll('.searchable-row');
    const resultCount = document.getElementById('resultCount');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(function(row) {
            const rowText = row.textContent.toLowerCase();

            if (rowText.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mettre à jour le compteur
        resultCount.textContent = visibleCount;

        // Message aucun résultat
        if (visibleCount === 0 && rows.length > 0) {
            if (!document.getElementById('noResultRow')) {
                const noResultRow = document.createElement('tr');
                noResultRow.id = 'noResultRow';
                noResultRow.innerHTML = `
                    <td colspan="4" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fa-regular fa-search fa-2x mb-2 d-block"></i>
                            Aucun résultat pour "<strong>${searchTerm}</strong>"
                        </div>
                    </td>
                `;
                table.querySelector('tbody').appendChild(noResultRow);
            }
        } else {
            const noResultRow = document.getElementById('noResultRow');
            if (noResultRow) noResultRow.remove();
        }
    });

    // Touche Échap pour vider la recherche
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('keyup'));
            searchInput.blur();
        }
    });
});
</script>

<style>
/* Barre de recherche */
.search-box .input-group {
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border-radius: 12px;
    overflow: hidden;
}

.search-box .form-control {
    border: 1px solid #e0e0e0;
    border-left: none;
    border-right: none;
    padding: 12px 15px;
    font-size: 0.95rem;
}

.search-box .form-control:focus {
    border-color: #4361ee;
    box-shadow: none;
}

.search-box .input-group-text {
    border: 1px solid #e0e0e0;
    color: #888;
    font-size: 0.9rem;
}

.search-box .input-group-text:first-child {
    border-right: none;
    border-radius: 12px 0 0 12px;
}

.search-box .input-group-text:last-child {
    border-left: none;
    border-radius: 0 12px 12px 0;
    background: #f8f9fa;
    font-weight: 500;
}

.search-box:focus-within .input-group-text {
    border-color: #4361ee;
}

/* Badge ID */
.badge-id {
    background: #f0f0f0;
    color: #666;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Icône classe */
.classe-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1rem;
}

/* Boutons d'action */
.table__icon {
    width: 35px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
    font-size: 14px;
    text-decoration: none;
}

.table__icon.view {
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.table__icon.edit {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.table__icon.delete {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.table__icon:hover {
    transform: scale(1.1);
}

.table__icon.view:hover {
    background: #0d6efd;
    color: white;
}

.table__icon.edit:hover {
    background: #ffc107;
    color: white;
}

.table__icon.delete:hover {
    background: #dc3545;
    color: white;
}

/* Table */
.table thead th {
    background: #f8f9fa;
    border-bottom: 2px solid #e0e0e0;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #666;
    padding: 12px 15px;
    font-weight: 600;
    white-space: nowrap;
}

.table tbody td {
    padding: 14px 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.9rem;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: #fafbfc;
}

/* Pagination */
.pagination {
    margin: 0;
}

.page-link {
    border-radius: 8px;
    margin: 0 2px;
    border: none;
    color: #4361ee;
    padding: 8px 14px;
}

.page-item.active .page-link {
    background: #4361ee;
    border-radius: 8px;
    color: white;
}

.page-link:hover {
    background: #e9ecef;
    color: #4361ee;
}

.page-item.disabled .page-link {
    color: #ccc;
}

/* Alert */
.alert {
    border: none;
    border-radius: 12px;
}

/* Bouton */
.btn-primary {
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-primary {
        width: 100%;
    }

    .card__header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start !important;
    }
}
</style>
@endsection
