
<!-- Editor output -->
    <section class="auth-info">Logged in as <?php echo $config['editor_login_email']; ?></section>

    <section class="settings" id="settings">
        <ul class="tab-nav col-sm-3" id="tab-nav">
            <li><span aria-hidden="true" class="fa fa-globe"></span> &nbsp; <h3>Domains</h3></li>
            <li><span aria-hidden="true" class="fa fa-file-text-o"></span> &nbsp; <h3>Main Text</h3></li>
            <li><span aria-hidden="true" class="fa fa-envelope"></span> &nbsp; <h3>Offer Form</h3></li>
            <li><span aria-hidden="true" class="fa fa-cog"></span> &nbsp; <h3>Footer</h3></li>
            <li><span aria-hidden="true" class="fa fa-picture-o"></span> &nbsp; <h3>Theme Style</h3></li>
            <li><span aria-hidden="true" class="fa fa-money"></span> &nbsp; <h3>Google Adsense</h3></li>
        </ul>
        <form action="?" method="post" id="editor-form">
            <ul class="tab-content col-sm-9" id="tab-content">
                                
                <!-- Domains -->
                <li>
                    <div class="fields">
                        <div class="fields-column col-sm-12">
                            <div class="field-wrapper">
                                <div id="domain_portfolio">
                                    <table class="domain-portfolio-table">
                                        <thead>
                                            <tr>
                                                <th>Domain</th>
                                                <th>Price</th>
                                                <th>Price Description</th>
                                                <th>Stat Description</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach( $domains as $domain => $arr ): ?>
                                                <tr>
                                                    <td><input type="text" name="portfolio_domain[]" class="text-field" placeholder="e.g. domain.com" value="<?php echo $domain; ?>"></td>
                                                    <td><input type="text" name="portfolio_price[]" class="text-field" placeholder="e.g. £500" value="<?php echo $arr['price']; ?>"></td>            
                                                    <td><input type="text" name="portfolio_price_description[]" class="text-field" placeholder="e.g. buy now" value="<?php echo $arr['price_description']; ?>"></td>
                                                        <td><input type="text" name="portfolio_description[]" class="text-field" placeholder="e.g. premium domain" value="<?php echo $arr['description']; ?>"></td>
                                                    <td><button class="editor-btn small-btn delete-btn">&times;</button></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <button class="editor-btn small-btn add-domain-btn">+ &nbsp; Add Domain</button>
                                </div>
                            </div>
                        </div>
                        <div class="fields-column col-sm-12">
                            <p><strong>Notes:</strong> when entering the domain, leave out the "http://". Price, Description and Stat Description fields are optional.</p>
                            <div class="field-wrapper long">
                                <span>
                                <input 
                                    type="checkbox" 
                                    name="enable_domain_portfolio"
                                    id="enable_domain_portfolio" 
                                    class="checkbox-field"
                                    <?php if ($config['enable_domain_portfolio']): ?>
                                        checked="checked"
                                    <?php endif; ?>
                                >
                                <label for="enable_domain_portfolio">More Domains</label>
                              </span>
                            </div>
                            <p style="display:none" class="domain-portfolio-note">
                                <strong>Note:</strong> enabling/disabling the domain portfolio requires you to refresh the page before seeing the change. Save first, though!
                            </p>
                        </div>
                    </div>
                </li>
                <!-- /Domains -->
                
                <!-- Header Text -->
                <li>
                    <div class="fields">
                        <div class="fields-column col-sm-9">
                            <div class="field-wrapper">
                                <label for="header_text">Text next to the domain name</label>
                                <input 
                                    type="text" 
                                    name="header_text"
                                    id="header_text" 
                                    class="text-field"
                                    placeholder="Example: Is now for sale"

                                    value="<?php echo $config['header_text']; ?>"
                                >
                            </div>
                            <div class="field-wrapper">
                                <label for="header_subtext">Text under the domain name</label>
                                <input 
                                    type="text" 
                                    name="header_subtext"
                                    id="header_subtext" 
                                    class="text-field"
                                    placeholder="Example: Phone +00 000 000 0000"

                                    value="<?php echo $config['header_subtext']; ?>"
                                >
                            </div>
                            <p><strong>Note:</strong> This is optional if both boxes are left blank this section will not be shown.</p>
                        </div>
                    </div><!-- /fields -->
                </li>
                <!-- /Header Text -->
                
                <!-- Email -->
                <li>
                    <div class="fields">
                        <div class="fields-column col-sm-6">
                            <div class="field-wrapper">
                                <label for="recipient_name">Recipient Name</label>
                                <input 
                                    type="text" 
                                    name="recipient_name"
                                    id="recipient_name"
                                    placeholder="Enter Your Name Here"
                                    class="text-field"

                                    value="<?php echo $config['recipient_name']; ?>"
                                >
                            </div>
                            <div class="field-wrapper">
                                <label for="recipient_email">Recipient Email</label>
                                <input 
                                    type="email" 
                                    name="recipient_email"
                                    id="recipient_email" 
                                    placeholder="Enter Your Email Here"
                                    class="email-field"

                                    value="<?php echo $config['recipient_email']; ?>"
                                >
                            </div>
                            <p><strong>Note:</strong> to help make sure emails sent from the contact form don't arrive in your spam folder, edit the SMTP settings in the includes/config.php file directly.</p>
                        </div>
                        <div class="fields-column col-sm-6">
                            <div class="field-wrapper">
                                <label for="recaptcha_public_key">reCAPTCHA Site Key</label>
                                <input 
                                    type="text" 
                                    name="recaptcha_public_key"
                                    id="recaptcha_public_key" 
                                    placeholder="Enter Your Recaptcha Site Key Here"
                                    class="text-field"

                                    value="<?php echo $config['recaptcha_public_key']; ?>"
                                >
                            </div>
                            <div class="field-wrapper">
                                <label for="recaptcha_private_key">reCAPTCHA Private Key</label>
                                <input 
                                    type="text" 
                                    name="recaptcha_private_key"
                                    id="recaptcha_private_key" 
                                    placeholder="Enter Your Recaptcha Private Key Here"
                                    class="text-field"

                                    value="<?php echo $config['recaptcha_private_key']; ?>"
                                >
                            </div>
                            <div class="field-wrapper long">
                                <span>
                                <input 
                                    type="checkbox" 
                                    name="enable_recaptcha"
                                    id="enable_recaptcha" 
                                    class="checkbox-field"
                                    <?php if ($config['enable_recaptcha']): ?>
                                        checked="checked"
                                    <?php endif; ?>
                                >
                                <label for="enable_recaptcha">reCAPTCHA spam protection</label>
                                    </span>
                            </div>
                            <p style="display:none" class="recaptcha-note">
                                <strong>Note:</strong> enabling/disabling reCAPTCHA requires you to refresh the page before seeing the change. Save first, though!
                            </p>
                        </div><!-- /fields-column -->
                    </div><!-- /fields -->
                </li>
                <!-- /End Email -->
                
                <!-- Social Icons -->
                <li>
                    <div class="col-sm-12">
                    <div class="field-wrapper footer">
                        <span>
                            <input 
                                type="checkbox" 
                                name="enable_social"
                                id="enable_social" 
                                class="checkbox-field"
                                <?php if ($config['enable_social']): ?>
                                checked="checked"
                            <?php endif; ?>
                                >
                                <label for="enable_social">Social Footer Section</label>
                            </span>
                         </div>
                    <p><strong>Note:</strong> Just enter your Profile ID/Number without e.g. http://twitter.com. If any boxes or text are left blank they will not be shown.</p>
                    <div class="fields">
                        <div class="field-wrapper long">
                            <label for="footer_text">Text Above Social Icons</label>
                            <input 
                                type="text" 
                                name="footer_text"
                                id="footer_text" 
                                class="text-field"
                                placeholder="e.g. Let's get connected!"
                                value="<?php echo $config['footer_text']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="twitter_handle">Twitter ID</label>
                            <input 
                                type="text" 
                                name="twitter_handle"
                                id="twitter_handle" 
                                class="text-field"
                                placeholder="e.g. domainseller"
                                value="<?php echo $config['twitter_handle']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="facebook_handle">Facebook ID</label>
                            <input 
                                type="text" 
                                name="facebook_handle"
                                id="facebook_handle" 
                                class="text-field"
                                placeholder="e.g. domainseller"
                                value="<?php echo $config['facebook_handle']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="instagram_handle">Instagram_ID</label>
                            <input 
                                type="text" 
                                name="instagram_handle"
                                id="instagram_handle" 
                                class="text-field"
                                placeholder="e.g. domainseller"
                                value="<?php echo $config['instagram_handle']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="googleplus_handle">Google Plus ID</label>
                            <input 
                                type="text" 
                                name="googleplus_handle"
                                id="googleplus_handle" 
                                class="text-field"
                                placeholder="e.g. domainseller"
                                value="<?php echo $config['googleplus_handle']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="linkedin_handle">Linkedin ID</label>
                            <input 
                                type="text" 
                                name="linkedin_handle"
                                id="linkedin_handle" 
                                class="text-field"
                                placeholder="e.g. domainseller"
                                value="<?php echo $config['linkedin_handle']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="youtube_handle">Youtube ID</label>
                            <input 
                                type="text" 
                                name="youtube_handle"
                                id="youtube_handle" 
                                class="text-field"
                                placeholder="e.g. domainseller"
                                value="<?php echo $config['youtube_handle']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="pinterest_handle">Pinterest ID</label>
                            <input 
                                type="text" 
                                name="pinterest_handle"
                                id="pinterest_handle" 
                                class="text-field"
                                placeholder="e.g. domainseller"
                                value="<?php echo $config['pinterest_handle']; ?>"
                            >
                        </div>
                    </div>
                  </div>
                </li>
                <!-- Background -->
                <li>
                  <div class="col-sm-12">
                    <div class="fields">
                        <div class="field-wrapper long">
                            <label for="tint">Color Styles</label>
                            <br>
                            <label class="select-color">
                            <input 
                                type="color" 
                                name="tint"
                                id="tint" 
                                class="color-field"
                                value="<?php echo $config['tint']; ?>"
                                   
                            <label for="tint">Background Color</label>
                            </label>

                            <label class="select-color">
                            <input 
                                type="color" 
                                name="text_color"
                                id="text_color" 
                                class="color-field"
                                value="<?php echo $config['text_color']; ?>"
                        <label for="text_color">Text Color</label>
                        
                            </label>
                            <label class="select-color">
                            <input 
                                type="color" 
                                name="theme_color"
                                id="theme_color" 
                                class="color-field"
                                value="<?php echo $config['theme_color']; ?>"
                        <label for="theme_color">Theme Color</label>
                            </label>
                                   
                        <div class="field-wrapper long">
                            <label>Image</label>
                            <br>
                            <label>
                                <input 
                                    type="radio"
                                    name="image"
                                    value=""
                                    class="radio-input"
                                    <?php if( $config['image'] == ''): ?>
                                        checked="checked"
                                    <?php endif; ?>
                                >
                                <div class="thumb-wrapper scale">
                                    <img src="http://placehold.it/100/333333/cccccc?text=None" alt="">
                                </div>
                            </label>
                            <?php foreach( $backgrounds as $bg ) : ?>
                                <label>
                                    <input 
                                        type="radio"
                                        name="image"
                                        value="<?php echo $bg; ?>"
                                        class="radio-input"
                                        <?php if( $config['image'] == $bg): ?>
                                            checked="checked"
                                        <?php endif; ?>   
                                    >
                                    <div class="thumb-wrapper scale">
                                        <img src="assets/images/bg-<?php echo $bg; ?>.jpg" alt="">
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="field-wrapper long">
                            <label>Texture</label>
                            <br>
                            <label>
                                <input 
                                    type="radio"
                                    name="texture"
                                    value=""
                                    class="radio-input"
                                    <?php if( $config['texture'] == ''): ?>
                                        checked="checked"
                                    <?php endif; ?>
                                >
                                <div class="thumb-wrapper scale">
                                    <img src="http://placehold.it/100/333333/cccccc?text=None" alt="">
                                </div>
                            </label>
                            <?php foreach( $textures as $tex ) : ?>
                                <label>
                                    <input 
                                        type="radio"
                                        name="texture"
                                        value="<?php echo $tex; ?>"
                                        class="radio-input"
                                        <?php if( $config['texture'] == $tex): ?>
                                            checked="checked"
                                        <?php endif; ?>                                        
                                    >
                                    <div class="thumb-wrapper">
                                        <img src="assets/images/texture-<?php echo $tex; ?>.png" alt="">
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div><!-- /fields -->
                  </div>
               </li><!-- /END BACKGROUND -->
                <!-- GOOGLE ADSENSE -->
                <li>
                    <div class="col-sm-12">
                    <div class="field-wrapper footer">
                        <span>
                            <input 
                                type="checkbox" 
                                name="enable_adsense"
                                id="enable_adsense" 
                                class="checkbox-field"
                                <?php if ($config['enable_adsense']): ?>
                                checked="checked"
                            <?php endif; ?>
                                >
                                <label for="enable_adsense">Google Adsense</label>
                            </span>
                         </div>
                        <div class="field-wrapper">
                            <label for="client_handle">Client ID</label>
                            <input 
                                type="text" 
                                name="client_handle"
                                id="client_handle" 
                                class="text-field"
                                placeholder="e.g. ca-pub-5454202103715218"
                                value="<?php echo $config['client_handle']; ?>"
                            >
                        </div>
                        <div class="field-wrapper">
                            <label for="slot_handle">Slot ID</label>
                            <input 
                                type="text" 
                                name="slot_handle"
                                id="slot_handle" 
                                class="text-field"
                                placeholder="e.g. 1513516485"
                                value="<?php echo $config['slot_handle']; ?>"
                            >
                        </div>
                    </div>
                </li><!-- /END GOOGLE ADSENSE -->
            </ul>
        </form>
        <div class="settings-btn-wrap">
            <button id="settings-btn" class="editor-btn settings-btn">
            <i class="fa fa-cog" aria-hidden="true"></i>&nbsp; settings
            </button>
            <button id="save-btn" class="editor-btn save-btn">
            <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp; 
                <span class="regular">save</span>
                <span style="display:none" class="saving">saving &nbsp; &nbsp; &nbsp; </span>
                <span class="error"><ul></ul></span>
            </button>
        </div>
    </section>
    <!-- Templates -->
    <table id="domain_portfolio_row_template" style="display:none">
        <tr>
            <td><input type="text" name="portfolio_domain[]" class="text-field"></td>
            <td><input type="text" name="portfolio_price[]" class="text-field"></td>
            <td><input type="text" name="portfolio_price_description[]" class="text-field"></td>
            <td><input type="text" name="portfolio_description[]" class="text-field"></td>
            <td><button class="editor-btn small-btn delete-btn">&times;</button></td>
        </tr>
    </table>
    <!-- End Templates -->
    <script src="assets/js/editor.js"></script>
<!-- end Editor output -->