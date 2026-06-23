<!-- Modal de creación de categoría -->
<div id="modalCategoria" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 50;">
    <div style="background: #fff; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px rgba(0,0,0,0.1); width: 100%; max-width: 28rem; position: relative;">
        <button onclick="cerrarModalCategoria()" style="position: absolute; top: 0.5rem; right: 0.5rem; color: #6b7280; background: none; border: none; font-size: 1.25rem;">✖</button>
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">🆕 Crear nueva categoría</h2>

        <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label style="display: block; font-weight: 500;">Nombre:</label>
                <input type="text" name="nombre" style="border: 1px solid #d1d5db; border-radius: 0.25rem; width: 100%; padding: 0.5rem;" required>
            </div>

            <div class="mb-3">
                <label style="display: block; font-weight: 500;">Imagen:</label>
                <input type="file" name="imagen" style="border: 1px solid #d1d5db; border-radius: 0.25rem; width: 100%; padding: 0.5rem;">
            </div>

            <button type="submit" class="btn text-white" style="background: #e65100; border-color: #e65100;">
                Guardar categoría
            </button>
        </form>
    </div>
</div>

<script>
function abrirModalCategoria() {
    document.getElementById('modalCategoria').style.display = 'flex';
}

function cerrarModalCategoria() {
    document.getElementById('modalCategoria').style.display = 'none';
}
</script>
