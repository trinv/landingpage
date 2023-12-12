var settings = {};

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ?
        parseInt(result[1], 16) + ',' + parseInt(result[2], 16) + ',' + parseInt(result[3], 16)
    : null;
}

/**
 * Each time input is entered, update the corresponding output element
 */
function liveUpdateText(key, inputEl, outputEl) {
    inputEl.on('input', function() { 
        // Depending on the type of output needed, change the formatting
        switch(key) {
            case 'twitter_handle':
                outputEl.text( inputEl.val() );
                outputEl.attr( 'href', 'https://twitter.com/' + inputEl.val() );
                break;
            case 'facebook_handle':
                outputEl.text( inputEl.val() );
                outputEl.attr( 'href', 'https://facebook.com/' + inputEl.val() );
                break;
            case 'instagram_handle':
                outputEl.text( inputEl.val() );
                outputEl.attr( 'href', 'https://instagram.com/' + inputEl.val() );
                break;
            case 'googleplus_handle':
                outputEl.text( inputEl.val() );
                outputEl.attr( 'href', 'https://plus.google.com/+' + inputEl.val() );
                break;
            case 'linkedin_handle':
                outputEl.text( inputEl.val() );
                outputEl.attr( 'href', 'https://www.linkedin.com/in/' + inputEl.val() );
                break;
            case 'youtube_handle':
                outputEl.text( inputEl.val() );
                outputEl.attr( 'href', 'https://youtube.com/user/' + inputEl.val() );
                break;
            case 'pinterest_handle':
                outputEl.text( inputEl.val() );
                outputEl.attr( 'href', 'https://pinterest.com/' + inputEl.val() );
                break;
            default:
                outputEl.text( inputEl.val() );
        }
        
        // Update settings object with new value
        updateSetting( key, inputEl.val() );
    });
}

/**
 * Each time input is entered, update the corresponding setting
 */
function liveUpdateSetting(key, inputEl, isCheckbox) {
    var event = 'input';
    // Checkboxes require a different event to watch
    if( isCheckbox ) {
        event = 'change';
    }
        
// Domains
    if( key == 'domains' ) {
        $(inputEl).on(event, 'input', function() {
            var domains = [];
            var newItem;
            var domain = '';
            var price = '';
            var price_description = '';
            var description = '';
            $('tr', inputEl).each(function( ) { 
                domain = $(this).find('td:eq(0) input').val();
                price = $(this).find('td:eq(1) input').val();
                price_description = $(this).find('td:eq(2) input').val();
                description = $(this).find('td:eq(3) input').val();
                newItem = { domain: domain, price: price, price_description: price_description, description: description };
                domains.push(newItem);
            });
            updateSetting( key, domains );
        });
    } else { 
        // Regular inputs
        inputEl.on(event, function() {
            if( isCheckbox ) {
                updateSetting( key, inputEl.is(':checked') );
            } else {
                updateSetting( key, inputEl.val() );    
            }
        });
    }   
}

    /* Background Tint Color Input */
    function liveUpdateBackgroundColor(key, inputEl) {
    inputEl.on('input', function() {
        updateSetting( key, inputEl.val() );
        $('#' + key + '-style').remove();
        $('body').append($("<style id='" + key + "-style'>body:after { background-color: rgba(" + hexToRgb( inputEl.val() ) + ", .7); } </style>"));
        $('.bg-color').append($("<style id='" + key + "-style'>.bg-color { background-color: rgba(" + hexToRgb( inputEl.val() ) + ", 0.8); } </style>"));
        $('#menu').append($("<style id='" + key + "-style'>#menu { background-color: rgba(" + hexToRgb( inputEl.val() ) + ", 1); } </style>"));
    });
}

    /* Theme Text Color Input */
    function liveUpdateTextColor(key, inputEl) {
    inputEl.on('input', function() {
        updateSetting( key, inputEl.val() );
        $('body').append($("<style id='" + key + "-style'>body { color: rgba(" + hexToRgb( inputEl.val() ) + ", 1); } </style>"));
    });
}

    /* Theme Color Style Input */
    function liveUpdateThemeColor(key, inputEl) {
    inputEl.on('input', function() {
        updateSetting( key, inputEl.val() );
        $('span.theme_color').append($("<style id='" + key + "-style'>span.theme_color { color: rgba(" + hexToRgb( inputEl.val() ) + ", 1); } </style>"));
        $('a').append($("<style id='" + key + "-style'>a { color: rgba(" + hexToRgb( inputEl.val() ) + ", 1); } </style>"));
        $('a:hover').append($("<style id='" + key + "-style'>a:hover { color: rgba(" + hexToRgb( inputEl.val() ) + ", 0.7); } </style>"));
        $('.send-btn').append($("<style id='" + key + "-style'>.send-btn { background-color: rgba(" + hexToRgb( inputEl.val() ) + ", 1); } </style>"));
    });
}

/**
 * Each time the background input is updated, add a style tag
 */
function liveUpdateImage(key, inputEl) {
    inputEl.on('change', function() {
        updateSetting( key, $(inputEl).filter(':checked').val() );
        $('#' + key + '-style').remove();
        $('body').append($("<style id='" + key + "-style'>body { background-image: url(assets/images/bg-" + $(inputEl).filter(':checked').val() + ".jpg); } </style>"));
    });
}
/**
 * Each time the texture input is updated, add a style tag
 */
function liveUpdateTexture(key, inputEl) {
    inputEl.on('change', function() {
        updateSetting( key, $(inputEl).filter(':checked').val() );
        $('#' + key + '-style').remove();
        $('body').append($("<style id='" + key + "-style'>body:after { background-image: url(assets/images/texture-" + $(inputEl).filter(':checked').val() + ".png); } </style>"));
    });
}

/**
 * Each time domains are updated, 
 * update the domain portfolio and price/description
 * in the template
 */
function liveUpdateDomains(containerEl) {

    // When inputs change,
    // update the domain portfolio markup 
    $(containerEl).on('input', 'input', function() {

        var domains = [];
        var domainListMarkup = '';

        // Remove outdated list
        $('#domains').remove();
        
        // Append new list wrapper
        $('#portfolio').append($("<ul class='domains' id='domains'></ul>"));
        
        domains = settings['domains'];

        // Loop through each domain in the list
        for (var i = 0; i <= domains.length - 1; i++) {
            if(domains[i] != '') {
                // Create domain portfolio list markup
                domainListMarkup += "<li><a href='http://" + domains[i]['domain'] + "'>" + domains[i]['domain'] + "</a></li>";
                // Update template price/description if domain matches current domain
            if( $('.header .title').text() === domains[i]['domain'] ) {
                $('.price').text(domains[i]['price']);
                $('.price_description').text(domains[i]['price_decription']);
                $('.offer-form p:first-of-type').text(domains[i]['description']); 
                }
            }
        }

        // Insert markup in new list
        $('#domains').append($(domainListMarkup));
    });
}

/**
 * Trigger input on Domain Portfolio so settings array is also refreshed
 */
function triggerDomainsInput() {
    $('.domain-portfolio-table input').first().trigger('input');
}

// Update global settings object
function updateSetting( key, value ) {
    settings[key] = value;
    //console.log(settings);
}

$(function() { 
    
    // Tabs
    // --------------------------------------------------------------

    var tabNav = $('#tab-nav');
    var tabContent = $('#tab-content');

    // Toggle settings-open class
    $('#settings-btn').on('click', function() { 
        $('body').toggleClass('settings-open');
    });

    // Set first tab to be active
    $('li:first-child', tabNav).addClass('active');
    $('li:first-child', tabContent).addClass('active');

    // Switch tabs
    $('li', tabNav).on('click', function() { 
        var tabIndex = $(this).index();
        // Remove active class from all tabs and 
        // apply it to the current tab
        $('li', tabNav).removeClass('active');
        $('li', tabContent).removeClass('active');
        $(this).addClass('active');
        $('li:eq(' + tabIndex + ')', tabContent).addClass('active');
    });

    // Save Changes with save button
    // --------------------------------------------------------------    

    var editorForm = $('#editor-form');
    var saveBtn = $('.save-btn');
    
    // Watch the form and notify the user if they try to close the window with un-saved changes
    editorForm.dirtyForms();

    // Auto-save every second
    //autoSaveIntervId = setInterval(autoSave, 1000);

    /**
     * Click handler for Save button
     */

    $('.save-btn').on('click', function() { 
        saveChanges();
    });

    // loading indicator for save button
    var loader = jQuery('<div class="bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>')
        .appendTo('.save-btn')
        .hide();

    function autoSave() {
        // If the form is dirty there are changes to save
        if( $('#editor-form:dirty').length > 0 ) {
            // enable save button
            //saveBtn.prop('disabled', false);
            saveChanges();
        } else {
            // Disable save button, no changes to save
            //saveBtn.prop('disabled', true);
        }
    }

    function saveChanges() {
        // Add 'saving...' message
        $('.regular', saveBtn).hide();
        $('.saving', saveBtn).fadeIn();
        // Clear any error messages from past save attempts
        $('.error ul', saveBtn).html('');
        saveBtn.removeClass('animated shake');
        loader.show();
        // If the domain portfolio array is present in settings but empty, 
        // force it to be present in the upcoming AJAX request by inserting data
        if( 
            typeof settings['domains'] != 'undefined' 
            && settings['domains'].length === 0
        ) {
            settings['domains'][0] = {'domain': '', 'price': '', 'price_description': '', 'description': ''};
        }
        // Send AJAX request to save data
        $.post('index.php?editor&ajax', $.param(settings), function(data) {
            data = $.parseJSON(data);
            if( data['success'] != '' ) {
                // Success
                //console.log('success!');
                // Set the form's state to clean
                editorForm.dirtyForms('setClean');                
            } else {
                // Error
                setTimeout(function() { 
                    $('.error ul', saveBtn).html(data['error']);
                    saveBtn.addClass('animated shake');
                }, 1000);
            }
        }).always(function() {
            setTimeout(function() {
                // switch back to regular button state
                $('.regular', saveBtn).fadeIn();
                $('.saving', saveBtn).hide();
                loader.hide();
            }, 1000); 
        });
    }

    // Show context-sensitive help when features are used
    // --------------------------------------------------------------    

    $('#enable_recaptcha').on('click', function() {
        $('.recaptcha-note').slideDown();
    });
    $('#enable_social').on('click', function() {
        $('.social-note').slideDown();
    });
    $('#enable_domain_portfolio').on('click', function() {
        $('.domain-portfolio-note').slideDown();
    });
    $('#enable_stat_portfolio').on('click', function() {
        $('.stat-portfolio-note').slideDown();
    });

    // Domain Portfolio - manage rows
    // --------------------------------------------------------------    

    // Delete row
    $('#domain_portfolio').on('click', '.delete-btn', function(e) { 
        // Get index of current row
        var index = parseInt($(this).closest('tr').index());
        // Get domain name of current row
        var domain = $(this).closest('tr').find('td:first-child input').val();
        // Confirm deletion of row
        if( confirm('Delete "' + domain + '"?')) {
            // Remove from settings array
            settings['domains'].splice(index, 1);
            // Remove from DOM
            $('.domain-portfolio-table tr:eq(' + (index + 1) + ')').remove();
        }
        triggerDomainsInput(); // trigerring input on the portfolio will refresh its settings
        e.preventDefault();
    });
    // Add row
    $('#domain_portfolio').on('click', '.add-domain-btn', function(e) { 
        var domainPortfolioTable = $('.domain-portfolio-table');
        // Get template
        var rowTemplate = $('#domain_portfolio_row_template tr').clone();
        // Add to DOM
        $('tbody', domainPortfolioTable).append(rowTemplate);
        // Scroll to bottom of container so "add domain" button is still visible
        $('#domain_portfolio').scrollTop($('#domain_portfolio').height());
        
        e.preventDefault();
    });
    
    // Activate data-binding on Editor fields
    // --------------------------------------------------------------    

    // Header
    liveUpdateText('header_text', $('#header_text'), $('span.header_text'));
    liveUpdateText('header_subtext', $('#header_subtext'), $('span.header_subtext'));
    
    // General
    liveUpdateText('domain', $('#domain'), $('.header .title span'));
    liveUpdateText('price', $('#price'), $('span.price'));
    liveUpdateText('price_description', $('#price_description'));
    liveUpdateText('description', $('#description'));
    
    // Amount
    liveUpdateText('bid_amount', $('#bid_amount'), $('span.bid_amount'));
    liveUpdateText('bid_description', $('#bid_description'), $('span.bid_description'));
    
    // Footer Text & Social Icons
    liveUpdateSetting('enable_social', $('#enable_social'), true);
    liveUpdateText('footer_text', $('#footer_text'), $('a.footer_text'));
    liveUpdateText('twitter_handle', $('#twitter_handle'), $('a.twitter'));
    liveUpdateText('facebook_handle', $('#facebook_handle'), $('a.facebook'));
    liveUpdateText('instagram_handle', $('#instagram_handle'), $('a.instagram'));
    liveUpdateText('googleplus_handle', $('#googleplus_handle'), $('a.googleplus'));
    liveUpdateText('linkedin_handle', $('#linkedin_handle'), $('a.linkedin'));
    liveUpdateText('youtube_handle', $('#youtube_handle'), $('a.youtube'));
    liveUpdateText('pinterest_handle', $('#pinterest_handle'), $('a.pinterest'));
    
    // Email
    liveUpdateSetting('recipient_name', $('#recipient_name'));
    liveUpdateSetting('recipient_email', $('#recipient_email'));
    liveUpdateSetting('enable_recaptcha', $('#enable_recaptcha'), true);
    liveUpdateSetting('recaptcha_public_key', $('#recaptcha_public_key'));
    liveUpdateSetting('recaptcha_private_key', $('#recaptcha_private_key'));
    
    // Background
    liveUpdateBackgroundColor('tint', $('#tint'));
    liveUpdateTextColor('text_color', $('#text_color'), $('body'));
    liveUpdateThemeColor('theme_color', $('#theme_color'), $('body'));
    liveUpdateImage('image', $('input[name="image"]'));
    liveUpdateTexture('texture', $('input[name="texture"]'));
    
    // Google Adsense
    liveUpdateSetting('enable_adsense', $('#enable_adsense'), true);
    liveUpdateText('client_handle', $('#client_handle'), $('a.client'));
    liveUpdateText('slot_handle', $('#slot_handle'), $('a.slot'));
    
    // Domain Portfolio
    liveUpdateSetting('enable_domain_portfolio', $('#enable_domain_portfolio'), true);
    liveUpdateSetting('domains', $('.domain-portfolio-table tbody'));
    liveUpdateDomains($('.domain-portfolio-table tbody'));
    triggerDomainsInput(); // trigerring input on the portfolio will populate its settings
});