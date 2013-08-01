      </section>
      <footer>        
        <nav id="footer_menu">
          <ul class="nav navbar-nav">
            <li> <a href="#">Support</a> </li>
            <li> <a href="#">Check Your Local Showtimes</a> </li>
            <li> <a href="#">Terms Of Use</a> </li>
            <li> <a href="#">Privacy Policy</a> </li>
            <li> <a>TM & 2013 Warner Bros. Entertainment INC. All Rights Reserved</a> </li>
          </ul>
        </nav>
        <img src="/images/warner_bros_logo.png" />        
      </footer>
  	</section>
  	<!-- Render Javascript -->
  	<script src="/js/libs/jquery.min.js"></script>
  	<script src="/js/libs/angularjs.min.js"></script>
  	<script src="/js/libs/bootstrap.min.js"></script>
  	<script src="/js/libs/modernizr.min.js"></script>
  	<script src="/js/libs/jwplayer/jwplayer.js"></script>
  	<script src="/js/libs/lightbox/js/lightbox-2.6.min.js"></script>
  	<script src="/js/app.js"></script>
    <?php if(isset($scriptsToBeRendered)){
      foreach ($scriptsToBeRendered as $url) {
      ?>
        <script src="<?php echo $url; ?>"></script>
      <?php
      }
    }
    ?>
	</body>
</html>