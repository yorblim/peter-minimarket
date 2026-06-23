describe('Integración: Editar producto', () => {

  it('Permite editar un producto existente y ver los cambios reflejados', () => {
    // 1️⃣ Ir al listado de productos
    cy.visit('http://127.0.0.1:8000/productos')

    // 2️⃣ Buscar el producto que creamos antes
    cy.contains('Gaseosa Inca Kola 500ml')
      .parent() // Va al contenedor del producto
      .find('a[href*="edit"]') // Busca el enlace de editar
      .click()

    // 3️⃣ Cambiar algún valor (por ejemplo el precio)
    cy.get('input[name="precio"]').clear().type('4.00')

    // 4️⃣ Enviar formulario
    cy.get('button[type="submit"]').click()

    // 5️⃣ Verificar redirección al listado
    cy.url().should('include', '/productos')

    // 6️⃣ Comprobar que el nuevo precio aparece
    cy.contains('4.00')
  })
})
