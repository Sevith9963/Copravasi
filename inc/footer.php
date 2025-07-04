<!-- Footer -->
<footer class="footer py-4 bg-dark text-white">
  <div class="container">
    <div class="row align-items-center">
      <!-- Left -->
      <div class="col-lg-4 text-lg-start text-center mb-3 mb-lg-0">
        &copy; <?php echo $_settings->info('short_name') ?> 2025
      </div>

      <!-- Center: Social Media -->
      <div class="col-lg-4 text-center mb-3 mb-lg-0">
        <a class="btn btn-outline-light btn-social mx-2" href="#"><i class="fab fa-whatsapp"></i></a>
        <a class="btn btn-outline-light btn-social mx-2" href="https://www.instagram.com/co_pravasi?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i></a>
      </div>

      <!-- Right -->
      <div class="col-lg-4 text-lg-end text-center">
        <a class="link-light text-decoration-none me-3" href="javascript:void(0)" id="p_use">Privacy Policy</a><br>
        <span>Developed by: <a class="text-warning" href="https://rad-mousse-23a8d3.netlify.app/" target="_blank">Sevith</a></span><br>
        <small>📞 +91 9876543210 | ✉️ support@copravasi.com</small><br>
        <small>📍 1st cross behind petrol bunk batawadi tumakuru 572103</small>
      </div>
    </div>
  </div>
</footer>

<!-- Viewer Modal + Uni Modal + Confirm Modal Scripts -->
<script>
  $(document).ready(function () {
    // Privacy Policy trigger
    $('#p_use').click(function () {
      uni_modal("Privacy Policy", "policy.php", "mid-large");
    });

    // Image/Video Viewer Modal
    window.viewer_modal = function ($src = '') {
      start_loader();
      var ext = $src.split('.').pop().toLowerCase();
      var view = (ext === 'mp4')
        ? $("<video src='" + $src + "' controls autoplay></video>")
        : $("<img src='" + $src + "' class='img-fluid' />");

      $('#viewer_modal .modal-content video, #viewer_modal .modal-content img').remove();
      $('#viewer_modal .modal-content').append(view);
      $('#viewer_modal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,
        focus: true
      });
      end_loader();
    }

    // Universal Modal
    window.uni_modal = function ($title = '', $url = '', $size = "") {
      start_loader();
      $.ajax({
        url: $url,
        error: err => {
          console.error(err);
          alert("An error occurred");
        },
        success: function (resp) {
          if (resp) {
            $('#uni_modal .modal-title').html($title);
            $('#uni_modal .modal-body').html(resp);
            if ($size !== '') {
              $('#uni_modal .modal-dialog').attr('class', 'modal-dialog ' + $size + ' modal-dialog-centered');
            } else {
              $('#uni_modal .modal-dialog').attr('class', 'modal-dialog modal-md modal-dialog-centered');
            }
            $('#uni_modal').modal({
              show: true,
              backdrop: 'static',
              keyboard: false,
              focus: true
            });
            end_loader();
          }
        }
      });
    }

    // Confirmation Modal
    window._conf = function ($msg = '', $func = '', $params = []) {
      $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
      $('#confirm_modal .modal-body').html($msg);
      $('#confirm_modal').modal('show');
    }
  });
</script>

<!-- JS Plugins -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url ?>plugins/sparklines/sparkline.js"></script>
<script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo base_url ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url ?>dist/js/adminlte.js"></script>
