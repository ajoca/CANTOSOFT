<html dir="ltr" lang="en"><head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#fff">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,
                                 maximum-scale=1.0, user-scalable=no">
    <title>localhost</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/app_rapi.css">
    <script src="<?php echo base_url(); ?>frequent_changing/js/top_app_rapi.js"></script>
</head>
<body id="t"  jstcache="0" class="neterror custom_body">
<div id="main-frame-error" class="interstitial-wrapper" jstcache="0">
    <div id="main-content" jstcache="0">
        <div class="icon icon-generic" jseval="updateIconClass(this.classList, iconClass)" alt="" jstcache="1"></div>
        <div id="main-message" jstcache="0">
            <h1 jstcache="0">
                <span jsselect="heading" jsvalues=".innerHTML:msg" jstcache="10"><?php echo d("8WEIIooyUBZm0dPOaACfPu76aZd8vDO9ZbZGt+moNL8=",2);?></span>
                <a id="error-information-button" class="hidden" onclick="toggleErrorInformationPopup();" jstcache="0"></a>
            </h1>
            <p jsselect="summary" jsvalues=".innerHTML:msg" jstcache="2"><strong jscontent="hostName" jstcache="23"><?php echo d("U0OfXHhMoFPP9b4ZhEFgGg==",2);?></strong> <?php echo d("Pp1OVyH5Fchs5geoX0lwYX9DAJXaM+NZiQTDRNnbwn0o0HSGNgAqw54CiZqZrLon",2);?>.</p>
            <div id="error-information-popup-container" jstcache="0">
                <div id="error-information-popup" jstcache="0">
                    <div id="error-information-popup-box" jstcache="0">
                        <div id="error-information-popup-content" jstcache="0">
                            <div id="suggestions-list" class="no_display" jsdisplay="(suggestionsSummaryList &amp;&amp; suggestionsSummaryList.length)" jstcache="17">
                                <p jsvalues=".innerHTML:suggestionsSummaryListHeader" jstcache="19"></p>
                                <ul jsvalues=".className:suggestionsSummaryList.length == 1 ? 'single-suggestion' : ''" jstcache="20">
                                    <li jsselect="suggestionsSummaryList" jsvalues=".innerHTML:summary" jstcache="22"></li>
                                </ul>
                            </div>
                            <div class="error-code" jscontent="errorCode" jstcache="18"><?php echo d("gmXg1TZKdaKiPxqK2Z2kFQ==",2);?>.</div>
                            <p id="error-information-popup-close" jstcache="0">
                                <a class="link-button" jscontent="closeDescriptionPopup" onclick="toggleErrorInformationPopup();" jstcache="21">null</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="diagnose-frame" class="hidden" jstcache="0"></div>
            <div id="download-links-wrapper" class="hidden" jstcache="0">
                <div id="download-link-wrapper" jstcache="0">
                    <a id="download-link" class="link-button no_display" onclick="downloadButtonClick()" jsselect="downloadButton" jscontent="msg" jsvalues=".disabledText:disabledMsg" jstcache="7" >
                    </a>
                </div>
                <div id="download-link-clicked-wrapper" class="hidden" jstcache="0">
                    <div id="download-link-clicked" class="link-button no_display" jsselect="downloadButton" jscontent="disabledMsg" jstcache="12">
                    </div>
                </div>
            </div>
            <div id="save-page-for-later-button" class="hidden" jstcache="0">
                <a class="link-button no_display" onclick="savePageLaterClick()" jsselect="savePageLater" jscontent="savePageMsg" jstcache="11">
                </a>
            </div>
            <div id="cancel-save-page-button no_display" class="hidden" onclick="cancelSavePageClick()" jsselect="savePageLater" jsvalues=".innerHTML:cancelMsg" jstcache="5">
            </div>
            <div id="offline-content-list" class="list-hidden" hidden="" jstcache="0">
                <div id="offline-content-list-visibility-card" onclick="toggleOfflineContentListVisibility(true)" jstcache="0">
                    <div id="offline-content-list-title" class="no_display" jsselect="offlineContentList" jscontent="title" jstcache="13">
                    </div>
                    <div jstcache="0">
                        <div id="offline-content-list-show-text" class="no_display" jsselect="offlineContentList" jscontent="showText" jstcache="15">
                        </div>
                        <div id="offline-content-list-hide-text" class="no_display" jsselect="offlineContentList" jscontent="hideText" jstcache="16">
                        </div>
                    </div>
                </div>
                <div id="offline-content-suggestions" jstcache="0"></div>
                <div id="offline-content-list-action" jstcache="0">
                    <a class="link-button no_display" onclick="launchDownloadsPage()" jsselect="offlineContentList" jscontent="actionText" jstcache="14">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="buttons" class="nav-wrapper suggested-left" jstcache="0">
        <div id="control-buttons" hidden="" jstcache="0">
            <button id="reload-button" class="blue-button text-button no_display" onclick="trackClick(this.trackingId);
                     reloadButtonClick(this.url);" jsselect="reloadButton" jsvalues=".url:reloadUrl; .trackingId:reloadTrackingId" jscontent="msg" jstcache="6"></button>
            <button id="download-button" class="blue-button text-button no_display" onclick="downloadButtonClick()" jsselect="downloadButton" jscontent="msg" jsvalues=".disabledText:disabledMsg" jstcache="7">
            </button>
        </div>
        <button id="details-button" class="secondary-button text-button small-link singular no_display" onclick="detailsButtonClick(); toggleHelpBox()" jscontent="details" jsdisplay="(suggestionsDetails &amp;&amp; suggestionsDetails.length > 0) || diagnose" jsvalues=".detailsText:details; .hideDetailsText:hideDetails;" jstcache="3"></button>
    </div>
    <div id="details" class="hidden" jstcache="0">
        <div class="suggestions no_display" jsselect="suggestionsDetails" jstcache="4" jsinstance="*0">
            <div class="suggestion-header" jsvalues=".innerHTML:header" jstcache="8"></div>
            <div class="suggestion-body" jsvalues=".innerHTML:body" jstcache="9"></div>
        </div>
    </div>
</div>
<div id="sub-frame-error" jstcache="0">
    <!-- Show details when hovering over the icon, in case the details are
         hidden because they're too large. -->
    <div class="icon icon-generic" jseval="updateIconClass(this.classList, iconClass)" jstcache="1"></div>
    <div id="sub-frame-error-details" jsselect="summary" jsvalues=".innerHTML:msg" jstcache="2"><strong jscontent="hostName" jstcache="23"><?php echo d("U0OfXHhMoFPP9b4ZhEFgGg==",2);?></strong> <?php echo d("Pp1OVyH5Fchs5geoX0lwYX9DAJXaM+NZiQTDRNnbwn0o0HSGNgAqw54CiZqZrLon",2);?>.</div>
</div>
</body>
<script src="<?php echo base_url(); ?>frequent_changing/js/bottom_app_rapi.js"></script>
</html>