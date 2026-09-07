@extends('admin.layout.master')
@section('content')
<div class="card__wrapper">
    <h4 class="mb-3">Informations de l'établissement</h4>
    <p class="text-muted">Ces informations seront utilisées sur les bulletins, fiches d'inscription et documents.</p>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <form method="POST" action="{{ route('company.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            @foreach([
                ['name','Nom de l’établissement','text',true],['short_name','Nom court','text',false],
                ['address','Adresse','text',false],['city','Ville','text',false],['country','Pays','text',false],
                ['phone','Téléphone','text',false],['email','Email','email',false],['website','Site web','text',false],
                ['tax_id','NIF / N° fiscal','text',false],['registration_number','N° d’immatriculation','text',false]
            ] as [$field,$label,$type,$required])
                <div class="col-md-6">
                    <label class="form-label">{{ $label }}</label>
                    <input class="form-control" type="{{ $type }}" name="{{ $field }}" value="{{ old($field, $company->$field) }}" @required($required)>
                </div>
            @endforeach
            <div class="col-12">
                <label class="form-label">Logo</label>
                <input class="form-control" type="file" name="logo" accept="image/*">
            </div>
            <div class="col-12">
                <label class="form-label">Pied de page des documents</label>
                <textarea class="form-control" name="footer_text" rows="3">{{ old('footer_text', $company->footer_text) }}</textarea>
            </div>
        </div>
        <button class="btn btn-primary mt-4">Enregistrer</button>
    </form>
</div>
@endsection
