describe('Página de productos', () => {
  it('Carga correctamente el listado de productos', () => {
    cy.visit('http://127.0.0.1:8000/productos')  // Cambia si usas otro puerto
    cy.contains('Lista de Productos')
  })
})
