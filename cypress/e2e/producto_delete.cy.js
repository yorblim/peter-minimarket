describe('Integración: Eliminar producto', () => {

  it('Permite eliminar un producto y verifica que desaparece del listado', () => {
    // 1️⃣ Ir a la lista de productos
    cy.visit('http://127.0.0.1:8000/productos')

    // 2️⃣ Verificar que existe el producto antes de eliminarlo
    cy.contains('Gaseosa Inca Kola 500ml').should('exist')

    // 3️⃣ Buscar el botón o formulario de eliminar
    cy.contains('Gaseosa Inca Kola 500ml')
      .parent() // subir al contenedor del producto
      .find('form') // normalmente el botón de eliminar está dentro de un form
      .submit() // envía el formulario de eliminación

    // 4️⃣ Esperar que redireccione al listado
    cy.url().should('include', '/productos')

    // 5️⃣ Confirmar que ya no aparece el producto
    cy.contains('Gaseosa Inca Kola 500ml').should('not.exist')
  })
})
