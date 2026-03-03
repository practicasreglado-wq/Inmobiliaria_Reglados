<template>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-col brand">
        <h2>INMOBILIARIA · RS</h2>
        <p>
          Boutique inmobiliaria especializada en activos singulares,
          edificios, hoteles y grandes operaciones.
          Discreción, análisis y resultados.
        </p>
      </div>

      <div class="footer-col">
        <h3>ACTIVOS</h3>
        <ul>
          <li>Edificios</li>
          <li>Hoteles</li>
          <li>Parking</li>
          <li>Activos Singulares</li>
          <li>Fincas</li>
        </ul>
      </div>

      <div class="footer-col">
        <h3>EMPRESA</h3>
        <ul>
          <li>Quiénes somos</li>
          <li>Metodología</li>
          <li><router-link to="/team" class="footer-link">Equipo</router-link></li>
          <li>Contacto</li>
        </ul>
      </div>

      <div class="footer-col">
        <h3>ACCESO</h3>
        <ul>
          <li>Panel Privado</li>
          <li>Deja tu búsqueda</li>
          <li>Solicitar NDA</li>
          <li>Aportar activo</li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© 2026 RS Real Estate · Todos los derechos reservados</span>
      <span>Aviso legal · Privacidad · Cookies · RGPD</span>
    </div>
  </footer>
</template>

<script>
export default {
  name: "FooterComponent" // Es mejor usar nombres compuestos
};
</script>

<style scoped>
.footer {
  background-color: var(--azul-principal);
  color: var(--blanco);
  padding: 70px 80px 30px 80px;
}

.footer-container {
  display: flex;
  justify-content: space-between;
  gap: 60px;
  margin-bottom: 50px;
}

.footer-col {
  flex: 1;
}

.brand h2 {
  font-size: 1.6rem;
  margin-bottom: 20px;
  font-weight: 700;
}

.brand p {
  line-height: 1.7;
  opacity: 0.9;
  max-width: 300px;
}

.footer-col h3 {
  margin-bottom: 20px;
  font-size: 1.1rem;
  letter-spacing: 1px;
}

.footer-col ul {
  list-style: none;
  padding: 0;
}

/* Estilo común para li y enlaces */
.footer-col li, 
.footer-link {
  margin-bottom: 12px;
  opacity: 0.85;
  cursor: pointer;
  transition: 0.3s ease;
  text-decoration: none; /* Quita el subrayado */
  color: inherit; /* Hereda el color blanco */
  display: block; /* Para que el margen funcione bien */
}

.footer-col li:hover, 
.footer-link:hover {
  opacity: 1;
  padding-left: 5px; /* Un pequeño efecto visual opcional */
}

.footer-bottom {
  display: flex;
  justify-content: space-between;
  border-top: 1px solid rgba(255,255,255,0.2);
  padding-top: 20px;
  font-size: 0.9rem;
  opacity: 0.85;
}

/* Responsive básico */
@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    gap: 40px;
  }
  .footer {
    padding: 40px 20px;
  }
}
</style>