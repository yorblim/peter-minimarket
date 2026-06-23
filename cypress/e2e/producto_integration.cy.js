describe('Integración: Crear producto', () => {

  it('Permite crear un nuevo producto y mostrarlo en la lista', () => {
    // Visitar la página de creación
    cy.visit('http://127.0.0.1:8000/productos/create')

    // Llenar los campos del formulario
    cy.get('input[name="nombre"]').type('Gaseosa Inca Kola 500ml')
    cy.get('input[name="precio"]').type('3.50')
    cy.get('input[name="stock"]').type('25')
    cy.get('textarea[name="descripcion"]').type('Bebida tradicional peruana de 500ml')
    
    // (Opcional) subir una imagen si tu formulario lo permite
    // cy.get('input[name="imagen"]').attachFile('inca.png') // requiere cypress-file-upload

    // Enviar formulario
    cy.get('button[type="submit"]').click()

    // Verificar redirección y contenido
    cy.url().should('include', '/productos')
    cy.contains('Gaseosa Inca Kola 500ml')
  })
})
