describe('Integración: Carrito de compras', () => {
  it('Permite agregar un producto al carrito y verlo listado', () => {
    // 1️⃣ Ir a la tienda
    cy.visit('http://127.0.0.1:8000/tienda')

    // 2️⃣ Asegurarse de que haya productos visibles
    cy.contains('Agregar al carrito').should('exist')

    // 3️⃣ Agregar el primer producto
    cy.contains('Agregar al carrito').first().click()

    // 4️⃣ Esperar confirmación o redirección
    cy.wait(2000)

    // 5️⃣ Ir al carrito
    cy.visit('http://127.0.0.1:8000/cart')

    // 6️⃣ Verificar que el carrito no esté vacío
    cy.contains('Tu carrito está vacío').should('not.exist')

    // 7️⃣ Verificar que se muestra al menos una tarjeta de producto
    cy.get('.card').should('exist')

    // 8️⃣ Verificar que el nombre del producto esté presente
    cy.get('.card-title').first().should('not.be.empty')

    // 9️⃣ (Opcional) Mostrar un mensaje de éxito en consola
    cy.log('✅ El producto fue agregado correctamente al carrito')
  })
})
