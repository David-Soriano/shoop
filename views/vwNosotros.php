<div class="container">
  <h2>Sobre Nosotros - SHOOP Para ti</h2>
  <section class="profiles">

    <div class="avatar"
      style="--bg-img:url(https://st.depositphotos.com/1897095/1642/i/450/depositphotos_16428473-stock-photo-fog-and-pastel-gradient.jpg)">
      <div class="avatar-img">
        <img src="IMG/david.png">
      </div>
      <p>David</p>
    </div>


    <div class="avatar" style="--bg-img:url(https://picsum.photos/id/54/300/200)">
      <div class="avatar-img">
        <img src="IMG/Dariana.png">
      </div>
      <p>Dariana</p>
    </div>


    <div class="avatar" style="--bg-img-X:url(https://picsum.photos/id/48/300/200)">
      <div class="avatar-img">
        <img
          src="https://raw.githubusercontent.com/cbolson/icodethis-challenges/main/assets/images/profile-3-trans.png">
      </div>
      <p>Thomas</p>
    </div>

    <div class="avatar" style="--bg-img:url(https://picsum.photos/id/210/300/200)">
      <div class="avatar-img">
        <img src="IMG/kevin.png">
      </div>
      <p>Kevin</p>
    </div>
    <div class="avatar" style="--bg-img:url(https://picsum.photos/id/210/300/200)">
      <div class="avatar-img">
        <img
          src="https://raw.githubusercontent.com/cbolson/icodethis-challenges/main/assets/images/profile-5-trans.png">
      </div>
      <p>Deivid</p>
    </div>
  </section>
  <div class="about-content">
    <h2>Hecho por Estudiantes, Para Impulsar el Comercio</h2>
    <p>SHOOP es una tienda online creada por estudiantes del SENA con el propósito de impulsar el comercio digital y
      ofrecer una plataforma accesible tanto para vendedores como para compradores. Nuestro objetivo principal es ayudar
      a emprendedores y pequeños negocios a ganar visibilidad, simplificando el proceso de venta de sus productos.</p>

    <div class="row rw-mn">
      <div class="col bx-tt">
        <h2>Nuestra Misión</h2>
      </div>
      <div class="col">
        <p>Nuestra misión es <b>impulsar</b> el comercio local con una plataforma fácil de usar que <b>conecta</b> a
          vendedores y clientes. Queremos <b>ayudar</b> a los emprendedores a mostrar sus productos y <b>vender</b> más,
          brindándoles herramientas innovadoras para llegar a más <b>personas</b> de manera sencilla.</p>
      </div>
    </div>

    <div class="row rw-mn">
      <div class="col">
        <p>En <b>SHOOP</b>, encontrarás de todo: tecnología, accesorios para autos y motos, y productos <b>únicos</b>
          que no siempre se ven en otros sitios. Nuestra plataforma ayuda a los vendedores a <b>destacar</b> y a los
          compradores a descubrir artículos de <b>calidad</b> a buenos precios. Estamos aquí para hacer crecer el
          <b>comercio</b> local con pasión y compromiso.</p>
      </div>
      <div class="col bx-tt">
        <h2>Nuestros Productos</h2>
      </div>
    </div>

    <div class="row">
      <div class="col bx-ct">
        <h2>Contáctenos</h2>
        <p>Si tiene alguna pregunta sobre nuestros productos o servicios, no dude en ponerse en contacto con nosotros.
          Estamos aquí para ayudarlo.</p>
        <p>Dirección: Chía, Cundinamarca</p>
        <p>Correo Electrónico: toshoop2024@gmail.com</p>
      </div>
    </div>
  </div>
</div>

<style>
  /*@import url(https://fonts.bunny.net/css?family=khand:300);*/
  @import url(https://fonts.bunny.net/css?family=caveat:400) layer(demo);
  @import "https://codepen.io/cbolson/pen/rNEdgKo.css" layer(template);
  @layer template, demo;
  
  @layer demo {
    .profiles {
      --size: 200px;
      --img-clip: "M 0 -50 L 200 -50 L 200 150 C 100 150 0 250 0 150 Z";
      /* unfortunatly it isn't possible (as far as I know) to use custom properties in clip paths */
      --img-shadow: drop-shadow(5px 5px 2px rgba(0 0 0 / 0.5));
      --name-txt-clr: #000;
      --bg-clr: steelblue;
      /* only displayed if no background image defined */
      --bg-blur: 0;
      /* background image default blur */
      --bg-blur-hover: 20px;
      /* background image blur on hover */

      font-family: 'Caveat', handwriting;
      display: grid;
      grid-template-columns: repeat(var(--grid-cols, 1), var(--size));
      gap: 2rem;
      margin: 20vh auto;
      width: fit-content;
    }

    @media (min-width: 500px) {
      .profiles {
        --grid-cols: 2;
      }
    }

    @media (min-width: 860px) {
      .profiles {
        --grid-cols: 5;
      }
    }

    .profiles {
      margin: 10% auto !important;
    }

    .avatar {
      position: relative;
      width: var(--size);
      height: var(--size);
      /* for older browsers */
      aspect-ratio: 1;
    }

    .avatar-img {
      clip-path: path(var(--img-clip));
    }

    .avatar-img::before {
      content: '';
      position: absolute;
      display: blocl;
      inset: 50% 0 0 0;
      z-index: -1;
      border-radius: 20px;
      background-color: var(--bg-clr);
      /* fallback if image not defined as custom property */
      background-image: var(--bg-img);
      background-size: cover;
      background-position: center;
      filter: blur(var(--bg-blur));
      transition: filter 300ms ease-in-out;
    }

    .avatar-img>img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: scale 300ms, filter 300ms;
      transform-origin: bottom;
      scale: var(--img-scale, .9);
      filter: var(--img-shadow);
    }

    .avatar>p {
      font-size: 1.4rem;
      color: var(--name-txt-clr);
      position: absolute;
      bottom: -1rem;
      right: .25rem;
      translate: 0 var(--name-y, -50px);
      opacity: var(--name-opacity, 0);
      z-index: 20;
      transition-name: translate, opacity;
      transition-delay: 150ms;
      transition-duration: 300ms;
      transition-timing-function: cubic-bezier(0.47, 1.64, 0.41, 0.8), ease-in-out;
    }

    /* all hover effects as custom properties */
    .avatar:hover {
      --img-scale: 1.1;
      --img-shadow: drop-shadow(10px 15px 4px rgba(0 0 0 / 0.5));
      --name-y: 0;
      --name-opacity: 1;
      --bg-blur: var(--bg-blur-hover);
    }
  }

  .container {
    margin: 2% 0;
  }

  .rw-mn {
    margin: 6% 0px;
  }

  .rw-mn .bx-tt {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .bx-ct {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 4% 0;
  }
</style>