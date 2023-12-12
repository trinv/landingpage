<?php
    require_once('config.php');
    require_once('includes/functions.php');
    require_once('includes/process-form.php');
    // Convert domain names to lower case, just in case!
    $domains = array_change_key_case($domains, CASE_LOWER);
    // Start up the editor if ?editor is added to the end of the URL
    if( isset($_GET['editor']) ) {
        include_once('includes/editor.php');
    }
?><!doctype html>
<html>
<head>
    
    <meta charset="utf-8">
    
    <!-- Load Font -->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">

    <!-- Page Title -->
    <title><?php echo $_SERVER['HTTP_HOST']; ?> is for sale</title>

    <!-- Page Description -->
    <meta name="description" content="">
    
    <!-- Set the viewport to the device's screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Icon -->
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/images/icons/favicon.png">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/design.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <style>
        /* Background Image */
        body {
            background-image: url('assets/images/bg-<?php echo $config['image']; ?>.jpg');
        }
        /* Text Color styles */
        body {   
            <?php if( $config['text_color'] != '' ): ?>
                color: rgba(<?php echo hex2rgb($config['text_color']); ?>, 1);
            <?php endif; ?>
        }
        /* Theme Color styles */
        span.theme_color, a {   
            <?php if( $config['theme_color'] != '' ): ?>
                color: rgba(<?php echo hex2rgb($config['theme_color']); ?>, 1);
            <?php endif; ?>
        }
        a:hover {   
            <?php if( $config['theme_color'] != '' ): ?>
                color: rgba(<?php echo hex2rgb($config['theme_color']); ?>, 0.7);
            <?php endif; ?>
        }
        .send-btn {   
            <?php if( $config['theme_color'] != '' ): ?>
                background-color: rgba(<?php echo hex2rgb($config['theme_color']); ?>, 1);
            <?php endif; ?>
        }
        /* Background Styles */
        body:after {
            <?php if( $config['tint'] != '' ): ?>
                background-color: rgba(<?php echo hex2rgb($config['tint']); ?>, .7);
            <?php endif; ?>
            <?php if( $config['texture'] != '' ): ?>
                background-image: url('assets/images/texture-<?php echo $config['texture']; ?>.png');
            <?php endif; ?>
        }
          .bg-color {
              <?php if( $config['tint'] != '' ): ?>
                background-color: rgba(<?php echo hex2rgb($config['tint']); ?>, 0.8);
            <?php endif; ?>
        }
          #menu {
              <?php if( $config['tint'] != '' ): ?>
                background-color: rgba(<?php echo hex2rgb($config['tint']); ?>, 1);
            <?php endif; ?>
        }
    </style>
    <![endif]-->

    <!-- Include jQuery with local fallback -->
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery-1.12.3.min.js"><\/script>')</script>
    
    <!-- jQuery plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/jquery.big-slide.js"></script>
    
    <!-- JavaScript that runs on document load and document ready -->
    <script src="assets/js/main.js"></script>

    <!-- reCAPTCHA -->
    <?php if( $config['enable_recaptcha'] === true ) : ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php endif; ?>

</head>
<body>
 <div class="wrap push">
    <!-- Main -->
    <section id="main" class="container">   
    <!-- Title and price -->
         <div class="col-md-7 left">
          <h1>Domain for sale<span class="theme_color">.</span></h1>
             
             <?php if( $config['enable_adsense'] === true ) : ?>
            <div class="adsense">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- domain seller -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="<?php echo $config['client_handle']; ?>"
                     data-ad-slot="<?php echo $config['slot_handle']; ?>"
                     data-ad-format="link"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
             </div>
             <?php endif; ?>
             
             <div class="intro">
                    <span class="theme_color">
                        <?php 
                        if( isset($domains[$_SERVER['HTTP_HOST']]['nicename']) ) {
                            echo $domains[$_SERVER['HTTP_HOST']]['nicename'];
                        } else {
                            echo $_SERVER['HTTP_HOST']; 
                        }
                    ?>
                </span>
            <?php if( $config['header_text'] != '' ): ?>
              <?php echo $config['header_text']; ?>
                <?php endif; ?>
                 <div class="intro-subtext">
            <?php if( $config['header_subtext'] != '' ): ?>
            <?php echo $config['header_subtext']; ?>
                <?php endif; ?> 
              </div>
            </div>
             <div class="minimum-bid">
                    <?php 
                if( 
                    isset( $domains[$_SERVER['HTTP_HOST']] )
                    && $domains[$_SERVER['HTTP_HOST']]['price'] != ''
                ): 
            ?> 
            <span class="border-top"></span>
                 <span class="theme_color"> 
               <?php echo $domains[$_SERVER['HTTP_HOST']]['price']; ?>
                    <?php endif; ?>
                    </span>  
                     <?php 
                if( 
                    isset( $domains[$_SERVER['HTTP_HOST']] )
                    && $domains[$_SERVER['HTTP_HOST']]['price_description'] != ''
                ): 
            ?>
               <p><?php echo $domains[$_SERVER['HTTP_HOST']]['price_description']; ?></p>
                    <?php endif; ?>
             </div>
          </div>
    <!-- /End Title and Price -->          
    <!-- Offer form -->
   <div class="col-md-5">
       <div class="bg-color">
            <form action="?" method="post" class="offer-form" id="offer-form">
                <h2 class="input">Submit your offer</h2>
                <span class="theme_color input">
                <?php 
                    if( 
                        isset( $domains[$_SERVER['HTTP_HOST']] )
                        && $domains[$_SERVER['HTTP_HOST']]['description'] != ''
                    ): 
                ?>
                    <p><?php echo $domains[$_SERVER['HTTP_HOST']]['description']; ?></p>
                <?php endif; ?>
                <?php 
                    $error_style = 'display: none;';
                    if( isset($error) && $error != '' ) {
                        $error_style = '';
                    }
                ?>
                    </span>
                <div class="form-error animated shake" style="<?php echo $error_style; ?>">
                    <span aria-hidden="true" class="icon fa fa-exclamation-triangle"></span>
                    <p>Please correct the following and resubmit, thanks!</p>
                    <ul><?php if( isset($error) ) { echo $error; } ?></ul>
                </div>
                <?php 
                    $success_style = 'display: none;';
                    if( isset($success) && $success === true ) {
                        $success_style = '';
                    }
                ?>
                <div class="form-success animated zoomInDown" style="<?php echo $success_style; ?>">
                    <span aria-hidden="true" class="icon fa fa-thumbs-o-up"></span>
                    <?php if( isset($success) ) { echo $success; } ?>
                </div>
                <?php if( $success_style != '' ): ?>
                    <div class="fields input">
                        <div class="field-wrapper border">
                            <label for="name" class="name-label">Full Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                placeholder="* Full Name" 
                                class="text-field"
                                required
                                minlength="2"
                                value=""
                            >
                        </div>
                        <div class="field-wrapper border">
                            <label for="email" class="email-label">Email</label>
                            <input 
                                type="text" 
                                name="email" 
                                id="email" 
                                placeholder="* Email Address" 
                                class="email-field"
                                required
                                minlength="5"
                                value=""
                            >
                        </div>
                         <div class="field-wrapper border">
                            <label for="phone" class="phone-label">Phone</label>
                            <input 
                                type="text" 
                                name="phone" 
                                id="phone" 
                                placeholder="* Phone Number" 
                                class="text-field"
                                required
                                minlength="5"
                                value=""
                            >

                        </div>
                      <div class="field-wrapper border">
                            <form class="form-inline">
                                 <label for="offer" class="offer-label">Offer</label>
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                  <div class="input-group-addon currency-symbol">$</div>
                                  <input type="text" name="offer" class="form-control currency-amount offer" placeholder="0.00" size="8">
                                  <div class="input-group-addon currency-addon">
                                    <select class="currency-selector" name="currency">
                                      <option data-symbol="$" data-placeholder="* 0.00" selected>USD</option>
                                      <option data-symbol="€" data-placeholder="* 0.00">EUR</option>
                                      <option data-symbol="£" data-placeholder="* 0.00">GBP</option>
                                      <option data-symbol="¥" data-placeholder="* 0">JPY</option>
                                      <option data-symbol="$" data-placeholder="* 0.00">CAD</option>
                                      <option data-symbol="$" data-placeholder="* 0.00">AUD</option>
                                    </select>

                                  </div>
                                </div>
                            </form>
                        </div>
                        <?php if( $config['enable_recaptcha'] === true ) : ?>
                            <div class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha_public_key']; ?>"></div>
                        <?php endif; ?>
                        <div class="field-wrapper send-btn-wrapper">
                            <input type="submit" name="send" value="send" class="send-btn">
                        </div>
                        <div class="col-md-12 required">
                        <p><span>*</span> Indicates Required Field.</p>
                        </div>
                    </div><!-- /fields -->
                <?php endif; ?>
            </form>
          </div>
       </div><!-- /End Offer Form -->
   </section><!-- /End Main -->
<!-- Footer -->
<section id="footer" class="bg-color">
    <div class="container">
        <?php if( $config['enable_social'] === true ) : ?>
        <div class="col-md-6 left">
            <p><?php if( $config['footer_text'] != '' ): ?>
              <?php echo $config['footer_text']; ?></p>
                <?php endif; ?>
          <ul class="social-links">
            <?php if( $config['twitter_handle'] != '' ): ?>
              <li><a href="https://twitter.com/<?php echo $config['twitter_handle']; ?>" target="_blank"><i class="icon-twitter-sign"></i></a></li>
            <?php endif; ?>
              <?php if( $config['facebook_handle'] != '' ): ?>
              <li><a href="https://facebook.com/<?php echo $config['facebook_handle']; ?>" target="_blank"><i class="icon-facebook-sign"></i></a></li>
            <?php endif; ?>
              <?php if( $config['instagram_handle'] != '' ): ?>
              <li><a href="https://instagram.com/<?php echo $config['instagram_handle']; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
            <?php endif; ?>
              <?php if( $config['googleplus_handle'] != '' ): ?>
              <li><a href="https://plus.google.com/+<?php echo $config['googleplus_handle']; ?>" target="_blank"><i class="icon-google-plus-sign"></i></a></li>
            <?php endif; ?>
              <?php if( $config['linkedin_handle'] != '' ): ?>
              <li><a href="https://www.linkedin.com/in/<?php echo $config['linkedin_handle']; ?>" target="_blank"><i class="icon-linkedin-sign"></i></a></li>
            <?php endif; ?>
              <?php if( $config['youtube_handle'] != '' ): ?>
              <li><a href="https://youtube.com/user/<?php echo $config['youtube_handle']; ?>" target="_blank"><i class="icon-youtube-sign"></i></a></li>
            <?php endif; ?>
              <?php if( $config['pinterest_handle'] != '' ): ?>
              <li><a href="https://pinterest.com/<?php echo $config['pinterest_handle']; ?>" target="_blank"><i class="icon-pinterest-sign"></i></a></li>
            <?php endif; ?>
              </ul>
            </div>
        <div class="col-md-6 right">
          <div class="copyright">
          <!-- Page Title -->
          <p>&copy; <?php echo date("Y") ?> <span class="theme_color"><?php echo $_SERVER['HTTP_HOST']; ?></span>, All Rights Reserved</p>
     </div><!--/ .developed-->
    </div>
  <?php endif; ?>
 </section><!-- End Footer -->
    <!-- Domain Portfolio -->
      <?php if( $config['enable_domain_portfolio'] === true ): ?>
              <nav id="menu" class="panel" role="navigation">
            <button id="#menu" class="more-domains-btn close-menu">
            <span class="theme_color">
            <span><i class="fa fa-times" aria-hidden="true"></i>
               </span>close menu
                </button>
                </span>
                  <h3>more domains for sale</h3>
                  <ul>
                <?php foreach( $domains as $domain => $value ): ?>
                    <li>
                        <a href="http://<?php echo $domain; ?>">
                            <?php 
                                if( isset($value['nicename']) ) {
                                    echo $value['nicename'];
                                } else {
                                    echo $domain; 
                                }
                            ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                      </ul>
            </nav>
                <a href="#menu" class="menu-link"></a>
        <button id="#menu" class="more-domains-btn bg-color">
            <span><i class="fa fa-plus-circle" aria-hidden="true"></i>
            </span>more domains
        </button>
        </aside>
    <?php endif; ?>
    <?php 
        if( isset($_GET['editor']) ) {
            // Include Editor template
            include_once('includes/editor-view.php');
        }
    ?>
 </div>
</body>
</html>