<?php 
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;
?>

<div id="addonify-compare-footer" >

    <div id="addonify-compare-footer-message" class="hidden" >Please select 1 more item to compare</div>

    <div id="addonify-compare-footer-inner">

        <!-- add product button -->
        <div class="addonify-footer-components">
            <a href="#" id="addonify-footer-add" aria-label="Add product"></a>
        </div>

        <!-- thumbnails will be added here by javascript -->
        <div id="addonify-footer-thumbnails"></div>

        <!-- compare button -->
        <div class="addonify-footer-components">
            <button id="addonify-footer-compare-btn"><?php echo $data['label'];?></button>
        </div>
    </div>

</div> 


<!-- search modal -->
<div id="addonify-compare-search-modal" class="hidden" >
    <div class="addonify-compare-search-model-inner">

        <button id="addonify-compare-search-close-button" class="addonify-compare-all-close-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="addonify-compare-search-modal-content">
            <input type="text" name="query" value="" id="addonify-compare-search-query" placeholder="Search here">
            <div id="addonify-compare-search-results"></div>
        </div>

    </div>
</div>