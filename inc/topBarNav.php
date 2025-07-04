<!-- Navigation -->
<style>
  #mainNav {
    transition: all 0.3s ease-in-out;
    background: linear-gradient(135deg, #004e92, #000428);
    font-family: 'Segoe UI', sans-serif;
    padding-top: 1.2rem;
    padding-bottom: 1.2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
  }

  .navbar-brand span {
    font-size: 1.8rem;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: 2px;
    transition: all 0.3s ease;
    text-transform: uppercase;
  }

  .navbar-brand:hover span {
    color: #00eaff;
    text-shadow: 0 0 10px #00eaff;
  }

  .navbar-brand img {
    height: 50px;
    width: 50px;
    object-fit: cover;
    border: 2px solid #00eaff;
    margin-right: 14px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
  }

  .navbar-nav .nav-link {
    color: #ffffff;
    font-size: 1.1rem;
    font-weight: 600;
    padding: 0.6rem 1.1rem;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .navbar-nav .nav-link:hover {
    color: #00eaff;
    transform: translateY(-2px);
  }

  .nav-link.btn {
    border-radius: 30px;
    transition: background 0.3s, color 0.3s;
    font-size: 1.05rem;
    border: 2px solid #00eaff;
    color: #00eaff !important;
  }

  .nav-link.btn:hover {
    background-color: #00eaff;
    color: #000 !important;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#page-top">
      <img src="assets/img/logo.png" alt="Copravasi Logo" class="rounded-circle">
      <span>Copravasi</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto text-uppercase">
        <li class="nav-item px-2">
          <a class="nav-link" href="<?php echo $page !='home' ? './':'' ?>">Home</a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link" href="./?page=packages">Packages</a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link" href="<?php echo $page !='home' ? './':'' ?>#about">About</a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link" href="<?php echo $page !='home' ? './':'' ?>#contact">Contact</a>
        </li>
        <?php if(isset($_SESSION['userdata'])): ?>
        <li class="nav-item px-2">
          <a class="nav-link" href="./?page=my_account">
            <i class="fa fa-user"></i> Hi, <?php echo $_settings->userdata('firstname') ?>!
          </a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link" href="logout.php">
            <i class="fa fa-sign-out-alt"></i>
          </a>
        </li>
        <?php else: ?>
        <li class="nav-item px-2">
          <a class="nav-link btn px-3 py-1 ml-lg-3 mt-2 mt-lg-0" href="javascript:void(0)" id="login_btn">Login</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script>
  $(function () {
    $('#login_btn').click(function () {
      uni_modal("", "login.php", "large");
    });

    $('#navbarResponsive').on('show.bs.collapse', function () {
      $('#mainNav').addClass('navbar-shrink');
    });

    $('#navbarResponsive').on('hidden.bs.collapse', function () {
      if ($(window).scrollTop() === 0) {
        $('#mainNav').removeClass('navbar-shrink');
      }
    });
  });
</script>