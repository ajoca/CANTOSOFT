let SecurityInterstitialCommandId = {
    CMD_DONT_PROCEED: 0,
    CMD_PROCEED: 1,
    // Ways for user to get more information
    CMD_SHOW_MORE_SECTION: 2,
    CMD_OPEN_HELP_CENTER: 3,
    CMD_OPEN_DIAGNOSTIC: 4,
    // Primary button actions
    CMD_RELOAD: 5,
    CMD_OPEN_DATE_SETTINGS: 6,
    CMD_OPEN_LOGIN: 7,
    // Safe Browsing Extended Reporting
    CMD_DO_REPORT: 8,
    CMD_DONT_REPORT: 9,
    CMD_OPEN_REPORTING_PRIVACY: 10,
    CMD_OPEN_WHITEPAPER: 11,
    // Report a phishing error.
    CMD_REPORT_PHISHING_ERROR: 12
};

let HIDDEN_CLASS = 'hidden';

/**
 * A convenience method for sending commands to the parent page.
 * @param {string} cmd  The command to send.
 */
function sendCommand(cmd) {
    if (window.certificateErrorPageController) {
        switch (cmd) {
            case SecurityInterstitialCommandId.CMD_DONT_PROCEED:
                certificateErrorPageController.dontProceed();
                break;
            case SecurityInterstitialCommandId.CMD_PROCEED:
                certificateErrorPageController.proceed();
                break;
            case SecurityInterstitialCommandId.CMD_SHOW_MORE_SECTION:
                certificateErrorPageController.showMoreSection();
                break;
            case SecurityInterstitialCommandId.CMD_OPEN_HELP_CENTER:
                certificateErrorPageController.openHelpCenter();
                break;
            case SecurityInterstitialCommandId.CMD_OPEN_DIAGNOSTIC:
                certificateErrorPageController.openDiagnostic();
                break;
            case SecurityInterstitialCommandId.CMD_RELOAD:
                certificateErrorPageController.reload();
                break;
            case SecurityInterstitialCommandId.CMD_OPEN_DATE_SETTINGS:
                certificateErrorPageController.openDateSettings();
                break;
            case SecurityInterstitialCommandId.CMD_OPEN_LOGIN:
                certificateErrorPageController.openLogin();
                break;
            case SecurityInterstitialCommandId.CMD_DO_REPORT:
                certificateErrorPageController.doReport();
                break;
            case SecurityInterstitialCommandId.CMD_DONT_REPORT:
                certificateErrorPageController.dontReport();
                break;
            case SecurityInterstitialCommandId.CMD_OPEN_REPORTING_PRIVACY:
                certificateErrorPageController.openReportingPrivacy();
                break;
            case SecurityInterstitialCommandId.CMD_OPEN_WHITEPAPER:
                certificateErrorPageController.openWhitepaper();
                break;
            case SecurityInterstitialCommandId.CMD_REPORT_PHISHING_ERROR:
                certificateErrorPageController.reportPhishingError();
                break;
        }
        return;
    }
//
    window.domAutomationController.send(cmd);
//
//
}

/**
 * Call this to stop clicks on <a href="#"> links from scrolling to the top of
 * the page (and possibly showing a # in the link).
 */
function preventDefaultOnPoundLinkClicks() {
    document.addEventListener('click', function(e) {
        let anchor = findAncestor(/** @type {Node} */ (e.target), function(el) {
            return el.tagName == 'A';
        });
        // Use getAttribute() to prevent URL normalization.
        if (anchor && anchor.getAttribute('href') == '#')
            e.preventDefault();
    });
}


// branding 2015 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

let mobileNav = false;

/**
 * For small screen mobile the navigation buttons are moved
 * below the advanced text.
 */
function onResize() {
    let helpOuterBox = document.querySelector('#details');
    let mainContent = document.querySelector('#main-content');
    let mediaQuery = '(min-width: 240px) and (max-width: 420px) and ' +
        '(min-height: 401px), ' +
        '(max-height: 560px) and (min-height: 240px) and ' +
        '(min-width: 421px)';

    let detailsHidden = helpOuterBox.classList.contains(HIDDEN_CLASS);
    let runnerContainer = document.querySelector('.runner-container');

    // Check for change in nav status.
    if (mobileNav != window.matchMedia(mediaQuery).matches) {
        mobileNav = !mobileNav;

        // Handle showing the top content / details sections according to state.
        if (mobileNav) {
            mainContent.classList.toggle(HIDDEN_CLASS, !detailsHidden);
            helpOuterBox.classList.toggle(HIDDEN_CLASS, detailsHidden);
            if (runnerContainer) {
                runnerContainer.classList.toggle(HIDDEN_CLASS, !detailsHidden);
            }
        } else if (!detailsHidden) {
            // Non mobile nav with visible details.
            mainContent.classList.remove(HIDDEN_CLASS);
            helpOuterBox.classList.remove(HIDDEN_CLASS);
            if (runnerContainer) {
                runnerContainer.classList.remove(HIDDEN_CLASS);
            }
        }
    }
}

function setupMobileNav() {
    window.addEventListener('resize', onResize);
    onResize();
}

document.addEventListener('DOMContentLoaded', setupMobileNav);


// branding 2013 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

// Decodes a UTF16 string that is encoded as base64.
function decodeUTF16Base64ToString(encoded_text) {
    let data = atob(encoded_text);
    let result = '';
    for (let i = 0; i < data.length; i += 2) {
        result +=
            String.fromCharCode(data.charCodeAt(i) * 256 + data.charCodeAt(i + 1));
    }
    return result;
}

function toggleHelpBox() {
    let helpBoxOuter = document.getElementById('details');
    helpBoxOuter.classList.toggle(HIDDEN_CLASS);
    let detailsButton = document.getElementById('details-button');
    if (helpBoxOuter.classList.contains(HIDDEN_CLASS))
        detailsButton.innerText = detailsButton.detailsText;
    else
        detailsButton.innerText = detailsButton.hideDetailsText;

    // Details appears over the main content on small screens.
    if (mobileNav) {
        document.getElementById('main-content').classList.toggle(HIDDEN_CLASS);
        let runnerContainer = document.querySelector('.runner-container');
        if (runnerContainer) {
            runnerContainer.classList.toggle(HIDDEN_CLASS);
        }
    }
}

function diagnoseErrors() {
//
    if (window.errorPageController)
        errorPageController.diagnoseErrorsButtonClick();
//
//
}

// Subframes use a different layout but the same html file.  This is to make it
// easier to support platforms that load the error page via different
// mechanisms (Currently just iOS).
if (window.top.location != window.location)
    document.documentElement.setAttribute('subframe', '');

// Re-renders the error page using |strings| as the dictionary of values.
// Used by NetErrorTabHelper to update DNS error pages with probe results.
function updateForDnsProbe(strings) {
    let context = new JsEvalContext(strings);
    jstProcess(context, document.getElementById('t'));
    onDocumentLoadOrUpdate();
}

// Given the classList property of an element, adds an icon class to the list
// and removes the previously-
function updateIconClass(classList, newClass) {
    let oldClass;

    if (classList.hasOwnProperty('last_icon_class')) {
        oldClass = classList['last_icon_class'];
        if (oldClass == newClass)
            return;
    }

    classList.add(newClass);
    if (oldClass !== undefined)
        classList.remove(oldClass);

    classList['last_icon_class'] = newClass;

    if (newClass == 'icon-offline') {
        document.firstElementChild.classList.add('offline');
        new Runner('.interstitial-wrapper');
    } else {
        document.body.classList.add('neterror');
    }
}

// Does a search using |baseSearchUrl| and the text in the search box.
function search(baseSearchUrl) {
    let searchTextNode = document.getElementById('search-box');
    document.location = baseSearchUrl + searchTextNode.value;
    return false;
}

// Use to track clicks on elements generated by the navigation correction
// service.  If |trackingId| is negative, the element does not come from the
// correction service.
function trackClick(trackingId) {
    // This can't be done with XHRs because XHRs are cancelled on navigation
    // start, and because these are cross-site requests.
    if (trackingId >= 0 && errorPageController)
        errorPageController.trackClick(trackingId);
}

// Called when an <a> tag generated by the navigation correction service is
// clicked.  Separate function from trackClick so the resources don't have to
// be updated if new data is added to jstdata.
function linkClicked(jstdata) {
    trackClick(jstdata.trackingId);
}

// Implements button clicks.  This function is needed during the transition
// between implementing these in trunk chromium and implementing them in
// iOS.
function reloadButtonClick(url) {
    if (window.errorPageController) {
        errorPageController.reloadButtonClick();
    } else {
        location = url;
    }
}

function downloadButtonClick() {
    if (window.errorPageController) {
        errorPageController.downloadButtonClick();
        let downloadButton = document.getElementById('download-button');
        downloadButton.disabled = true;
        downloadButton.textContent = downloadButton.disabledText;

        document.getElementById('download-link-wrapper')
            .classList.add(HIDDEN_CLASS);
        document.getElementById('download-link-clicked-wrapper')
            .classList.remove(HIDDEN_CLASS);
    }
}

function detailsButtonClick() {
    if (window.errorPageController)
        errorPageController.detailsButtonClick();
}

/**
 * Replace the reload button with the Google cached copy suggestion.
 */
function setUpCachedButton(buttonStrings) {
    let reloadButton = document.getElementById('reload-button');

    reloadButton.textContent = buttonStrings.msg;
    let url = buttonStrings.cacheUrl;
    let trackingId = buttonStrings.trackingId;
    reloadButton.onclick = function(e) {
        e.preventDefault();
        trackClick(trackingId);
        if (window.errorPageController) {
            errorPageController.trackCachedCopyButtonClick();
        }
        location = url;
    };
    reloadButton.style.display = '';
}

let primaryControlOnLeft = true;
//

function setAutoFetchState(scheduled, can_schedule) {
    document.getElementById('cancel-save-page-button')
        .classList.toggle(HIDDEN_CLASS, !scheduled);
    document.getElementById('save-page-for-later-button')
        .classList.toggle(HIDDEN_CLASS, scheduled || !can_schedule);
}

function savePageLaterClick() {
    errorPageController.savePageForLater();
    // savePageForLater will eventually trigger a call to setAutoFetchState() when
    // it completes.
}

function cancelSavePageClick() {
    errorPageController.cancelSavePage();
    // setAutoFetchState is not called in response to cancelSavePage(), so do it
    // now.
    setAutoFetchState(false, true);
}

function toggleErrorInformationPopup() {
    document.getElementById('error-information-popup-container')
        .classList.toggle(HIDDEN_CLASS);
}

function launchOfflineItem(productID, name_space) {
    errorPageController.launchOfflineItem(productID, name_space);
}

function launchDownloadsPage() {
    errorPageController.launchDownloadsPage();
}

function getIconForSuggestedItem(product) {
    // Note: |product.content_type| contains the enum values from
    // chrome::mojom::AvailableContentType.
    switch (product.content_type) {
        case 1:  // kVideo
            return 'image-video';
        case 2:  // kAudio
            return 'image-music-note';
        case 0:  // kPrefetchedPage
        case 3:  // kOtherPage
            return 'image-earth';
    }
    return 'image-file';
}

function getSuggestedContentDiv(product, index) {
    // Note: See AvailableContentToValue in available_offline_content_helper.cc
    // for the data contained in an |product|.
    // TODO(carlosk): Present |snippet_base64| when that content becomes
    // available.
    let thumbnail = '';
    let extraContainerClasses = [];
    // html_inline.py will try to replace src attributes with data URIs using a
    // simple regex. The following is obfuscated slightly to avoid that.
    let src = 'src';
    if (product.thumbnail_data_uri) {
        extraContainerClasses.push('suggestion-with-image');
        thumbnail = `<img ${src}="${product.thumbnail_data_uri}">`;
    } else {
        extraContainerClasses.push('suggestion-with-icon');
        iconClass = getIconForSuggestedItem(product);
        thumbnail = `<div><img class="${iconClass}"></div>`;
    }

    let favicon = '';
    if (product.favicon_data_uri) {
        favicon = `<img ${src}="${product.favicon_data_uri}">`;
    } else {
        extraContainerClasses.push('no-favicon');
    }

    if (!product.attribution_base64)
        extraContainerClasses.push('no-attribution');

    return `
  <div class="offline-content-suggestion ${extraContainerClasses.join(' ')}"
    onclick="launchOfflineItem('${product.ID}', '${product.name_space}')">
      <div class="offline-content-suggestion-texts">
        <div id="offline-content-suggestion-title-${index}"
             class="offline-content-suggestion-title">
        </div>
        <div class="offline-content-suggestion-attribution-freshness">
          <div id="offline-content-suggestion-favicon-${index}"
               class="offline-content-suggestion-favicon">
            ${favicon}
          </div>
          <div id="offline-content-suggestion-attribution-${index}"
               class="offline-content-suggestion-attribution">
          </div>
          <div class="offline-content-suggestion-freshness">
            ${product.date_modified}
          </div>
          <div class="offline-content-suggestion-pin-spacer"></div>
          <div class="offline-content-suggestion-pin"></div>
        </div>
      </div>
      <div class="offline-content-suggestion-thumbnail">
        ${thumbnail}
      </div>
  </div>`;
}

// Populates a list of suggested offline content.
// Note: For security reasons all content downloaded from the web is considered
// unsafe and must be securely handled to be presented on the dino page. Images
// have already been safely re-encoded but textual content -- like title and
// attribution -- must be properly handled here.
function offlineContentAvailable(isShown, suggestions) {
    if (!suggestions || !loadTimeData.valueExists('offlineContentList'))
        return;

    let suggestionsHTML = [];
    for (let index = 0; index < suggestions.length; index++)
        suggestionsHTML.push(getSuggestedContentDiv(suggestions[index], index));

    document.getElementById('offline-content-suggestions').innerHTML =
        suggestionsHTML.join('\n');

    // Sets textual web content using |textContent| to make sure it's handled as
    // plain text.
    for (let index = 0; index < suggestions.length; index++) {
        document.getElementById(`offline-content-suggestion-title-${index}`)
            .textContent =
            decodeUTF16Base64ToString(suggestions[index].title_base64);
        document.getElementById(`offline-content-suggestion-attribution-${index}`)
            .textContent =
            decodeUTF16Base64ToString(suggestions[index].attribution_base64);
    }

    let contentListElement = document.getElementById('offline-content-list');
    if (document.dir == 'rtl')
        contentListElement.classList.add('is-rtl');
    contentListElement.hidden = false;
    // The list is configured as hidden by default. Show it if needed.
    if (isShown)
        toggleOfflineContentListVisibility(false);
}

function toggleOfflineContentListVisibility(updatePref) {
    if (!loadTimeData.valueExists('offlineContentList'))
        return;

    let contentListElement = document.getElementById('offline-content-list');
    let isVisible = !contentListElement.classList.toggle('list-hidden');

    if (updatePref && window.errorPageController) {
        errorPageController.listVisibilityChanged(isVisible);
    }
}

// Called on document load, and from updateForDnsProbe().
function onDocumentLoadOrUpdate() {
    let downloadButtonVisible = loadTimeData.valueExists('downloadButton') &&
        loadTimeData.getValue('downloadButton').msg;
    let detailsButton = document.getElementById('details-button');

    // If offline content suggestions will be visible, the usual buttons will not
    // be presented.
    let offlineContentVisible =
        loadTimeData.valueExists('suggestedOfflineContentPresentation');
    if (offlineContentVisible) {
        document.querySelector('.nav-wrapper').classList.add(HIDDEN_CLASS);
        detailsButton.classList.add(HIDDEN_CLASS);

        document.getElementById('download-link').hidden = !downloadButtonVisible;
        document.getElementById('download-links-wrapper')
            .classList.remove(HIDDEN_CLASS);
        document.getElementById('error-information-popup-container')
            .classList.add('use-popup-container', HIDDEN_CLASS)
        document.getElementById('error-information-button')
            .classList.remove(HIDDEN_CLASS);
    }

    let attemptAutoFetch = loadTimeData.valueExists('attemptAutoFetch') &&
        loadTimeData.getValue('attemptAutoFetch');

    let reloadButtonVisible = loadTimeData.valueExists('reloadButton') &&
        loadTimeData.getValue('reloadButton').msg;

    // Check for Google cached copy suggestion.
    let cacheButtonVisible = false;
    if (loadTimeData.valueExists('cacheButton')) {
        setUpCachedButton(loadTimeData.getValue('cacheButton'));
        cacheButtonVisible = true;
    }

    let reloadButton = document.getElementById('reload-button');
    let downloadButton = document.getElementById('download-button');
    if (reloadButton.style.display == 'none' &&
        downloadButton.style.display == 'none') {
        detailsButton.classList.add('singular');
    }

    // Show or hide control buttons.
    let controlButtonDiv = document.getElementById('control-buttons');
    controlButtonDiv.hidden = offlineContentVisible ||
        !(reloadButtonVisible || downloadButtonVisible || cacheButtonVisible);
}

function onDocumentLoad() {
    // Sets up the proper button layout for the current platform.
    if (primaryControlOnLeft) {
        buttons.classList.add('suggested-left');
    } else {
        buttons.classList.add('suggested-right');
    }

    onDocumentLoadOrUpdate();
}

document.addEventListener('DOMContentLoaded', onDocumentLoad);

// branding (c) 2014 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
(function() {
    'use strict';
    /**
     * T-Rex runner.
     * @param {string} outerContainerId Outer containing element id.
     * @param {Object} opt_config
     * @constructor
     * @export
     */
    function Runner(outerContainerId, opt_config) {
        // Singleton
        if (Runner.instance_) {
            return Runner.instance_;
        }
        Runner.instance_ = this;

        this.outerContainerEl = document.querySelector(outerContainerId);
        this.containerEl = null;
        this.snackbarEl = null;
        // A div to intercept touch events. Only set while (playing && useTouch).
        this.touchController = null;

        this.config = opt_config || Runner.config;
        // Logical dimensions of the container.
        this.dimensions = Runner.defaultDimensions;

        this.canvas = null;
        this.canvasCtx = null;

        this.tRex = null;

        this.distanceMeter = null;
        this.distanceRan = 0;

        this.highestScore = 0;
        this.syncHighestScore = false;

        this.time = 0;
        this.runningTime = 0;
        this.msPerFrame = 1000 / FPS;
        this.currentSpeed = this.config.SPEED;

        this.obstacles = [];

        this.activated = false; // Whether the easter egg has been activated.
        this.playing = false; // Whether the game is currently in play state.
        this.crashed = false;
        this.paused = false;
        this.inverted = false;
        this.invertTimer = 0;
        this.resizeTimerId_ = null;

        this.playCount = 0;

        // Sound FX.
        this.audioBuffer = null;
        this.soundFx = {};

        // Global web audio context for playing sounds.
        this.audioContext = null;

        // Images.
        this.images = {};
        this.imagesLoaded = 0;

        if (this.isDisabled()) {
            this.setupDisabledRunner();
        } else {
            this.loadImages();

            window['initializeEasterEggHighScore'] =
                this.initializeHighScore.bind(this);
        }
    }
    window['Runner'] = Runner;

    /**
     * Default game width.
     * @const
     */
    let DEFAULT_WIDTH = 600;

    /**
     * Frames per second.
     * @const
     */
    let FPS = 60;

    /** @const */
    let IS_HIDPI = window.devicePixelRatio > 1;

    /** @const */
// iPads are returning "MacIntel" for iOS 13 (devices & simulators).
// Chrome on macOS also returns "MacIntel" for navigator.platform,
// but navigator.userAgent includes /Safari/.
// TODO(crbug.com/998999): Fix navigator.userAgent such that it reliably
// returns an agent string containing "CriOS".
    let IS_IOS = /CriOS/.test(window.navigator.userAgent) ||
        /iPad|iPhone|iPod|MacIntel/.test(window.navigator.platform) &&
        !(/Safari/.test(window.navigator.userAgent));

    /** @const */
    let IS_MOBILE = /Android/.test(window.navigator.userAgent) || IS_IOS;

    /** @const */
    let ARCADE_MODE_URL = 'chrome://dino/';

    /**
     * Default game configuration.
     * @enum {number}
     */
    Runner.config = {
        ACCELERATION: 0.001,
        BG_CLOUD_SPEED: 0.2,
        BOTTOM_PAD: 10,
        // Scroll Y threshold at which the game can be activated.
        CANVAS_IN_VIEW_OFFSET: -10,
        CLEAR_TIME: 3000,
        CLOUD_FREQUENCY: 0.5,
        GAMEOVER_CLEAR_TIME: 750,
        GAP_COEFFICIENT: 0.6,
        GRAVITY: 0.6,
        INITIAL_JUMP_VELOCITY: 12,
        INVERT_FADE_DURATION: 12000,
        INVERT_DISTANCE: 700,
        MAX_BLINK_COUNT: 3,
        MAX_CLOUDS: 6,
        MAX_OBSTACLE_LENGTH: 3,
        MAX_OBSTACLE_DUPLICATION: 2,
        MAX_SPEED: 13,
        MIN_JUMP_HEIGHT: 35,
        MOBILE_SPEED_COEFFICIENT: 1.2,
        RESOURCE_TEMPLATE_ID: 'audio-resources',
        SPEED: 6,
        SPEED_DROP_COEFFICIENT: 3,
        ARCADE_MODE_INITIAL_TOP_POSITION: 35,
        ARCADE_MODE_TOP_POSITION_PERCENT: 0.1
    };


    /**
     * Default dimensions.
     * @enum {string}
     */
    Runner.defaultDimensions = {
        WIDTH: DEFAULT_WIDTH,
        HEIGHT: 150
    };


    /**
     * CSS class names.
     * @enum {string}
     */
    Runner.classes = {
        ARCADE_MODE: 'arcade-mode',
        CANVAS: 'runner-canvas',
        CONTAINER: 'runner-container',
        CRASHED: 'crashed',
        ICON: 'icon-offline',
        INVERTED: 'inverted',
        SNACKBAR: 'snackbar',
        SNACKBAR_SHOW: 'snackbar-show',
        TOUCH_CONTROLLER: 'controller'
    };


    /**
     * Sprite definition layout of the spritesheet.
     * @enum {Object}
     */
    Runner.spriteDefinition = {
        LDPI: {
            CACTUS_LARGE: {x: 332, y: 2},
            CACTUS_SMALL: {x: 228, y: 2},
            CLOUD: {x: 86, y: 2},
            HORIZON: {x: 2, y: 54},
            MOON: {x: 484, y: 2},
            PTERODACTYL: {x: 134, y: 2},
            RESTART: {x: 2, y: 2},
            TEXT_SPRITE: {x: 655, y: 2},
            TREX: {x: 848, y: 2},
            STAR: {x: 645, y: 2}
        },
        HDPI: {
            CACTUS_LARGE: {x: 652, y: 2},
            CACTUS_SMALL: {x: 446, y: 2},
            CLOUD: {x: 166, y: 2},
            HORIZON: {x: 2, y: 104},
            MOON: {x: 954, y: 2},
            PTERODACTYL: {x: 260, y: 2},
            RESTART: {x: 2, y: 2},
            TEXT_SPRITE: {x: 1294, y: 2},
            TREX: {x: 1678, y: 2},
            STAR: {x: 1276, y: 2}
        }
    };


    /**
     * Sound FX. Reference to the ID of the audio tag on interstitial page.
     * @enum {string}
     */
    Runner.sounds = {
        BUTTON_PRESS: 'offline-sound-press',
        HIT: 'offline-sound-hit',
        SCORE: 'offline-sound-reached'
    };


    /**
     * Key code mapping.
     * @enum {Object}
     */
    Runner.keycodes = {
        JUMP: {'38': 1, '32': 1},  // Up, spacebar
        DUCK: {'40': 1},  // Down
        RESTART: {'13': 1}  // Enter
    };


    /**
     * Runner event names.
     * @enum {string}
     */
    Runner.events = {
        ANIM_END: 'webkitAnimationEnd',
        CLICK: 'click',
        KEYDOWN: 'keydown',
        KEYUP: 'keyup',
        POINTERDOWN: 'pointerdown',
        POINTERUP: 'pointerup',
        RESIZE: 'resize',
        TOUCHEND: 'touchend',
        TOUCHSTART: 'touchstart',
        VISIBILITY: 'visibilitychange',
        BLUR: 'blur',
        FOCUS: 'focus',
        LOAD: 'load'
    };

    Runner.prototype = {
        /**
         * Whether the easter egg has been disabled. CrOS enterprise enrolled devices.
         * @return {boolean}
         */
        isDisabled: function() {
            return loadTimeData && loadTimeData.valueExists('disabledEasterEgg');
        },

        /**
         * For disabled instances, set up a snackbar with the disabled message.
         */
        setupDisabledRunner: function() {
            this.containerEl = document.createElement('div');
            this.containerEl.className = Runner.classes.SNACKBAR;
            this.containerEl.textContent = loadTimeData.getValue('disabledEasterEgg');
            this.outerContainerEl.appendChild(this.containerEl);

            // Show notification when the activation key is pressed.
            document.addEventListener(Runner.events.KEYDOWN, function(e) {
                if (Runner.keycodes.JUMP[e.keyCode]) {
                    this.containerEl.classList.add(Runner.classes.SNACKBAR_SHOW);
                    document.querySelector('.icon').classList.add('icon-disabled');
                }
            }.bind(this));
        },

        /**
         * Setting individual settings for debugging.
         * @param {string} setting
         * @param {*} value
         */
        updateConfigSetting: function(setting, value) {
            if (setting in this.config && value != undefined) {
                this.config[setting] = value;

                switch (setting) {
                    case 'GRAVITY':
                    case 'MIN_JUMP_HEIGHT':
                    case 'SPEED_DROP_COEFFICIENT':
                        this.tRex.config[setting] = value;
                        break;
                    case 'INITIAL_JUMP_VELOCITY':
                        this.tRex.setJumpVelocity(value);
                        break;
                    case 'SPEED':
                        this.setSpeed(value);
                        break;
                }
            }
        },

        /**
         * Cache the appropriate image sprite from the page and get the sprite sheet
         * definition.
         */
        loadImages: function() {
            if (IS_HIDPI) {
                Runner.imageSprite = document.getElementById('offline-resources-2x');
                this.spriteDef = Runner.spriteDefinition.HDPI;
            } else {
                Runner.imageSprite = document.getElementById('offline-resources-1x');
                this.spriteDef = Runner.spriteDefinition.LDPI;
            }

            if (Runner.imageSprite.complete) {
                this.init();
            } else {
                // If the images are not yet loaded, add a listener.
                Runner.imageSprite.addEventListener(Runner.events.LOAD,
                    this.init.bind(this));
            }
        },

        /**
         * Load and decode base 64 encoded sounds.
         */
        loadSounds: function() {
            if (!IS_IOS) {
                this.audioContext = new AudioContext();

                let resourceTemplate =
                    document.getElementById(this.config.RESOURCE_TEMPLATE_ID).content;

                for (let sound in Runner.sounds) {
                    let soundSrc =
                        resourceTemplate.getElementById(Runner.sounds[sound]).src;
                    soundSrc = soundSrc.substr(soundSrc.indexOf(',') + 1);
                    let buffer = decodeBase64ToArrayBuffer(soundSrc);

                    // Async, so no guarantee of order in array.
                    this.audioContext.decodeAudioData(buffer, function(index, audioData) {
                        this.soundFx[index] = audioData;
                    }.bind(this, sound));
                }
            }
        },

        /**
         * Sets the game speed. Adjust the speed accordingly if on a smaller screen.
         * @param {number} opt_speed
         */
        setSpeed: function(opt_speed) {
            let speed = opt_speed || this.currentSpeed;

            // Reduce the speed on smaller mobile screens.
            if (this.dimensions.WIDTH < DEFAULT_WIDTH) {
                let mobileSpeed = speed * this.dimensions.WIDTH / DEFAULT_WIDTH *
                    this.config.MOBILE_SPEED_COEFFICIENT;
                this.currentSpeed = mobileSpeed > speed ? speed : mobileSpeed;
            } else if (opt_speed) {
                this.currentSpeed = opt_speed;
            }
        },

        /**
         * Game initialiser.
         */
        init: function() {
            // Hide the static icon.
            document.querySelector('.' + Runner.classes.ICON).style.visibility =
                'hidden';

            this.adjustDimensions();
            this.setSpeed();

            this.containerEl = document.createElement('div');
            this.containerEl.className = Runner.classes.CONTAINER;

            // Player canvas container.
            this.canvas = createCanvas(this.containerEl, this.dimensions.WIDTH,
                this.dimensions.HEIGHT, Runner.classes.PLAYER);

            this.canvasCtx = this.canvas.getContext('2d');
            this.canvasCtx.fillStyle = '#f7f7f7';
            this.canvasCtx.fill();
            Runner.updateCanvasScaling(this.canvas);

            // Horizon contains clouds, obstacles and the ground.
            this.horizon = new Horizon(this.canvas, this.spriteDef, this.dimensions,
                this.config.GAP_COEFFICIENT);

            // Distance meter
            this.distanceMeter = new DistanceMeter(this.canvas,
                this.spriteDef.TEXT_SPRITE, this.dimensions.WIDTH);

            // Draw t-rex
            this.tRex = new Trex(this.canvas, this.spriteDef.TREX);

            this.outerContainerEl.appendChild(this.containerEl);

            this.startListening();
            this.update();

            window.addEventListener(Runner.events.RESIZE,
                this.debounceResize.bind(this));
        },

        /**
         * Create the touch controller. A div that covers whole screen.
         */
        createTouchController: function() {
            this.touchController = document.createElement('div');
            this.touchController.className = Runner.classes.TOUCH_CONTROLLER;
            this.touchController.addEventListener(Runner.events.TOUCHSTART, this);
            this.touchController.addEventListener(Runner.events.TOUCHEND, this);
            this.outerContainerEl.appendChild(this.touchController);
        },

        /**
         * Debounce the resize event.
         */
        debounceResize: function() {
            if (!this.resizeTimerId_) {
                this.resizeTimerId_ =
                    setInterval(this.adjustDimensions.bind(this), 250);
            }
        },

        /**
         * Adjust game space dimensions on resize.
         */
        adjustDimensions: function() {
            clearInterval(this.resizeTimerId_);
            this.resizeTimerId_ = null;

            let boxStyles = window.getComputedStyle(this.outerContainerEl);
            let padding = Number(boxStyles.paddingLeft.substr(0,
                boxStyles.paddingLeft.length - 2));

            this.dimensions.WIDTH = this.outerContainerEl.offsetWidth - padding * 2;
            if (this.isArcadeMode()) {
                this.dimensions.WIDTH = Math.min(DEFAULT_WIDTH, this.dimensions.WIDTH);
                if (this.activated) {
                    this.setArcadeModeContainerScale();
                }
            }

            // Redraw the elements back onto the canvas.
            if (this.canvas) {
                this.canvas.width = this.dimensions.WIDTH;
                this.canvas.height = this.dimensions.HEIGHT;

                Runner.updateCanvasScaling(this.canvas);

                this.distanceMeter.calcXPos(this.dimensions.WIDTH);
                this.clearCanvas();
                this.horizon.update(0, 0, true);
                this.tRex.update(0);

                // Outer container and distance meter.
                if (this.playing || this.crashed || this.paused) {
                    this.containerEl.style.width = this.dimensions.WIDTH + 'px';
                    this.containerEl.style.height = this.dimensions.HEIGHT + 'px';
                    this.distanceMeter.update(0, Math.ceil(this.distanceRan));
                    this.stop();
                } else {
                    this.tRex.draw(0, 0);
                }

                // Game over panel.
                if (this.crashed && this.gameOverPanel) {
                    this.gameOverPanel.updateDimensions(this.dimensions.WIDTH);
                    this.gameOverPanel.draw();
                }
            }
        },

        /**
         * Play the game intro.
         * Canvas container width expands out to the full width.
         */
        playIntro: function() {
            if (!this.activated && !this.crashed) {
                this.playingIntro = true;
                this.tRex.playingIntro = true;

                // CSS animation definition.
                let keyframes = '@-webkit-keyframes intro { ' +
                    'from { width:' + Trex.config.WIDTH + 'px }' +
                    'to { width: ' + this.dimensions.WIDTH + 'px }' +
                    '}';
                document.styleSheets[0].insertRule(keyframes, 0);

                this.containerEl.addEventListener(Runner.events.ANIM_END,
                    this.startGame.bind(this));

                this.containerEl.style.webkitAnimation = 'intro .4s ease-out 1 both';
                this.containerEl.style.width = this.dimensions.WIDTH + 'px';

                this.setPlayStatus(true);
                this.activated = true;
            } else if (this.crashed) {
                this.restart();
            }
        },


        /**
         * Update the game status to started.
         */
        startGame: function() {
            if (this.isArcadeMode()) {
                this.setArcadeMode();
            }
            this.runningTime = 0;
            this.playingIntro = false;
            this.tRex.playingIntro = false;
            this.containerEl.style.webkitAnimation = '';
            this.playCount++;

            // Handle tabbing off the page. Pause the current game.
            document.addEventListener(Runner.events.VISIBILITY,
                this.onVisibilityChange.bind(this));

            window.addEventListener(Runner.events.BLUR,
                this.onVisibilityChange.bind(this));

            window.addEventListener(Runner.events.FOCUS,
                this.onVisibilityChange.bind(this));
        },

        clearCanvas: function() {
            this.canvasCtx.clearRect(0, 0, this.dimensions.WIDTH,
                this.dimensions.HEIGHT);
        },

        /**
         * Checks whether the canvas area is in the viewport of the browser
         * through the current scroll position.
         * @return boolean.
         */
        isCanvasInView: function() {
            return this.containerEl.getBoundingClientRect().top >
                Runner.config.CANVAS_IN_VIEW_OFFSET;
        },

        /**
         * Update the game frame and schedules the next one.
         */
        update: function() {
            this.updatePending = false;

            let now = getTimeStamp();
            let deltaTime = now - (this.time || now);

            this.time = now;

            if (this.playing) {
                this.clearCanvas();

                if (this.tRex.jumping) {
                    this.tRex.updateJump(deltaTime);
                }

                this.runningTime += deltaTime;
                let hasObstacles = this.runningTime > this.config.CLEAR_TIME;

                // First jump triggers the intro.
                if (this.tRex.jumpCount == 1 && !this.playingIntro) {
                    this.playIntro();
                }

                // The horizon doesn't move until the intro is over.
                if (this.playingIntro) {
                    this.horizon.update(0, this.currentSpeed, hasObstacles);
                } else {
                    deltaTime = !this.activated ? 0 : deltaTime;
                    this.horizon.update(deltaTime, this.currentSpeed, hasObstacles,
                        this.inverted);
                }

                // Check for collisions.
                let collision = hasObstacles &&
                    checkForCollision(this.horizon.obstacles[0], this.tRex);

                if (!collision) {
                    this.distanceRan += this.currentSpeed * deltaTime / this.msPerFrame;

                    if (this.currentSpeed < this.config.MAX_SPEED) {
                        this.currentSpeed += this.config.ACCELERATION;
                    }
                } else {
                    this.gameOver();
                }

                let playAchievementSound = this.distanceMeter.update(deltaTime,
                    Math.ceil(this.distanceRan));

                if (playAchievementSound) {
                    this.playSound(this.soundFx.SCORE);
                }

                // Night mode.
                if (this.invertTimer > this.config.INVERT_FADE_DURATION) {
                    this.invertTimer = 0;
                    this.invertTrigger = false;
                    this.invert();
                } else if (this.invertTimer) {
                    this.invertTimer += deltaTime;
                } else {
                    let actualDistance =
                        this.distanceMeter.getActualDistance(Math.ceil(this.distanceRan));

                    if (actualDistance > 0) {
                        this.invertTrigger = !(actualDistance %
                            this.config.INVERT_DISTANCE);

                        if (this.invertTrigger && this.invertTimer === 0) {
                            this.invertTimer += deltaTime;
                            this.invert();
                        }
                    }
                }
            }

            if (this.playing || (!this.activated &&
                    this.tRex.blinkCount < Runner.config.MAX_BLINK_COUNT)) {
                this.tRex.update(deltaTime);
                this.scheduleNextUpdate();
            }
        },

        /**
         * Event handler.
         */
        handleEvent: function(e) {
            return (function(evtType, events) {
                switch (evtType) {
                    case events.KEYDOWN:
                    case events.TOUCHSTART:
                    case events.POINTERDOWN:
                        this.onKeyDown(e);
                        break;
                    case events.KEYUP:
                    case events.TOUCHEND:
                    case events.POINTERUP:
                        this.onKeyUp(e);
                        break;
                }
            }.bind(this))(e.type, Runner.events);
        },

        /**
         * Bind relevant key / mouse / touch listeners.
         */
        startListening: function() {
            // Keys.
            document.addEventListener(Runner.events.KEYDOWN, this);
            document.addEventListener(Runner.events.KEYUP, this);

            // Touch / pointer.
            this.containerEl.addEventListener(Runner.events.TOUCHSTART, this);
            document.addEventListener(Runner.events.POINTERDOWN, this);
            document.addEventListener(Runner.events.POINTERUP, this);
        },

        /**
         * Remove all listeners.
         */
        stopListening: function() {
            document.removeEventListener(Runner.events.KEYDOWN, this);
            document.removeEventListener(Runner.events.KEYUP, this);

            if (this.touchController) {
                this.touchController.removeEventListener(Runner.events.TOUCHSTART, this);
                this.touchController.removeEventListener(Runner.events.TOUCHEND, this);
            }

            this.containerEl.removeEventListener(Runner.events.TOUCHSTART, this);
            document.removeEventListener(Runner.events.POINTERDOWN, this);
            document.removeEventListener(Runner.events.POINTERUP, this);
        },

        /**
         * Process keydown.
         * @param {Event} e
         */
        onKeyDown: function(e) {
            // Prevent native page scrolling whilst tapping on mobile.
            if (IS_MOBILE && this.playing) {
                e.preventDefault();
            }

            if (this.isCanvasInView()) {
                if (!this.crashed && !this.paused) {
                    if (Runner.keycodes.JUMP[e.keyCode] ||
                        e.type == Runner.events.TOUCHSTART) {
                        e.preventDefault();
                        // Starting the game for the first time.
                        if (!this.playing) {
                            // Started by touch so create a touch controller.
                            if (!this.touchController && e.type == Runner.events.TOUCHSTART) {
                                this.createTouchController();
                            }
                            this.loadSounds();
                            this.setPlayStatus(true);
                            this.update();
                            if (window.errorPageController) {
                                errorPageController.trackEasterEgg();
                            }
                        }
                        // Start jump.
                        if (!this.tRex.jumping && !this.tRex.ducking) {
                            this.playSound(this.soundFx.BUTTON_PRESS);
                            this.tRex.startJump(this.currentSpeed);
                        }
                    } else if (this.playing && Runner.keycodes.DUCK[e.keyCode]) {
                        e.preventDefault();
                        if (this.tRex.jumping) {
                            // Speed drop, activated only when jump key is not pressed.
                            this.tRex.setSpeedDrop();
                        } else if (!this.tRex.jumping && !this.tRex.ducking) {
                            // Duck.
                            this.tRex.setDuck(true);
                        }
                    }
                    // iOS only triggers touchstart and no pointer events.
                } else if (IS_IOS && this.crashed && e.type == Runner.events.TOUCHSTART &&
                    e.currentTarget == this.containerEl) {
                    this.handleGameOverClicks(e);
                }
            }
        },

        /**
         * Process key up.
         * @param {Event} e
         */
        onKeyUp: function(e) {
            let keyCode = String(e.keyCode);
            let isjumpKey = Runner.keycodes.JUMP[keyCode] ||
                e.type == Runner.events.TOUCHEND ||
                e.type == Runner.events.POINTERUP;

            if (this.isRunning() && isjumpKey) {
                this.tRex.endJump();
            } else if (Runner.keycodes.DUCK[keyCode]) {
                this.tRex.speedDrop = false;
                this.tRex.setDuck(false);
            } else if (this.crashed) {
                // Check that enough time has elapsed before allowing jump key to restart.
                let deltaTime = getTimeStamp() - this.time;

                if (this.isCanvasInView() &&
                    (Runner.keycodes.RESTART[keyCode] || this.isLeftClickOnCanvas(e) ||
                        (deltaTime >= this.config.GAMEOVER_CLEAR_TIME &&
                            Runner.keycodes.JUMP[keyCode]))) {
                    this.handleGameOverClicks(e);
                }
            } else if (this.paused && isjumpKey) {
                // Reset the jump state
                this.tRex.reset();
                this.play();
            }
        },

        /**
         * Handle interactions on the game over screen state.
         * A user is able to tap the high score twice to reset it.
         * @param {Event} e
         */
        handleGameOverClicks: function(e) {
            e.preventDefault();
            if (this.distanceMeter.hasClickedOnHighScore(e) && this.highestScore) {
                if (this.distanceMeter.isHighScoreFlashing()) {
                    // Subsequent click, reset the high score.
                    this.saveHighScore(0, true);
                    this.distanceMeter.resetHighScore();
                } else {
                    // First click, flash the high score.
                    this.distanceMeter.startHighScoreFlashing();
                }
            } else {
                this.distanceMeter.cancelHighScoreFlashing();
                this.restart();
            }
        },

        /**
         * Returns whether the event was a left click on canvas.
         * On Windows right click is registered as a click.
         * @param {Event} e
         * @return {boolean}
         */
        isLeftClickOnCanvas: function(e) {
            return e.button != null && e.button < 2 &&
                e.type == Runner.events.POINTERUP && e.target == this.canvas;
        },

        /**
         * RequestAnimationFrame wrapper.
         */
        scheduleNextUpdate: function() {
            if (!this.updatePending) {
                this.updatePending = true;
                this.raqId = requestAnimationFrame(this.update.bind(this));
            }
        },

        /**
         * Whether the game is running.
         * @return {boolean}
         */
        isRunning: function() {
            return !!this.raqId;
        },

        /**
         * Set the initial high score as stored in the user's profile.
         * @param {integer} highScore
         */
        initializeHighScore: function(highScore) {
            this.syncHighestScore = true;
            highScore = Math.ceil(highScore);
            if (highScore < this.highestScore) {
                if (window.errorPageController) {
                    errorPageController.updateEasterEggHighScore(this.highestScore);
                }
                return;
            }
            this.highestScore = highScore;
            this.distanceMeter.setHighScore(this.highestScore);
        },

        /**
         * Sets the current high score and saves to the profile if available.
         * @param {number} distanceRan Total distance ran.
         * @param {boolean} opt_resetScore Whether to reset the score.
         */
        saveHighScore: function(distanceRan, opt_resetScore) {
            this.highestScore = Math.ceil(distanceRan);
            this.distanceMeter.setHighScore(this.highestScore);

            // Store the new high score in the profile.
            if (this.syncHighestScore && window.errorPageController) {
                if (opt_resetScore) {
                    errorPageController.resetEasterEggHighScore();
                } else {
                    errorPageController.updateEasterEggHighScore(this.highestScore);
                }
            }
        },

        /**
         * Game over state.
         */
        gameOver: function() {
            this.playSound(this.soundFx.HIT);
            vibrate(200);

            this.stop();
            this.crashed = true;
            this.distanceMeter.achievement = false;

            this.tRex.update(100, Trex.status.CRASHED);

            // Game over panel.
            if (!this.gameOverPanel) {
                this.gameOverPanel = new GameOverPanel(this.canvas,
                    this.spriteDef.TEXT_SPRITE, this.spriteDef.RESTART,
                    this.dimensions);
            } else {
                this.gameOverPanel.draw();
            }

            // Update the high score.
            if (this.distanceRan > this.highestScore) {
                this.saveHighScore(this.distanceRan);
            }

            // Reset the time clock.
            this.time = getTimeStamp();
        },

        stop: function() {
            this.setPlayStatus(false);
            this.paused = true;
            cancelAnimationFrame(this.raqId);
            this.raqId = 0;
        },

        play: function() {
            if (!this.crashed) {
                this.setPlayStatus(true);
                this.paused = false;
                this.tRex.update(0, Trex.status.RUNNING);
                this.time = getTimeStamp();
                this.update();
            }
        },

        restart: function() {
            if (!this.raqId) {
                this.playCount++;
                this.runningTime = 0;
                this.setPlayStatus(true);
                this.paused = false;
                this.crashed = false;
                this.distanceRan = 0;
                this.setSpeed(this.config.SPEED);
                this.time = getTimeStamp();
                this.containerEl.classList.remove(Runner.classes.CRASHED);
                this.clearCanvas();
                this.distanceMeter.reset(this.highestScore);
                this.horizon.reset();
                this.tRex.reset();
                this.playSound(this.soundFx.BUTTON_PRESS);
                this.invert(true);
                this.bdayFlashTimer = null;
                this.update();
            }
        },

        setPlayStatus: function(isPlaying) {
            if (this.touchController)
                this.touchController.classList.toggle(HIDDEN_CLASS, !isPlaying);
            this.playing = isPlaying;
        },

        /**
         * Whether the game should go into arcade mode.
         * @return {boolean}
         */
        isArcadeMode: function() {
            return document.title == ARCADE_MODE_URL;
        },

        /**
         * Hides offline messaging for a fullscreen game only experience.
         */
        setArcadeMode: function() {
            document.body.classList.add(Runner.classes.ARCADE_MODE);
            this.setArcadeModeContainerScale();
        },

        /**
         * Sets the scaling for arcade mode.
         */
        setArcadeModeContainerScale: function() {
            let windowHeight = window.innerHeight;
            let scaleHeight = windowHeight / this.dimensions.HEIGHT;
            let scaleWidth = window.innerWidth / this.dimensions.WIDTH;
            let scale = Math.max(1, Math.min(scaleHeight, scaleWidth));
            let scaledCanvasHeight = this.dimensions.HEIGHT * scale;
            // Positions the game container at 10% of the available vertical window
            // height minus the game container height.
            let translateY = Math.ceil(Math.max(0, (windowHeight - scaledCanvasHeight -
                Runner.config.ARCADE_MODE_INITIAL_TOP_POSITION) *
                Runner.config.ARCADE_MODE_TOP_POSITION_PERCENT)) *
                window.devicePixelRatio;
            this.containerEl.style.transform = 'scale(' + scale + ') translateY(' +
                translateY + 'px)';
        },

        /**
         * Pause the game if the tab is not in focus.
         */
        onVisibilityChange: function(e) {
            if (document.hidden || document.webkitHidden || e.type == 'blur' ||
                document.visibilityState != 'visible') {
                this.stop();
            } else if (!this.crashed) {
                this.tRex.reset();
                this.play();
            }
        },

        /**
         * Play a sound.
         * @param {SoundBuffer} soundBuffer
         */
        playSound: function(soundBuffer) {
            if (soundBuffer) {
                let sourceNode = this.audioContext.createBufferSource();
                sourceNode.buffer = soundBuffer;
                sourceNode.connect(this.audioContext.destination);
                sourceNode.start(0);
            }
        },

        /**
         * Inverts the current page / canvas colors.
         * @param {boolean} Whether to reset colors.
         */
        invert: function(reset) {
            let htmlEl = document.firstElementChild;

            if (reset) {
                htmlEl.classList.toggle(Runner.classes.INVERTED,
                    false);
                this.invertTimer = 0;
                this.inverted = false;
            } else {
                this.inverted = htmlEl.classList.toggle(
                    Runner.classes.INVERTED, this.invertTrigger);
            }
        }
    };


    /**
     * Updates the canvas size taking into
     * account the backing store pixel ratio and
     * the device pixel ratio.
     *
     * See article by Paul Lewis:
     * http://www.html5rocks.com/en/tutorials/canvas/hidpi/
     *
     * @param {HTMLCanvasElement} canvas
     * @param {number} opt_width
     * @param {number} opt_height
     * @return {boolean} Whether the canvas was scaled.
     */
    Runner.updateCanvasScaling = function(canvas, opt_width, opt_height) {
        let context = canvas.getContext('2d');

        // Query the various pixel ratios
        let devicePixelRatio = Math.floor(window.devicePixelRatio) || 1;
        let backingStoreRatio = Math.floor(context.webkitBackingStorePixelRatio) || 1;
        let ratio = devicePixelRatio / backingStoreRatio;

        // Upscale the canvas if the two ratios don't match
        if (devicePixelRatio !== backingStoreRatio) {
            let oldWidth = opt_width || canvas.width;
            let oldHeight = opt_height || canvas.height;

            canvas.width = oldWidth * ratio;
            canvas.height = oldHeight * ratio;

            canvas.style.width = oldWidth + 'px';
            canvas.style.height = oldHeight + 'px';

            // Scale the context to counter the fact that we've manually scaled
            // our canvas element.
            context.scale(ratio, ratio);
            return true;
        } else if (devicePixelRatio == 1) {
            // Reset the canvas width / height. Fixes scaling bug when the page is
            // zoomed and the devicePixelRatio changes accordingly.
            canvas.style.width = canvas.width + 'px';
            canvas.style.height = canvas.height + 'px';
        }
        return false;
    };


    /**
     * Get random number.
     * @param {number} min
     * @param {number} max
     * @param {number}
     */
    function getRandomNum(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }


    /**
     * Vibrate on mobile devices.
     * @param {number} duration Duration of the vibration in milliseconds.
     */
    function vibrate(duration) {
        if (IS_MOBILE && window.navigator.vibrate) {
            window.navigator.vibrate(duration);
        }
    }


    /**
     * Create canvas element.
     * @param {HTMLElement} container Element to append canvas to.
     * @param {number} width
     * @param {number} height
     * @param {string} opt_classname
     * @return {HTMLCanvasElement}
     */
    function createCanvas(container, width, height, opt_classname) {
        let canvas = document.createElement('canvas');
        canvas.className = opt_classname ? Runner.classes.CANVAS + ' ' +
            opt_classname : Runner.classes.CANVAS;
        canvas.width = width;
        canvas.height = height;
        container.appendChild(canvas);

        return canvas;
    }


    /**
     * Decodes the base 64 audio to ArrayBuffer used by Web Audio.
     * @param {string} base64String
     */
    function decodeBase64ToArrayBuffer(base64String) {
        let len = (base64String.length / 4) * 3;
        let str = atob(base64String);
        let arrayBuffer = new ArrayBuffer(len);
        let bytes = new Uint8Array(arrayBuffer);

        for (let i = 0; i < len; i++) {
            bytes[i] = str.charCodeAt(i);
        }
        return bytes.buffer;
    }


    /**
     * Return the current timestamp.
     * @return {number}
     */
    function getTimeStamp() {
        return IS_IOS ? new Date().getTime() : performance.now();
    }


//******************************************************************************


    /**
     * Game over panel.
     * @param {!HTMLCanvasElement} canvas
     * @param {Object} textImgPos
     * @param {Object} restartImgPos
     * @param {!Object} dimensions Canvas dimensions.
     * @constructor
     */
    function GameOverPanel(canvas, textImgPos, restartImgPos, dimensions) {
        this.canvas = canvas;
        this.canvasCtx = canvas.getContext('2d');
        this.canvasDimensions = dimensions;
        this.textImgPos = textImgPos;
        this.restartImgPos = restartImgPos;
        this.draw();
    };


    /**
     * Dimensions used in the panel.
     * @enum {number}
     */
    GameOverPanel.dimensions = {
        TEXT_X: 0,
        TEXT_Y: 13,
        TEXT_WIDTH: 191,
        TEXT_HEIGHT: 11,
        RESTART_WIDTH: 36,
        RESTART_HEIGHT: 32
    };


    GameOverPanel.prototype = {
        /**
         * Update the panel dimensions.
         * @param {number} width New canvas width.
         * @param {number} opt_height Optional new canvas height.
         */
        updateDimensions: function(width, opt_height) {
            this.canvasDimensions.WIDTH = width;
            if (opt_height) {
                this.canvasDimensions.HEIGHT = opt_height;
            }
        },

        /**
         * Draw the panel.
         */
        draw: function() {
            let dimensions = GameOverPanel.dimensions;

            let centerX = this.canvasDimensions.WIDTH / 2;

            // Game over text.
            let textSourceX = dimensions.TEXT_X;
            let textSourceY = dimensions.TEXT_Y;
            let textSourceWidth = dimensions.TEXT_WIDTH;
            let textSourceHeight = dimensions.TEXT_HEIGHT;

            let textTargetX = Math.round(centerX - (dimensions.TEXT_WIDTH / 2));
            let textTargetY = Math.round((this.canvasDimensions.HEIGHT - 25) / 3);
            let textTargetWidth = dimensions.TEXT_WIDTH;
            let textTargetHeight = dimensions.TEXT_HEIGHT;

            let restartSourceWidth = dimensions.RESTART_WIDTH;
            let restartSourceHeight = dimensions.RESTART_HEIGHT;
            let restartTargetX = centerX - (dimensions.RESTART_WIDTH / 2);
            let restartTargetY = this.canvasDimensions.HEIGHT / 2;

            if (IS_HIDPI) {
                textSourceY *= 2;
                textSourceX *= 2;
                textSourceWidth *= 2;
                textSourceHeight *= 2;
                restartSourceWidth *= 2;
                restartSourceHeight *= 2;
            }

            textSourceX += this.textImgPos.x;
            textSourceY += this.textImgPos.y;

            // Game over text from sprite.
            this.canvasCtx.drawImage(Runner.imageSprite,
                textSourceX, textSourceY, textSourceWidth, textSourceHeight,
                textTargetX, textTargetY, textTargetWidth, textTargetHeight);

            // Restart button.
            this.canvasCtx.drawImage(Runner.imageSprite,
                this.restartImgPos.x, this.restartImgPos.y,
                restartSourceWidth, restartSourceHeight,
                restartTargetX, restartTargetY, dimensions.RESTART_WIDTH,
                dimensions.RESTART_HEIGHT);
        }
    };


//******************************************************************************

    /**
     * Check for a collision.
     * @param {!Obstacle} obstacle
     * @param {!Trex} tRex T-rex object.
     * @param {HTMLCanvasContext} opt_canvasCtx Optional canvas context for drawing
     *    collision boxes.
     * @return {Array<CollisionBox>}
     */
    function checkForCollision(obstacle, tRex, opt_canvasCtx) {
        let obstacleBoxXPos = Runner.defaultDimensions.WIDTH + obstacle.xPos;

        // Adjustments are made to the bounding box as there is a 1 pixel white
        // border around the t-rex and obstacles.
        let tRexBox = new CollisionBox(
            tRex.xPos + 1,
            tRex.yPos + 1,
            tRex.config.WIDTH - 2,
            tRex.config.HEIGHT - 2);

        let obstacleBox = new CollisionBox(
            obstacle.xPos + 1,
            obstacle.yPos + 1,
            obstacle.typeConfig.width * obstacle.size - 2,
            obstacle.typeConfig.height - 2);

        // Debug outer box
        if (opt_canvasCtx) {
            drawCollisionBoxes(opt_canvasCtx, tRexBox, obstacleBox);
        }

        // Simple outer bounds check.
        if (boxCompare(tRexBox, obstacleBox)) {
            let collisionBoxes = obstacle.collisionBoxes;
            let tRexCollisionBoxes = tRex.ducking ?
                Trex.collisionBoxes.DUCKING : Trex.collisionBoxes.RUNNING;

            // Detailed axis aligned box check.
            for (let t = 0; t < tRexCollisionBoxes.length; t++) {
                for (let i = 0; i < collisionBoxes.length; i++) {
                    // Adjust the box to actual positions.
                    let adjTrexBox =
                        createAdjustedCollisionBox(tRexCollisionBoxes[t], tRexBox);
                    let adjObstacleBox =
                        createAdjustedCollisionBox(collisionBoxes[i], obstacleBox);
                    let crashed = boxCompare(adjTrexBox, adjObstacleBox);

                    // Draw boxes for debug.
                    if (opt_canvasCtx) {
                        drawCollisionBoxes(opt_canvasCtx, adjTrexBox, adjObstacleBox);
                    }

                    if (crashed) {
                        return [adjTrexBox, adjObstacleBox];
                    }
                }
            }
        }
        return false;
    };


    /**
     * Adjust the collision box.
     * @param {!CollisionBox} box The original box.
     * @param {!CollisionBox} adjustment Adjustment box.
     * @return {CollisionBox} The adjusted collision box object.
     */
    function createAdjustedCollisionBox(box, adjustment) {
        return new CollisionBox(
            box.x + adjustment.x,
            box.y + adjustment.y,
            box.width,
            box.height);
    };


    /**
     * Draw the collision boxes for debug.
     */
    function drawCollisionBoxes(canvasCtx, tRexBox, obstacleBox) {
        canvasCtx.save();
        canvasCtx.strokeStyle = '#f00';
        canvasCtx.strokeRect(tRexBox.x, tRexBox.y, tRexBox.width, tRexBox.height);

        canvasCtx.strokeStyle = '#0f0';
        canvasCtx.strokeRect(obstacleBox.x, obstacleBox.y,
            obstacleBox.width, obstacleBox.height);
        canvasCtx.restore();
    };


    /**
     * Compare two collision boxes for a collision.
     * @param {CollisionBox} tRexBox
     * @param {CollisionBox} obstacleBox
     * @return {boolean} Whether the boxes intersected.
     */
    function boxCompare(tRexBox, obstacleBox) {
        let crashed = false;
        let tRexBoxX = tRexBox.x;
        let tRexBoxY = tRexBox.y;

        let obstacleBoxX = obstacleBox.x;
        let obstacleBoxY = obstacleBox.y;

        // Axis-Aligned Bounding Box method.
        if (tRexBox.x < obstacleBoxX + obstacleBox.width &&
            tRexBox.x + tRexBox.width > obstacleBoxX &&
            tRexBox.y < obstacleBox.y + obstacleBox.height &&
            tRexBox.height + tRexBox.y > obstacleBox.y) {
            crashed = true;
        }

        return crashed;
    };


//******************************************************************************

    /**
     * Collision box object.
     * @param {number} x X position.
     * @param {number} y Y Position.
     * @param {number} w Width.
     * @param {number} h Height.
     */
    function CollisionBox(x, y, w, h) {
        this.x = x;
        this.y = y;
        this.width = w;
        this.height = h;
    };


//******************************************************************************

    /**
     * Obstacle.
     * @param {HTMLCanvasCtx} canvasCtx
     * @param {Obstacle.type} type
     * @param {Object} spritePos Obstacle position in sprite.
     * @param {Object} dimensions
     * @param {number} gapCoefficient Mutipler in determining the gap.
     * @param {number} speed
     * @param {number} opt_xOffset
     */
    function Obstacle(canvasCtx, type, spriteImgPos, dimensions,
                      gapCoefficient, speed, opt_xOffset) {

        this.canvasCtx = canvasCtx;
        this.spritePos = spriteImgPos;
        this.typeConfig = type;
        this.gapCoefficient = gapCoefficient;
        this.size = getRandomNum(1, Obstacle.MAX_OBSTACLE_LENGTH);
        this.dimensions = dimensions;
        this.remove = false;
        this.xPos = dimensions.WIDTH + (opt_xOffset || 0);
        this.yPos = 0;
        this.width = 0;
        this.collisionBoxes = [];
        this.gap = 0;
        this.speedOffset = 0;

        // For animated obstacles.
        this.currentFrame = 0;
        this.timer = 0;

        this.init(speed);
    };

    /**
     * Coefficient for calculating the maximum gap.
     * @const
     */
    Obstacle.MAX_GAP_COEFFICIENT = 1.5;

    /**
     * Maximum obstacle grouping count.
     * @const
     */
    Obstacle.MAX_OBSTACLE_LENGTH = 3,


        Obstacle.prototype = {
            /**
             * Initialise the DOM for the obstacle.
             * @param {number} speed
             */
            init: function(speed) {
                this.cloneCollisionBoxes();

                // Only allow sizing if we're at the right speed.
                if (this.size > 1 && this.typeConfig.multipleSpeed > speed) {
                    this.size = 1;
                }

                this.width = this.typeConfig.width * this.size;

                // Check if obstacle can be positioned at various heights.
                if (Array.isArray(this.typeConfig.yPos))  {
                    let yPosConfig = IS_MOBILE ? this.typeConfig.yPosMobile :
                        this.typeConfig.yPos;
                    this.yPos = yPosConfig[getRandomNum(0, yPosConfig.length - 1)];
                } else {
                    this.yPos = this.typeConfig.yPos;
                }

                this.draw();

                // Make collision box adjustments,
                // Central box is adjusted to the size as one box.
                //      ____        ______        ________
                //    _|   |-|    _|     |-|    _|       |-|
                //   | |<->| |   | |<--->| |   | |<----->| |
                //   | | 1 | |   | |  2  | |   | |   3   | |
                //   |_|___|_|   |_|_____|_|   |_|_______|_|
                //
                if (this.size > 1) {
                    this.collisionBoxes[1].width = this.width - this.collisionBoxes[0].width -
                        this.collisionBoxes[2].width;
                    this.collisionBoxes[2].x = this.width - this.collisionBoxes[2].width;
                }

                // For obstacles that go at a different speed from the horizon.
                if (this.typeConfig.speedOffset) {
                    this.speedOffset = Math.random() > 0.5 ? this.typeConfig.speedOffset :
                        -this.typeConfig.speedOffset;
                }

                this.gap = this.getGap(this.gapCoefficient, speed);
            },

            /**
             * Draw and crop based on size.
             */
            draw: function() {
                let sourceWidth = this.typeConfig.width;
                let sourceHeight = this.typeConfig.height;

                if (IS_HIDPI) {
                    sourceWidth = sourceWidth * 2;
                    sourceHeight = sourceHeight * 2;
                }

                // X position in sprite.
                let sourceX = (sourceWidth * this.size) * (0.5 * (this.size - 1)) +
                    this.spritePos.x;

                // Animation frames.
                if (this.currentFrame > 0) {
                    sourceX += sourceWidth * this.currentFrame;
                }

                this.canvasCtx.drawImage(Runner.imageSprite,
                    sourceX, this.spritePos.y,
                    sourceWidth * this.size, sourceHeight,
                    this.xPos, this.yPos,
                    this.typeConfig.width * this.size, this.typeConfig.height);
            },

            /**
             * Obstacle frame update.
             * @param {number} deltaTime
             * @param {number} speed
             */
            update: function(deltaTime, speed) {
                if (!this.remove) {
                    if (this.typeConfig.speedOffset) {
                        speed += this.speedOffset;
                    }
                    this.xPos -= Math.floor((speed * FPS / 1000) * deltaTime);

                    // Update frame
                    if (this.typeConfig.numFrames) {
                        this.timer += deltaTime;
                        if (this.timer >= this.typeConfig.frameRate) {
                            this.currentFrame =
                                this.currentFrame == this.typeConfig.numFrames - 1 ?
                                    0 : this.currentFrame + 1;
                            this.timer = 0;
                        }
                    }
                    this.draw();

                    if (!this.isVisible()) {
                        this.remove = true;
                    }
                }
            },

            /**
             * Calculate a random gap size.
             * - Minimum gap gets wider as speed increses
             * @param {number} gapCoefficient
             * @param {number} speed
             * @return {number} The gap size.
             */
            getGap: function(gapCoefficient, speed) {
                let minGap = Math.round(this.width * speed +
                    this.typeConfig.minGap * gapCoefficient);
                let maxGap = Math.round(minGap * Obstacle.MAX_GAP_COEFFICIENT);
                return getRandomNum(minGap, maxGap);
            },

            /**
             * Check if obstacle is visible.
             * @return {boolean} Whether the obstacle is in the game area.
             */
            isVisible: function() {
                return this.xPos + this.width > 0;
            },

            /**
             * Make a copy of the collision boxes, since these will change based on
             * obstacle type and size.
             */
            cloneCollisionBoxes: function() {
                let collisionBoxes = this.typeConfig.collisionBoxes;

                for (let i = collisionBoxes.length - 1; i >= 0; i--) {
                    this.collisionBoxes[i] = new CollisionBox(collisionBoxes[i].x,
                        collisionBoxes[i].y, collisionBoxes[i].width,
                        collisionBoxes[i].height);
                }
            }
        };


    /**
     * Obstacle definitions.
     * minGap: minimum pixel space betweeen obstacles.
     * multipleSpeed: Speed at which multiples are allowed.
     * speedOffset: speed faster / slower than the horizon.
     * minSpeed: Minimum speed which the obstacle can make an appearance.
     */
    Obstacle.types = [
        {
            type: 'CACTUS_SMALL',
            width: 17,
            height: 35,
            yPos: 105,
            multipleSpeed: 4,
            minGap: 120,
            minSpeed: 0,
            collisionBoxes: [
                new CollisionBox(0, 7, 5, 27),
                new CollisionBox(4, 0, 6, 34),
                new CollisionBox(10, 4, 7, 14)
            ]
        },
        {
            type: 'CACTUS_LARGE',
            width: 25,
            height: 50,
            yPos: 90,
            multipleSpeed: 7,
            minGap: 120,
            minSpeed: 0,
            collisionBoxes: [
                new CollisionBox(0, 12, 7, 38),
                new CollisionBox(8, 0, 7, 49),
                new CollisionBox(13, 10, 10, 38)
            ]
        },
        {
            type: 'PTERODACTYL',
            width: 46,
            height: 40,
            yPos: [ 100, 75, 50 ], // Variable height.
            yPosMobile: [ 100, 50 ], // Variable height mobile.
            multipleSpeed: 999,
            minSpeed: 8.5,
            minGap: 150,
            collisionBoxes: [
                new CollisionBox(15, 15, 16, 5),
                new CollisionBox(18, 21, 24, 6),
                new CollisionBox(2, 14, 4, 3),
                new CollisionBox(6, 10, 4, 7),
                new CollisionBox(10, 8, 6, 9)
            ],
            numFrames: 2,
            frameRate: 1000/6,
            speedOffset: .8
        }
    ];


//******************************************************************************
    /**
     * T-rex game character.
     * @param {HTMLCanvas} canvas
     * @param {Object} spritePos Positioning within image sprite.
     * @constructor
     */
    function Trex(canvas, spritePos) {
        this.canvas = canvas;
        this.canvasCtx = canvas.getContext('2d');
        this.spritePos = spritePos;
        this.xPos = 0;
        this.yPos = 0;
        this.xInitialPos = 0;
        // Position when on the ground.
        this.groundYPos = 0;
        this.currentFrame = 0;
        this.currentAnimFrames = [];
        this.blinkDelay = 0;
        this.blinkCount = 0;
        this.animStartTime = 0;
        this.timer = 0;
        this.msPerFrame = 1000 / FPS;
        this.config = Trex.config;
        // Current status.
        this.status = Trex.status.WAITING;
        this.jumping = false;
        this.ducking = false;
        this.jumpVelocity = 0;
        this.reachedMinHeight = false;
        this.speedDrop = false;
        this.jumpCount = 0;
        this.jumpspotX = 0;

        this.init();
    };


    /**
     * T-rex player config.
     * @enum {number}
     */
    Trex.config = {
        DROP_VELOCITY: -5,
        GRAVITY: 0.6,
        HEIGHT: 47,
        HEIGHT_DUCK: 25,
        INIITAL_JUMP_VELOCITY: -10,
        INTRO_DURATION: 1500,
        MAX_JUMP_HEIGHT: 30,
        MIN_JUMP_HEIGHT: 30,
        SPEED_DROP_COEFFICIENT: 3,
        SPRITE_WIDTH: 262,
        START_X_POS: 50,
        WIDTH: 44,
        WIDTH_DUCK: 59
    };


    /**
     * Used in collision detection.
     * @type {Array<CollisionBox>}
     */
    Trex.collisionBoxes = {
        DUCKING: [
            new CollisionBox(1, 18, 55, 25)
        ],
        RUNNING: [
            new CollisionBox(22, 0, 17, 16),
            new CollisionBox(1, 18, 30, 9),
            new CollisionBox(10, 35, 14, 8),
            new CollisionBox(1, 24, 29, 5),
            new CollisionBox(5, 30, 21, 4),
            new CollisionBox(9, 34, 15, 4)
        ]
    };


    /**
     * Animation states.
     * @enum {string}
     */
    Trex.status = {
        CRASHED: 'CRASHED',
        DUCKING: 'DUCKING',
        JUMPING: 'JUMPING',
        RUNNING: 'RUNNING',
        WAITING: 'WAITING'
    };

    /**
     * Blinking coefficient.
     * @const
     */
    Trex.BLINK_TIMING = 7000;


    /**
     * Animation config for different states.
     * @enum {Object}
     */
    Trex.animFrames = {
        WAITING: {
            frames: [44, 0],
            msPerFrame: 1000 / 3
        },
        RUNNING: {
            frames: [88, 132],
            msPerFrame: 1000 / 12
        },
        CRASHED: {
            frames: [220],
            msPerFrame: 1000 / 60
        },
        JUMPING: {
            frames: [0],
            msPerFrame: 1000 / 60
        },
        DUCKING: {
            frames: [264, 323],
            msPerFrame: 1000 / 8
        }
    };


    Trex.prototype = {
        /**
         * T-rex player initaliser.
         * Sets the t-rex to blink at random intervals.
         */
        init: function() {
            this.groundYPos = Runner.defaultDimensions.HEIGHT - this.config.HEIGHT -
                Runner.config.BOTTOM_PAD;
            this.yPos = this.groundYPos;
            this.minJumpHeight = this.groundYPos - this.config.MIN_JUMP_HEIGHT;

            this.draw(0, 0);
            this.update(0, Trex.status.WAITING);
        },

        /**
         * Setter for the jump velocity.
         * The approriate drop velocity is also set.
         */
        setJumpVelocity: function(setting) {
            this.config.INIITAL_JUMP_VELOCITY = -setting;
            this.config.DROP_VELOCITY = -setting / 2;
        },

        /**
         * Set the animation status.
         * @param {!number} deltaTime
         * @param {Trex.status} status Optional status to switch to.
         */
        update: function(deltaTime, opt_status) {
            this.timer += deltaTime;

            // Update the status.
            if (opt_status) {
                this.status = opt_status;
                this.currentFrame = 0;
                this.msPerFrame = Trex.animFrames[opt_status].msPerFrame;
                this.currentAnimFrames = Trex.animFrames[opt_status].frames;

                if (opt_status == Trex.status.WAITING) {
                    this.animStartTime = getTimeStamp();
                    this.setBlinkDelay();
                }
            }

            // Game intro animation, T-rex moves in from the left.
            if (this.playingIntro && this.xPos < this.config.START_X_POS) {
                this.xPos += Math.round((this.config.START_X_POS /
                    this.config.INTRO_DURATION) * deltaTime);
                this.xInitialPos = this.xPos;
            }

            if (this.status == Trex.status.WAITING) {
                this.blink(getTimeStamp());
            } else {
                this.draw(this.currentAnimFrames[this.currentFrame], 0);
            }

            // Update the frame position.
            if (this.timer >= this.msPerFrame) {
                this.currentFrame = this.currentFrame ==
                this.currentAnimFrames.length - 1 ? 0 : this.currentFrame + 1;
                this.timer = 0;
            }

            // Speed drop becomes duck if the down key is still being pressed.
            if (this.speedDrop && this.yPos == this.groundYPos) {
                this.speedDrop = false;
                this.setDuck(true);
            }
        },

        /**
         * Draw the t-rex to a particular position.
         * @param {number} x
         * @param {number} y
         */
        draw: function(x, y) {
            let sourceX = x;
            let sourceY = y;
            let sourceWidth = this.ducking && this.status != Trex.status.CRASHED ?
                this.config.WIDTH_DUCK : this.config.WIDTH;
            let sourceHeight = this.config.HEIGHT;
            let outputHeight = sourceHeight;

            if (IS_HIDPI) {
                sourceX *= 2;
                sourceY *= 2;
                sourceWidth *= 2;
                sourceHeight *= 2;
            }

            // Adjustments for sprite sheet position.
            sourceX += this.spritePos.x;
            sourceY += this.spritePos.y;

            // Ducking.
            if (this.ducking && this.status != Trex.status.CRASHED) {
                this.canvasCtx.drawImage(Runner.imageSprite, sourceX, sourceY,
                    sourceWidth, sourceHeight,
                    this.xPos, this.yPos,
                    this.config.WIDTH_DUCK, outputHeight);
            } else {
                // Crashed whilst ducking. Trex is standing up so needs adjustment.
                if (this.ducking && this.status == Trex.status.CRASHED) {
                    this.xPos++;
                }
                // Standing / running
                this.canvasCtx.drawImage(Runner.imageSprite, sourceX, sourceY,
                    sourceWidth, sourceHeight,
                    this.xPos, this.yPos,
                    this.config.WIDTH, outputHeight);
            }
            this.canvasCtx.globalAlpha = 1;
        },

        /**
         * Sets a random time for the blink to happen.
         */
        setBlinkDelay: function() {
            this.blinkDelay = Math.ceil(Math.random() * Trex.BLINK_TIMING);
        },

        /**
         * Make t-rex blink at random intervals.
         * @param {number} time Current time in milliseconds.
         */
        blink: function(time) {
            let deltaTime = time - this.animStartTime;

            if (deltaTime >= this.blinkDelay) {
                this.draw(this.currentAnimFrames[this.currentFrame], 0);

                if (this.currentFrame == 1) {
                    // Set new random delay to blink.
                    this.setBlinkDelay();
                    this.animStartTime = time;
                    this.blinkCount++;
                }
            }
        },

        /**
         * Initialise a jump.
         * @param {number} speed
         */
        startJump: function(speed) {
            if (!this.jumping) {
                this.update(0, Trex.status.JUMPING);
                // Tweak the jump velocity based on the speed.
                this.jumpVelocity = this.config.INIITAL_JUMP_VELOCITY - (speed / 10);
                this.jumping = true;
                this.reachedMinHeight = false;
                this.speedDrop = false;
            }
        },

        /**
         * Jump is complete, falling down.
         */
        endJump: function() {
            if (this.reachedMinHeight &&
                this.jumpVelocity < this.config.DROP_VELOCITY) {
                this.jumpVelocity = this.config.DROP_VELOCITY;
            }
        },

        /**
         * Update frame for a jump.
         * @param {number} deltaTime
         * @param {number} speed
         */
        updateJump: function(deltaTime, speed) {
            let msPerFrame = Trex.animFrames[this.status].msPerFrame;
            let framesElapsed = deltaTime / msPerFrame;

            // Speed drop makes Trex fall faster.
            if (this.speedDrop) {
                this.yPos += Math.round(this.jumpVelocity *
                    this.config.SPEED_DROP_COEFFICIENT * framesElapsed);
            } else {
                this.yPos += Math.round(this.jumpVelocity * framesElapsed);
            }

            this.jumpVelocity += this.config.GRAVITY * framesElapsed;

            // Minimum height has been reached.
            if (this.yPos < this.minJumpHeight || this.speedDrop) {
                this.reachedMinHeight = true;
            }

            // Reached max height
            if (this.yPos < this.config.MAX_JUMP_HEIGHT || this.speedDrop) {
                this.endJump();
            }

            // Back down at ground level. Jump completed.
            if (this.yPos > this.groundYPos) {
                this.reset();
                this.jumpCount++;
            }
        },

        /**
         * Set the speed drop. Immediately cancels the current jump.
         */
        setSpeedDrop: function() {
            this.speedDrop = true;
            this.jumpVelocity = 1;
        },

        /**
         * @param {boolean} isDucking.
         */
        setDuck: function(isDucking) {
            if (isDucking && this.status != Trex.status.DUCKING) {
                this.update(0, Trex.status.DUCKING);
                this.ducking = true;
            } else if (this.status == Trex.status.DUCKING) {
                this.update(0, Trex.status.RUNNING);
                this.ducking = false;
            }
        },

        /**
         * Reset the t-rex to running at start of game.
         */
        reset: function() {
            this.xPos = this.xInitialPos;
            this.yPos = this.groundYPos;
            this.jumpVelocity = 0;
            this.jumping = false;
            this.ducking = false;
            this.update(0, Trex.status.RUNNING);
            this.midair = false;
            this.speedDrop = false;
            this.jumpCount = 0;
        }
    };


//******************************************************************************

    /**
     * Handles displaying the distance meter.
     * @param {!HTMLCanvasElement} canvas
     * @param {Object} spritePos Image position in sprite.
     * @param {number} canvasWidth
     * @constructor
     */
    function DistanceMeter(canvas, spritePos, canvasWidth) {
        this.canvas = canvas;
        this.canvasCtx = canvas.getContext('2d');
        this.image = Runner.imageSprite;
        this.spritePos = spritePos;
        this.x = 0;
        this.y = 5;

        this.currentDistance = 0;
        this.maxScore = 0;
        this.highScore = 0;
        this.container = null;

        this.digits = [];
        this.achievement = false;
        this.defaultString = '';
        this.flashTimer = 0;
        this.flashIterations = 0;
        this.invertTrigger = false;
        this.flashingRafId = null;
        this.highScoreBounds = {};
        this.highScoreFlashing = false;

        this.config = DistanceMeter.config;
        this.maxScoreUnits = this.config.MAX_DISTANCE_UNITS;
        this.init(canvasWidth);
    };


    /**
     * @enum {number}
     */
    DistanceMeter.dimensions = {
        WIDTH: 10,
        HEIGHT: 13,
        DEST_WIDTH: 11
    };


    /**
     * Y positioning of the digits in the sprite sheet.
     * X position is always 0.
     * @type {Array<number>}
     */
    DistanceMeter.yPos = [0, 13, 27, 40, 53, 67, 80, 93, 107, 120];


    /**
     * Distance meter config.
     * @enum {number}
     */
    DistanceMeter.config = {
        // Number of digits.
        MAX_DISTANCE_UNITS: 5,

        // Distance that causes achievement animation.
        ACHIEVEMENT_DISTANCE: 100,

        // Used for conversion from pixel distance to a scaled unit.
        COEFFICIENT: 0.025,

        // Flash duration in milliseconds.
        FLASH_DURATION: 1000 / 4,

        // Flash iterations for achievement animation.
        FLASH_ITERATIONS: 3,

        // Padding around the high score hit area.
        HIGH_SCORE_HIT_AREA_PADDING: 4
    };


    DistanceMeter.prototype = {
        /**
         * Initialise the distance meter to '00000'.
         * @param {number} width Canvas width in px.
         */
        init: function(width) {
            let maxDistanceStr = '';

            this.calcXPos(width);
            this.maxScore = this.maxScoreUnits;
            for (let i = 0; i < this.maxScoreUnits; i++) {
                this.draw(i, 0);
                this.defaultString += '0';
                maxDistanceStr += '9';
            }

            this.maxScore = parseInt(maxDistanceStr);
        },

        /**
         * Calculate the xPos in the canvas.
         * @param {number} canvasWidth
         */
        calcXPos: function(canvasWidth) {
            this.x = canvasWidth - (DistanceMeter.dimensions.DEST_WIDTH *
                (this.maxScoreUnits + 1));
        },

        /**
         * Draw a digit to canvas.
         * @param {number} digitPos Position of the digit.
         * @param {number} value Digit value 0-9.
         * @param {boolean} opt_highScore Whether drawing the high score.
         */
        draw: function(digitPos, value, opt_highScore) {
            let sourceWidth = DistanceMeter.dimensions.WIDTH;
            let sourceHeight = DistanceMeter.dimensions.HEIGHT;
            let sourceX = DistanceMeter.dimensions.WIDTH * value;
            let sourceY = 0;

            let targetX = digitPos * DistanceMeter.dimensions.DEST_WIDTH;
            let targetY = this.y;
            let targetWidth = DistanceMeter.dimensions.WIDTH;
            let targetHeight = DistanceMeter.dimensions.HEIGHT;

            // For high DPI we 2x source values.
            if (IS_HIDPI) {
                sourceWidth *= 2;
                sourceHeight *= 2;
                sourceX *= 2;
            }

            sourceX += this.spritePos.x;
            sourceY += this.spritePos.y;

            this.canvasCtx.save();

            if (opt_highScore) {
                // Left of the current score.
                let highScoreX = this.x - (this.maxScoreUnits * 2) *
                    DistanceMeter.dimensions.WIDTH;
                this.canvasCtx.translate(highScoreX, this.y);
            } else {
                this.canvasCtx.translate(this.x, this.y);
            }

            this.canvasCtx.drawImage(this.image, sourceX, sourceY,
                sourceWidth, sourceHeight,
                targetX, targetY,
                targetWidth, targetHeight
            );

            this.canvasCtx.restore();
        },

        /**
         * Covert pixel distance to a 'real' distance.
         * @param {number} distance Pixel distance ran.
         * @return {number} The 'real' distance ran.
         */
        getActualDistance: function(distance) {
            return distance ? Math.round(distance * this.config.COEFFICIENT) : 0;
        },

        /**
         * Update the distance meter.
         * @param {number} distance
         * @param {number} deltaTime
         * @return {boolean} Whether the acheivement sound fx should be played.
         */
        update: function(deltaTime, distance) {
            let paint = true;
            let playSound = false;

            if (!this.achievement) {
                distance = this.getActualDistance(distance);
                // Score has gone beyond the initial digit count.
                if (distance > this.maxScore && this.maxScoreUnits ==
                    this.config.MAX_DISTANCE_UNITS) {
                    this.maxScoreUnits++;
                    this.maxScore = parseInt(this.maxScore + '9');
                } else {
                    this.distance = 0;
                }

                if (distance > 0) {
                    // Acheivement unlocked
                    if (distance % this.config.ACHIEVEMENT_DISTANCE == 0) {
                        // Flash score and play sound.
                        this.achievement = true;
                        this.flashTimer = 0;
                        playSound = true;
                    }

                    // Create a string representation of the distance with leading 0.
                    let distanceStr = (this.defaultString +
                        distance).substr(-this.maxScoreUnits);
                    this.digits = distanceStr.split('');
                } else {
                    this.digits = this.defaultString.split('');
                }
            } else {
                // Control flashing of the score on reaching acheivement.
                if (this.flashIterations <= this.config.FLASH_ITERATIONS) {
                    this.flashTimer += deltaTime;

                    if (this.flashTimer < this.config.FLASH_DURATION) {
                        paint = false;
                    } else if (this.flashTimer >
                        this.config.FLASH_DURATION * 2) {
                        this.flashTimer = 0;
                        this.flashIterations++;
                    }
                } else {
                    this.achievement = false;
                    this.flashIterations = 0;
                    this.flashTimer = 0;
                }
            }

            // Draw the digits if not flashing.
            if (paint) {
                for (let i = this.digits.length - 1; i >= 0; i--) {
                    this.draw(i, parseInt(this.digits[i]));
                }
            }

            this.drawHighScore();
            return playSound;
        },

        /**
         * Draw the high score.
         */
        drawHighScore: function() {
            this.canvasCtx.save();
            this.canvasCtx.globalAlpha = .8;
            for (let i = this.highScore.length - 1; i >= 0; i--) {
                this.draw(i, parseInt(this.highScore[i], 10), true);
            }
            this.canvasCtx.restore();
        },

        /**
         * Set the highscore as a array string.
         * Position of char in the sprite: H - 10, I - 11.
         * @param {number} distance Distance ran in pixels.
         */
        setHighScore: function(distance) {
            distance = this.getActualDistance(distance);
            let highScoreStr = (this.defaultString +
                distance).substr(-this.maxScoreUnits);

            this.highScore = ['10', '11', ''].concat(highScoreStr.split(''));
        },


        /**
         * Whether a clicked is in the high score area.
         * @param {TouchEvent|ClickEvent} e Event object.
         * @return {boolean} Whether the click was in the high score bounds.
         */
        hasClickedOnHighScore: function(e) {
            let x = 0;
            let y = 0;

            if (e.touches) {
                // Bounds for touch differ from pointer.
                let canvasBounds = this.canvas.getBoundingClientRect();
                x = e.touches[0].clientX - canvasBounds.left;
                y = e.touches[0].clientY - canvasBounds.top;
            } else {
                x = e.offsetX;
                y = e.offsetY;
            }

            this.highScoreBounds = this.getHighScoreBounds();
            return x >= this.highScoreBounds.x && x <=
                this.highScoreBounds.x + this.highScoreBounds.width &&
                y >= this.highScoreBounds.y && y <=
                this.highScoreBounds.y + this.highScoreBounds.height;
        },

        /**
         * Get the bounding box for the high score.
         * @return {Object} Object with x, y, width and height properties.
         */
        getHighScoreBounds: function() {
            return {
                x: (this.x - (this.maxScoreUnits * 2) *
                    DistanceMeter.dimensions.WIDTH) -
                DistanceMeter.config.HIGH_SCORE_HIT_AREA_PADDING,
                y: this.y,
                width: DistanceMeter.dimensions.WIDTH * (this.highScore.length + 1) +
                DistanceMeter.config.HIGH_SCORE_HIT_AREA_PADDING,
                height: DistanceMeter.dimensions.HEIGHT +
                (DistanceMeter.config.HIGH_SCORE_HIT_AREA_PADDING * 2)
            };
        },

        /**
         * Animate flashing the high score to indicate ready for resetting.
         * The flashing stops following this.config.FLASH_ITERATIONS x 2 flashes.
         */
        flashHighScore: function() {
            let now = getTimeStamp();
            let deltaTime = now - (this.frameTimeStamp || now);
            let paint = true;
            this.frameTimeStamp = now;

            // Reached the max number of flashes.
            if (this.flashIterations > this.config.FLASH_ITERATIONS * 2) {
                this.cancelHighScoreFlashing();
                return;
            }

            this.flashTimer += deltaTime;

            if (this.flashTimer < this.config.FLASH_DURATION) {
                paint = false;
            } else if (this.flashTimer > this.config.FLASH_DURATION * 2) {
                this.flashTimer = 0;
                this.flashIterations++;
            }

            if (paint) {
                this.drawHighScore();
            } else {
                this.clearHighScoreBounds();
            }
            // Frame update.
            this.flashingRafId =
                requestAnimationFrame(this.flashHighScore.bind(this));
        },

        /**
         * Draw empty rectangle over high score.
         */
        clearHighScoreBounds: function() {
            this.canvasCtx.save();
            this.canvasCtx.fillStyle = '#fff';
            this.canvasCtx.rect(this.highScoreBounds.x, this.highScoreBounds.y,
                this.highScoreBounds.width, this.highScoreBounds.height);
            this.canvasCtx.fill();
            this.canvasCtx.restore();
        },

        /**
         * Starts the flashing of the high score.
         */
        startHighScoreFlashing() {
            this.highScoreFlashing = true;
            this.flashHighScore();
        },

        /**
         * Whether high score is flashing.
         * @return {boolean}
         */
        isHighScoreFlashing() {
            return this.highScoreFlashing;
        },

        /**
         * Stop flashing the high score.
         */
        cancelHighScoreFlashing: function() {
            cancelAnimationFrame(this.flashingRafId);
            this.flashIterations = 0;
            this.flashTimer = 0;
            this.highScoreFlashing = false;
            this.clearHighScoreBounds();
            this.drawHighScore();
        },

        /**
         * Clear the high score.
         */
        resetHighScore: function() {
            this.setHighScore(0);
            this.cancelHighScoreFlashing();
        },

        /**
         * Reset the distance meter back to '00000'.
         */
        reset: function() {
            this.update(0);
            this.achievement = false;
        }
    };


//******************************************************************************

    /**
     * Cloud background product.
     * Similar to an obstacle object but without collision boxes.
     * @param {HTMLCanvasElement} canvas Canvas element.
     * @param {Object} spritePos Position of image in sprite.
     * @param {number} containerWidth
     */
    function Cloud(canvas, spritePos, containerWidth) {
        this.canvas = canvas;
        this.canvasCtx = this.canvas.getContext('2d');
        this.spritePos = spritePos;
        this.containerWidth = containerWidth;
        this.xPos = containerWidth;
        this.yPos = 0;
        this.remove = false;
        this.cloudGap = getRandomNum(Cloud.config.MIN_CLOUD_GAP,
            Cloud.config.MAX_CLOUD_GAP);

        this.init();
    };


    /**
     * Cloud object config.
     * @enum {number}
     */
    Cloud.config = {
        HEIGHT: 14,
        MAX_CLOUD_GAP: 400,
        MAX_SKY_LEVEL: 30,
        MIN_CLOUD_GAP: 100,
        MIN_SKY_LEVEL: 71,
        WIDTH: 46
    };


    Cloud.prototype = {
        /**
         * Initialise the cloud. Sets the Cloud height.
         */
        init: function() {
            this.yPos = getRandomNum(Cloud.config.MAX_SKY_LEVEL,
                Cloud.config.MIN_SKY_LEVEL);
            this.draw();
        },

        /**
         * Draw the cloud.
         */
        draw: function() {
            this.canvasCtx.save();
            let sourceWidth = Cloud.config.WIDTH;
            let sourceHeight = Cloud.config.HEIGHT;
            let outputWidth = sourceWidth;
            let outputHeight = sourceHeight;
            if (IS_HIDPI) {
                sourceWidth = sourceWidth * 2;
                sourceHeight = sourceHeight * 2;
            }

            this.canvasCtx.drawImage(Runner.imageSprite, this.spritePos.x,
                this.spritePos.y,
                sourceWidth, sourceHeight,
                this.xPos, this.yPos,
                outputWidth, outputHeight);

            this.canvasCtx.restore();
        },

        /**
         * Update the cloud position.
         * @param {number} speed
         */
        update: function(speed) {
            if (!this.remove) {
                this.xPos -= Math.ceil(speed);
                this.draw();

                // Mark as removeable if no longer in the canvas.
                if (!this.isVisible()) {
                    this.remove = true;
                }
            }
        },

        /**
         * Check if the cloud is visible on the stage.
         * @return {boolean}
         */
        isVisible: function() {
            return this.xPos + Cloud.config.WIDTH > 0;
        }
    };


//******************************************************************************

    /**
     * Nightmode shows a moon and stars on the horizon.
     */
    function NightMode(canvas, spritePos, containerWidth) {
        this.spritePos = spritePos;
        this.canvas = canvas;
        this.canvasCtx = canvas.getContext('2d');
        this.xPos = containerWidth - 50;
        this.yPos = 30;
        this.currentPhase = 0;
        this.opacity = 0;
        this.containerWidth = containerWidth;
        this.stars = [];
        this.drawStars = false;
        this.placeStars();
    };

    /**
     * @enum {number}
     */
    NightMode.config = {
        FADE_SPEED: 0.035,
        HEIGHT: 40,
        MOON_SPEED: 0.25,
        NUM_STARS: 2,
        STAR_SIZE: 9,
        STAR_SPEED: 0.3,
        STAR_MAX_Y: 70,
        WIDTH: 20
    };

    NightMode.phases = [140, 120, 100, 60, 40, 20, 0];

    NightMode.prototype = {
        /**
         * Update moving moon, changing phases.
         * @param {boolean} activated Whether night mode is activated.
         * @param {number} delta
         */
        update: function(activated, delta) {
            // Moon phase.
            if (activated && this.opacity == 0) {
                this.currentPhase++;

                if (this.currentPhase >= NightMode.phases.length) {
                    this.currentPhase = 0;
                }
            }

            // Fade in / out.
            if (activated && (this.opacity < 1 || this.opacity == 0)) {
                this.opacity += NightMode.config.FADE_SPEED;
            } else if (this.opacity > 0) {
                this.opacity -= NightMode.config.FADE_SPEED;
            }

            // Set moon positioning.
            if (this.opacity > 0) {
                this.xPos = this.updateXPos(this.xPos, NightMode.config.MOON_SPEED);

                // Update stars.
                if (this.drawStars) {
                    for (let i = 0; i < NightMode.config.NUM_STARS; i++) {
                        this.stars[i].x = this.updateXPos(this.stars[i].x,
                            NightMode.config.STAR_SPEED);
                    }
                }
                this.draw();
            } else {
                this.opacity = 0;
                this.placeStars();
            }
            this.drawStars = true;
        },

        updateXPos: function(currentPos, speed) {
            if (currentPos < -NightMode.config.WIDTH) {
                currentPos = this.containerWidth;
            } else {
                currentPos -= speed;
            }
            return currentPos;
        },

        draw: function() {
            let moonSourceWidth = this.currentPhase == 3 ? NightMode.config.WIDTH * 2 :
                NightMode.config.WIDTH;
            let moonSourceHeight = NightMode.config.HEIGHT;
            let moonSourceX = this.spritePos.x + NightMode.phases[this.currentPhase];
            let moonOutputWidth = moonSourceWidth;
            let starSize = NightMode.config.STAR_SIZE;
            let starSourceX = Runner.spriteDefinition.LDPI.STAR.x;

            if (IS_HIDPI) {
                moonSourceWidth *= 2;
                moonSourceHeight *= 2;
                moonSourceX = this.spritePos.x +
                    (NightMode.phases[this.currentPhase] * 2);
                starSize *= 2;
                starSourceX = Runner.spriteDefinition.HDPI.STAR.x;
            }

            this.canvasCtx.save();
            this.canvasCtx.globalAlpha = this.opacity;

            // Stars.
            if (this.drawStars) {
                for (let i = 0; i < NightMode.config.NUM_STARS; i++) {
                    this.canvasCtx.drawImage(Runner.imageSprite,
                        starSourceX, this.stars[i].sourceY, starSize, starSize,
                        Math.round(this.stars[i].x), this.stars[i].y,
                        NightMode.config.STAR_SIZE, NightMode.config.STAR_SIZE);
                }
            }

            // Moon.
            this.canvasCtx.drawImage(Runner.imageSprite, moonSourceX,
                this.spritePos.y, moonSourceWidth, moonSourceHeight,
                Math.round(this.xPos), this.yPos,
                moonOutputWidth, NightMode.config.HEIGHT);

            this.canvasCtx.globalAlpha = 1;
            this.canvasCtx.restore();
        },

        // Do star placement.
        placeStars: function() {
            let segmentSize = Math.round(this.containerWidth /
                NightMode.config.NUM_STARS);

            for (let i = 0; i < NightMode.config.NUM_STARS; i++) {
                this.stars[i] = {};
                this.stars[i].x = getRandomNum(segmentSize * i, segmentSize * (i + 1));
                this.stars[i].y = getRandomNum(0, NightMode.config.STAR_MAX_Y);

                if (IS_HIDPI) {
                    this.stars[i].sourceY = Runner.spriteDefinition.HDPI.STAR.y +
                        NightMode.config.STAR_SIZE * 2 * i;
                } else {
                    this.stars[i].sourceY = Runner.spriteDefinition.LDPI.STAR.y +
                        NightMode.config.STAR_SIZE * i;
                }
            }
        },

        reset: function() {
            this.currentPhase = 0;
            this.opacity = 0;
            this.update(false);
        }

    };


//******************************************************************************

    /**
     * Horizon Line.
     * Consists of two connecting lines. Randomly assigns a flat / bumpy horizon.
     * @param {HTMLCanvasElement} canvas
     * @param {Object} spritePos Horizon position in sprite.
     * @constructor
     */
    function HorizonLine(canvas, spritePos) {
        this.spritePos = spritePos;
        this.canvas = canvas;
        this.canvasCtx = canvas.getContext('2d');
        this.sourceDimensions = {};
        this.dimensions = HorizonLine.dimensions;
        this.sourceXPos = [this.spritePos.x, this.spritePos.x +
        this.dimensions.WIDTH];
        this.xPos = [];
        this.yPos = 0;
        this.bumpThreshold = 0.5;

        this.setSourceDimensions();
        this.draw();
    };


    /**
     * Horizon line dimensions.
     * @enum {number}
     */
    HorizonLine.dimensions = {
        WIDTH: 600,
        HEIGHT: 12,
        YPOS: 127
    };


    HorizonLine.prototype = {
        /**
         * Set the source dimensions of the horizon line.
         */
        setSourceDimensions: function() {

            for (let dimension in HorizonLine.dimensions) {
                if (IS_HIDPI) {
                    if (dimension != 'YPOS') {
                        this.sourceDimensions[dimension] =
                            HorizonLine.dimensions[dimension] * 2;
                    }
                } else {
                    this.sourceDimensions[dimension] =
                        HorizonLine.dimensions[dimension];
                }
                this.dimensions[dimension] = HorizonLine.dimensions[dimension];
            }

            this.xPos = [0, HorizonLine.dimensions.WIDTH];
            this.yPos = HorizonLine.dimensions.YPOS;
        },

        /**
         * Return the crop x position of a type.
         */
        getRandomType: function() {
            return Math.random() > this.bumpThreshold ? this.dimensions.WIDTH : 0;
        },

        /**
         * Draw the horizon line.
         */
        draw: function() {
            this.canvasCtx.drawImage(Runner.imageSprite, this.sourceXPos[0],
                this.spritePos.y,
                this.sourceDimensions.WIDTH, this.sourceDimensions.HEIGHT,
                this.xPos[0], this.yPos,
                this.dimensions.WIDTH, this.dimensions.HEIGHT);

            this.canvasCtx.drawImage(Runner.imageSprite, this.sourceXPos[1],
                this.spritePos.y,
                this.sourceDimensions.WIDTH, this.sourceDimensions.HEIGHT,
                this.xPos[1], this.yPos,
                this.dimensions.WIDTH, this.dimensions.HEIGHT);
        },

        /**
         * Update the x position of an indivdual piece of the line.
         * @param {number} pos Line position.
         * @param {number} increment
         */
        updateXPos: function(pos, increment) {
            let line1 = pos;
            let line2 = pos == 0 ? 1 : 0;

            this.xPos[line1] -= increment;
            this.xPos[line2] = this.xPos[line1] + this.dimensions.WIDTH;

            if (this.xPos[line1] <= -this.dimensions.WIDTH) {
                this.xPos[line1] += this.dimensions.WIDTH * 2;
                this.xPos[line2] = this.xPos[line1] - this.dimensions.WIDTH;
                this.sourceXPos[line1] = this.getRandomType() + this.spritePos.x;
            }
        },

        /**
         * Update the horizon line.
         * @param {number} deltaTime
         * @param {number} speed
         */
        update: function(deltaTime, speed) {
            let increment = Math.floor(speed * (FPS / 1000) * deltaTime);

            if (this.xPos[0] <= 0) {
                this.updateXPos(0, increment);
            } else {
                this.updateXPos(1, increment);
            }
            this.draw();
        },

        /**
         * Reset horizon to the starting position.
         */
        reset: function() {
            this.xPos[0] = 0;
            this.xPos[1] = HorizonLine.dimensions.WIDTH;
        }
    };


//******************************************************************************

    /**
     * Horizon background class.
     * @param {HTMLCanvasElement} canvas
     * @param {Object} spritePos Sprite positioning.
     * @param {Object} dimensions Canvas dimensions.
     * @param {number} gapCoefficient
     * @constructor
     */
    function Horizon(canvas, spritePos, dimensions, gapCoefficient) {
        this.canvas = canvas;
        this.canvasCtx = this.canvas.getContext('2d');
        this.config = Horizon.config;
        this.dimensions = dimensions;
        this.gapCoefficient = gapCoefficient;
        this.obstacles = [];
        this.obstacleHistory = [];
        this.horizonOffsets = [0, 0];
        this.cloudFrequency = this.config.CLOUD_FREQUENCY;
        this.spritePos = spritePos;
        this.nightMode = null;

        // Cloud
        this.clouds = [];
        this.cloudSpeed = this.config.BG_CLOUD_SPEED;

        // Horizon
        this.horizonLine = null;
        this.init();
    };


    /**
     * Horizon config.
     * @enum {number}
     */
    Horizon.config = {
        BG_CLOUD_SPEED: 0.2,
        BUMPY_THRESHOLD: .3,
        CLOUD_FREQUENCY: .5,
        HORIZON_HEIGHT: 16,
        MAX_CLOUDS: 6
    };


    Horizon.prototype = {
        /**
         * Initialise the horizon. Just add the line and a cloud. No obstacles.
         */
        init: function() {
            this.addCloud();
            this.horizonLine = new HorizonLine(this.canvas, this.spritePos.HORIZON);
            this.nightMode = new NightMode(this.canvas, this.spritePos.MOON,
                this.dimensions.WIDTH);
        },

        /**
         * @param {number} deltaTime
         * @param {number} currentSpeed
         * @param {boolean} updateObstacles Used as an override to prevent
         *     the obstacles from being updated / added. This happens in the
         *     ease in section.
         * @param {boolean} showNightMode Night mode activated.
         */
        update: function(deltaTime, currentSpeed, updateObstacles, showNightMode) {
            this.runningTime += deltaTime;
            this.horizonLine.update(deltaTime, currentSpeed);
            this.nightMode.update(showNightMode);
            this.updateClouds(deltaTime, currentSpeed);

            if (updateObstacles) {
                this.updateObstacles(deltaTime, currentSpeed);
            }
        },

        /**
         * Update the cloud positions.
         * @param {number} deltaTime
         * @param {number} currentSpeed
         */
        updateClouds: function(deltaTime, speed) {
            let cloudSpeed = this.cloudSpeed / 1000 * deltaTime * speed;
            let numClouds = this.clouds.length;

            if (numClouds) {
                for (let i = numClouds - 1; i >= 0; i--) {
                    this.clouds[i].update(cloudSpeed);
                }

                let lastCloud = this.clouds[numClouds - 1];

                // Check for adding a new cloud.
                if (numClouds < this.config.MAX_CLOUDS &&
                    (this.dimensions.WIDTH - lastCloud.xPos) > lastCloud.cloudGap &&
                    this.cloudFrequency > Math.random()) {
                    this.addCloud();
                }

                // Remove expired clouds.
                this.clouds = this.clouds.filter(function(obj) {
                    return !obj.remove;
                });
            } else {
                this.addCloud();
            }
        },

        /**
         * Update the obstacle positions.
         * @param {number} deltaTime
         * @param {number} currentSpeed
         */
        updateObstacles: function(deltaTime, currentSpeed) {
            // Obstacles, move to Horizon layer.
            let updatedObstacles = this.obstacles.slice(0);

            for (let i = 0; i < this.obstacles.length; i++) {
                let obstacle = this.obstacles[i];
                obstacle.update(deltaTime, currentSpeed);

                // Clean up existing obstacles.
                if (obstacle.remove) {
                    updatedObstacles.shift();
                }
            }
            this.obstacles = updatedObstacles;

            if (this.obstacles.length > 0) {
                let lastObstacle = this.obstacles[this.obstacles.length - 1];

                if (lastObstacle && !lastObstacle.followingObstacleCreated &&
                    lastObstacle.isVisible() &&
                    (lastObstacle.xPos + lastObstacle.width + lastObstacle.gap) <
                    this.dimensions.WIDTH) {
                    this.addNewObstacle(currentSpeed);
                    lastObstacle.followingObstacleCreated = true;
                }
            } else {
                // Create new obstacles.
                this.addNewObstacle(currentSpeed);
            }
        },

        removeFirstObstacle: function() {
            this.obstacles.shift();
        },

        /**
         * Add a new obstacle.
         * @param {number} currentSpeed
         */
        addNewObstacle: function(currentSpeed) {
            let obstacleTypeIndex = getRandomNum(0, Obstacle.types.length - 1);
            let obstacleType = Obstacle.types[obstacleTypeIndex];

            // Check for multiples of the same type of obstacle.
            // Also check obstacle is available at current speed.
            if (this.duplicateObstacleCheck(obstacleType.type) ||
                currentSpeed < obstacleType.minSpeed) {
                this.addNewObstacle(currentSpeed);
            } else {
                let obstacleSpritePos = this.spritePos[obstacleType.type];

                this.obstacles.push(new Obstacle(this.canvasCtx, obstacleType,
                    obstacleSpritePos, this.dimensions,
                    this.gapCoefficient, currentSpeed, obstacleType.width));

                this.obstacleHistory.unshift(obstacleType.type);

                if (this.obstacleHistory.length > 1) {
                    this.obstacleHistory.splice(Runner.config.MAX_OBSTACLE_DUPLICATION);
                }
            }
        },

        /**
         * Returns whether the previous two obstacles are the same as the next one.
         * Maximum duplication is set in config value MAX_OBSTACLE_DUPLICATION.
         * @return {boolean}
         */
        duplicateObstacleCheck: function(nextObstacleType) {
            let duplicateCount = 0;

            for (let i = 0; i < this.obstacleHistory.length; i++) {
                duplicateCount = this.obstacleHistory[i] == nextObstacleType ?
                    duplicateCount + 1 : 0;
            }
            return duplicateCount >= Runner.config.MAX_OBSTACLE_DUPLICATION;
        },

        /**
         * Reset the horizon layer.
         * Remove existing obstacles and reposition the horizon line.
         */
        reset: function() {
            this.obstacles = [];
            this.horizonLine.reset();
            this.nightMode.reset();
        },

        /**
         * Update the canvas width and scaling.
         * @param {number} width Canvas width.
         * @param {number} height Canvas height.
         */
        resize: function(width, height) {
            this.canvas.width = width;
            this.canvas.height = height;
        },

        /**
         * Add a new cloud to the horizon.
         */
        addCloud: function() {
            this.clouds.push(new Cloud(this.canvas, this.spritePos.CLOUD,
                this.dimensions.WIDTH));
        }
    };
})();
