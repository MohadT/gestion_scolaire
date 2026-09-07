@extends('admin.layout.master')
@section('content')
<div class="row g-4">
<div class="col-12"><h4>Tableau de bord Secrétaire</h4><p class="text-muted">Gestion des inscriptions et de la scolarité.</p></div>
@foreach ([['Étudiants',$totalEtudiants,'etudiants.index'],['Professeurs',$totalProfesseurs,'professeurs.index'],['Classes',$totalClasses,'classes.index'],['Inscriptions',$totalInscriptions,'inscriptions.index']] as $item)
<div class="col-xl-3 col-md-6"><a href="{{ route($item[2]) }}" class="text-decoration-none"><div class="card__wrapper"><h6>{{ $item[0] }}</h6><h3>{{ $item[1] }}</h3></div></a></div>
@endforeach
</div>
@endsection
