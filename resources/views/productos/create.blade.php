@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-plus-circle"></i> Nuevo Producto</h1>

    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nombre del Producto</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label>Marca</label>
            <input type="text" name="marca" placeholder="Ej: Gloria, Don Vittorio...">
        </div>

        <div class="form-group">
            <label>Precio regular (S/)</label>
            <input type="number" step="0.01" name="precio" required>
        </div>

        <div class="form-group">
            <label>Precio de oferta (S/) <small style="color:#888;">— opcional, debe ser menor al regular</small></label>
            <input type="number" step="0.01" name="precio_oferta" placeholder="Dejar vacío si no hay oferta">
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" required min="0">
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <div class="categoria-row">
                <select name="categoria_id" id="categoriaSelect">
                    <option value="">Sin categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn-admin-cat" data-bs-toggle="modal" data-bs-target="#modalCategoria">
                    <i class="bi bi-plus-lg"></i> Nueva
                </button>
            </div>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>Imagen del producto</label>
            <input type="file" name="imagen">
        </div>

        <div class="form-actions">
            <button class="btn-admin-save"><i class="bi bi-check-lg"></i> Guardar producto</button>
            <a href="{{ route('productos.index') }}" class="btn-admin-cancel">Cancelar</a>
        </div>
    </form>
</div>

<div class="modal fade" id="modalCategoria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Nombre de la categoría</label>
                <input type="text" id="nombreCategoria" class="form-control" placeholder="Ej: Bebidas, Snacks...">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btnGuardarCategoria">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('btnGuardarCategoria').addEventListener('click', function () {
    let nombre = document.getElementById('nombreCategoria').value.trim();
    if (nombre === "") { alert("Escribe un nombre para la categoría."); return; }

    fetch("{{ route('categorias.store.ajax') }}", {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: JSON.stringify({ nombre: nombre })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            let select = document.getElementById('categoriaSelect');
            select.add(new Option(data.categoria.nombre, data.categoria.id));
            select.value = data.categoria.id;
            document.getElementById('nombreCategoria').value = "";
            bootstrap.Modal.getInstance(document.getElementById('modalCategoria')).hide();
        } else {
            alert("No se pudo crear la categoría.");
        }
    })
    .catch(() => alert("Error al guardar la categoría."));
});
</script>
@endsection
