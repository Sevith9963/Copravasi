<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('config.php'); ?>
<?php require_once('inc/header.php') ?>
<body class="hold-transition layout-top-nav">
  
  <?php 
    $page = isset($_GET['page']) ? $_GET['page'] : 'portal';  
    require_once('inc/topBarNav.php'); 
  ?>

  <?php 
    if (!file_exists($page . ".php") && !is_dir($page)) {
      include '404.html';
    } else {
      if (is_dir($page))
        include $page . '/index.php';
      else
        include $page . '.php';
    }
  ?>

  <script>
    $(function(){
      if ($('header.masthead').length <= 0)
        $('#mainNav').addClass('navbar-shrink');
    });
  </script>

  <?php require_once('inc/footer.php') ?>

  <!-- Confirm Modal -->
  <div class="modal fade text-dark" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm'>Continue</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Universal Modal -->
  <div class="modal fade text-dark rounded-0" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Side Modal -->
  <div class="modal fade text-dark" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="fa fa-arrow-right"></span>
          </button>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>

  <!-- Viewer Modal -->
  <div class="modal fade text-dark" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
        <img src="" alt="">
      </div>
    </div>
  </div>

 <!-- WhatsApp Floating Button with Pulse and Label -->
<a href="https://wa.me/919876543210" class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
  <div class="whatsapp-icon">
    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" />
  </div>
  <span class="whatsapp-label">Chat with us</span>
</a>


<style>
  .whatsapp-float {
    position: fixed;
    bottom: 85px;
    right: 20px;
    z-index: 999;
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
  }

  .whatsapp-icon {
    width: 64px;
    height: 64px;
    background-color: #25D366;
    border-radius: 50%;
    padding: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
    transition: transform 0.3s ease;
  }

  .whatsapp-icon:hover {
    transform: scale(1.1);
  }

  .whatsapp-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: brightness(0) invert(1);
  }

  .whatsapp-label {
    background: #25D366;
    color: #fff;
    padding: 10px 14px;
    border-radius: 25px;
    font-weight: 500;
    font-size: 14px;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .whatsapp-float:hover .whatsapp-label {
    opacity: 1;
  }

  @media (max-width: 768px) {
    .whatsapp-icon {
      width: 54px;
      height: 54px;
      padding: 10px;
    }

    .whatsapp-label {
      opacity: 1;
      font-size: 13px;
      padding: 8px 12px;
    }

    .whatsapp-float {
      bottom: 70px;
      right: 15px;
      flex-direction: row-reverse;
    }
  }

  @keyframes pulse {
    0% {
      box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
    }
    70% {
      box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
    }
    100% {
      box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
    }
  }
</style>

</body>
</html>
