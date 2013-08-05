      </section>
      <footer>        
        <nav id="footer_menu">
          <ul class="nav navbar-nav">
            <li> <a href="/contact_us">Support</a> </li>
            <li> <a href="/local_listings">Check Your Local Showtimes</a> </li>
            <li> <a href="http://www.warnerbros.com/#/page=terms-of-use/" target="_blank">Terms Of Use</a> </li>
            <li> <a href="http://www.warnerbros.com/#/page=privacy-policy/" target="_blank">Privacy Policy</a> </li>
            <li> <a>TM & 2013 Warner Bros. Entertainment INC. All Rights Reserved</a> </li>
          </ul>
        </nav>
        <img src="/images/warner_bros_logo.jpg" />        
      </footer>
  	</section>
  	<!-- Render Javascript -->
  	<script src="/js/libs/jquery.min.js"></script>
  	<script src="/js/libs/lodash.min.js"></script>
  	<script src="/js/libs/angularjs.min.js"></script>
  	<script src="/js/libs/angular-ui-bootstrap-custom.min.js"></script>
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
