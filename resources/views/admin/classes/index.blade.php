@extends('admin.layout.master')

@section('content')
<div class="col-xxl-12">
    <div class="card__wrapper">
        <!-- En-tête -->
        <div class="card__header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="card__header-title mb-1">Liste des classes</h4>
                <p class="text-muted small mb-0">{{ $classes->count() }} classe(s)</p>
            </div>
            <a href="{{ route('classes.create') }}" class="btn btn-primary">
                <i class="fa-regular fa-plus me-1"></i>
                Nouvelle classe
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

        <div class="table__wrapper table-responsive">
            <table class="table mb-20 ">
                <thead>
                    <tr class="table__title">
                        <th>
                            <i class="fa-regular fa-hashtag me-2"></i>#
                        </th>
                        <th>
                            <i class="fa-regular fa-chalkboard me-2"></i>Nom de la classe
                        </th>
                        <th>
                            <i class="fa-regular fa-users me-2"></i>Effectif
                        </th>
                        <th>
                            <i class="fa-regular fa-money-bill me-2"></i>Frais de scolarité
                        </th>
                        <th>
                            <i class="fa-regular fa-calendar me-2"></i>Date de création
                        </th>
                        <th>
                            <i class="fa-regular fa-gear me-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="table__body">
                    @forelse($classes as $classe)
                    <tr>
                        <td>
                            <span class="badge-id">#{{ $classe->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">

                              <p>{{ $classe->nom_classe }}</p>
                            </div>
                        </td>
                        <td>
                               <p> {{ $classe->effectif }}</p>

                        </td>
                        <td>
                            <span class="fw-bold text-success">
                                {{ number_format($classe->prix, 2, ',', ' ') }} F
                            </span>
                        </td>
                        <td>
                            <span class="text-muted small">
                                <i class="fa-regular fa-calendar me-1"></i>
                                {{ $classe->created_at->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-start gap-2">


                                <!-- Modifier -->
                                <a href="{{ route('classes.edit', $classe->id) }}"
                                   class="table__icon edit"
                                   title="Modifier la classe">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('classes.destroy', $classe->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="table__icon delete border-0 bg-transparent"
                                            title="Supprimer la classe">
                                        <i class="fa-regular fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fa-regular fa-chalkboard fa-2x mb-2 d-block"></i>
                                Aucune classe trouvée
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
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

/* Styles des icônes d'action */
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

/* Alert */
.alert {
    border: none;
    border-radius: 12px;
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
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
