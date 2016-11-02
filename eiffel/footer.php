          
          </div>
        </section>
      </section>
      <footer class="site-footer">
          <div class="text-right">
              Desenvolvido por <a href="https://github.com/mauricioribeiro" target="_blank">Mauricio Ribeiro</a>
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>

    </section>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script> 
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <script src="assets/js/bootstrap-switch.js"></script>
    <?php 
      if(!is_null($EIFFEL->getConfig('header-status'))) echo '<script>$(document).ready(function(){ $("#header-status").html("'.$EIFFEL->getConfig('header-status').'").css("border","1px solid #B9DCF5"); });</script>';
    ?>
  </body>
</html>