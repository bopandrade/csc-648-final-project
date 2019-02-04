<footer class="footer">
  <ul class="nav navbar-nav navbar-left">
    <li><a href="<?php echo URL . 'home/about/' ?>">About</a></li>
    <li><a href="<?php echo URL . 'home/privacy_policy' ?>">Privacy Policy</a></li>
  </ul>
</footer>
    <!-- backlink to repo on GitHub, and affiliate link to Rackspace if you want to support the project -->
    <!-- jQuery, loaded in the recommended protocol-less way -->
    <!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
    <script>
        var url = "<?php echo URL; ?>";
    </script>

    <!-- our JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script> -->

    <script src="<?php echo URL; ?>js/application.js"></script>
    <script src="<?php echo URL; ?>js/listing.js"></script>
    <script src="<?php echo URL; ?>js/flash_message.js"></script>

</body>
</html>
