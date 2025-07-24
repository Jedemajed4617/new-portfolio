/*
    -------------------------------------------------------------------
    Velisoft Image Library
    Author: Velisoft.nl (Tygo Jedema)
    Version: 0.0.3
    Older version: 0.0.2
    Version desc: Added infinite scroll, enhanced carousel functionality, improved zoom/pan behavior and reworked some css.
    --------------------------------------------------------------------
    Dependencies:
    - jQuery
    --------------------------------------------------------------------
    Overview:
    Velisoft Image Library provides a modern fullscreen image viewer with carousel, zoom, pan, swipe, and autoplay features. 
    It supports both galleries and single images, with optional UI controls you can turn on or off.
    --------------------------------------------------------------------
    Features:
    - Fullscreen image viewing
    - Carousel navigation for galleries
    - Swipe gestures (touch and mouse)
    - Zoom in/out and pan when zoomed
    - Autoplay slideshow
    - Optional UI controls (counter, zoom, fullscreen, autoplay)
    - Keyboard and mouse navigation
    --------------------------------------------------------------------
    Usage:
    Add the attribute data-velisoft-img-lib to a container above the images next to a src or title atribute (works on body aswell to apply to full website). 
    Then add the class gallery_image to the images you want to include in the library and voila you are set.
    --------------------------------------------------------------------
    Important note:
    Ensure that the images have the exact gallery_image class for the library to recognize them as images for the library.
    --------------------------------------------------------------------
    Example (Gallery Images): 
    <div data-velisoft-img-lib="gallery">
        <img src="/img1.jpg" alt="Image 1" class="gallery_image">
        <img src="/img2.jpg" alt="Image 2" class="gallery_image">
        <img src="/img3.jpg" alt="Image 3" class="gallery_image">
    </div>

    Example (Single Image): 
    <div data-velisoft-img-lib="single">
        <img src="/img3.jpg" alt="Single Image" class="gallery_image">
    </div>

    Example (Gallery Images with controls): 
    <div data-velisoft-img-lib="gallery" data-velisoft-img-libcontrols="true">
        <img src="/img3.jpg" alt="Single Image" class="gallery_image">
    </div>

    Example (Single Image without controls): 
    <div data-velisoft-img-lib="single" data-velisoft-img-libcontrols="false">
        <img src="/img3.jpg" alt="Single Image" class="gallery_image">
    </div>
    --------------------------------------------------------------------
    Sidenotes:
    Single will have not thumbnails, autoplay, and fullscreen controls enabled. 
    False will turn off the zoom, pan, autoplay, and fullscreen controls in the fullscreen container.
    --------------------------------------------------------------------
    Linking (example):
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/PATHTOYOURJSFILES/velisoft-img-lib.js"></script>
    <link rel="stylesheet" href="/PATHTOYOURCSSFILES/velisoft-img-lib.css" type="text/css">
    --------------------------------------------------------------------
*/

let currentImageIndex = 0;
let currentImages = [];
let isDraggingX = false;
let startPosX = 0;
let currentTranslateX = 0;
let prevTranslateX = 0;
let hasDraggedX = false;
let isDraggingY = false;
let startPosY = 0;
let currentTranslateY = 0;
let hasDraggedY = false;
let closeAnimationDuration = 300;
const swipeDownThreshold = 100;
let carouselTransitionDuration = 300;
let notificationTimeout;
let isFullscreenOperationInProgress = false;
let autoplayInterval = null;
let isAutoplayActive = false;
const autoplayDuration = 3000;
let progressBarTimeout;
let isZoomed = false;
let currentZoomLevel = 1;
const maxZoomLevel = 2.5;
let zoomPanX = 0;
let zoomPanY = 0;
let zoomStartPointerX = 0;
let zoomStartPointerY = 0;
let isPanning = false;
let $currentZoomableImage = null;
let initialScrollY = 0;
let fullscreenContentScrollTop = 0; 
let carouselOffsetIndex = 1; 
let carouselItemWidth = 0;

// Function to initialize the image library
function getTranslateX($elem) {
    const style = window.getComputedStyle($elem[0]);
    const matrix = new WebKitCSSMatrix(style.transform);
    return matrix.m41;
}

// Function to get the transform values of an element
function getTransformValues($elem) {
    const style = window.getComputedStyle($elem[0]);
    const matrix = new WebKitCSSMatrix(style.transform);
    return {
        scaleX: matrix.a,
        scaleY: matrix.d,
        translateX: matrix.e,
        translateY: matrix.f
    };
}

// Functionality for thumbnails
function renderThumbnails() {
    const $thumbnailContainer = $('#thumbnail_container');
    $thumbnailContainer.empty();

    if (currentImages.length > 1) {
        currentImages.forEach((img, index) => {
            const $thumbnail = $('<img>')
                .attr('src', $(img).attr('src'))
                .attr('alt', $(img).attr('alt') || `Thumbnail ${index + 1}`)
                .addClass('thumbnail_image');

            if (index === currentImageIndex) {
                $thumbnail.addClass('active');
            }

            $thumbnail.on('click', function (e) {
                e.stopPropagation();
                if (isZoomed) {
                    resetZoom();
                }
                if (isAutoplayActive) {
                    stopAutoplay();
                }
                let targetIndex = index;
                let distance = targetIndex - currentImageIndex;
                if (currentImages.length > 1) {
                    if (Math.abs(distance) > currentImages.length / 2) {
                        if (distance > 0) {
                            distance -= currentImages.length;
                        } else {
                            distance += currentImages.length;
                        }
                    }
                }
                currentImageIndex = targetIndex;
                animateSlide(distance);
            });
            $thumbnailContainer.append($thumbnail);
        });
        $thumbnailContainer.show();
    } else {
        $thumbnailContainer.hide();
    }
}

// Function to update the current image counter
function updateImageCounter() {
    const displayIndex = (currentImageIndex % currentImages.length) + 1;
    $('#currentImageCount').text(displayIndex);
}

// Function to set up the carousel images
function setupCarouselImages() {
    const $carouselSlider = $('#carousel_slider');
    $carouselSlider.empty();

    if (currentImages.length === 0) return;

    resetZoom();

    const numClones = Math.max(3, currentImages.length);

    const workingImages = [];

    for (let i = numClones; i > 0; i--) {
        workingImages.push(currentImages[currentImages.length - i]);
    }

    workingImages.push(...currentImages);

    for (let i = 0; i < numClones; i++) {
        workingImages.push(currentImages[i]);
    }

    workingImages.forEach((img, index) => {
        const $clone = $(img).clone()
            .removeClass('gallery_image')
            .addClass('carousel_image')
            .attr('draggable', 'false')
            .attr('data-original-index', currentImages.indexOf(img));

        $carouselSlider.append($clone);
    });

    $carouselSlider.css('transition', 'none');

    setTimeout(() => {
        const $allCarouselImages = $carouselSlider.find('.carousel_image');
        const $currentActiveImageInSlider = $($allCarouselImages[numClones + currentImageIndex]);

        $carouselSlider.find('.carousel_image').removeClass('current_active');
        if ($currentActiveImageInSlider.length) {
            $currentActiveImageInSlider.addClass('current_active');
            $currentZoomableImage = $currentActiveImageInSlider;
        } else {
            return;
        }

        const wrapperWidth = $('#carousel_wrapper').outerWidth();
        const currentImageWidth = $currentActiveImageInSlider.outerWidth(true);

        let totalWidthBeforeCurrent = 0;
        $currentActiveImageInSlider.prevAll('.carousel_image').each(function() {
            totalWidthBeforeCurrent += $(this).outerWidth(true);
        });

        const targetTranslateX = -(totalWidthBeforeCurrent + (currentImageWidth / 2) - (wrapperWidth / 2));

        $carouselSlider.css('transform', `translateX(${targetTranslateX}px)`);
        prevTranslateX = targetTranslateX;

        $carouselSlider.css('transition', `transform ${carouselTransitionDuration / 1000}s ease`);

        $('#fullscreen_title').text($(currentImages[currentImageIndex]).attr('alt') || '');
        renderThumbnails();
        updateImageCounter();
    }, 0);
}

// Function to animate the slide transition in the carousel
function animateSlide(direction) {
    if (currentImages.length === 0) return;
    if (isZoomed) return;

    if (isAutoplayActive && Math.abs(direction) > 0) {
        startProgressBar();
    }

    resetZoom();

    const $carouselSlider = $('#carousel_slider');
    const $currentActiveImage = $carouselSlider.find('.carousel_image.current_active');

    if ($currentActiveImage.length === 0) {
        setupCarouselImages();
        return;
    }

    const currentImageWidth = $currentActiveImage.outerWidth(true);
    const targetTranslate = prevTranslateX - (direction * currentImageWidth);

    $carouselSlider.css('transition', `transform ${carouselTransitionDuration / 1000}s ease`);
    $carouselSlider.css('transform', `translateX(${targetTranslate}px)`);
    prevTranslateX = targetTranslate;

    $carouselSlider.one('transitionend', () => {
        const numClones = Math.max(3, currentImages.length);
        const $allCarouselImages = $carouselSlider.find('.carousel_image');
        const currentSliderIndex = $allCarouselImages.index($carouselSlider.find('.carousel_image.current_active'));
        
        if (currentSliderIndex <= numClones - 1) {
            const newSliderIndex = currentSliderIndex + currentImages.length;
            const $newActiveImage = $($allCarouselImages[newSliderIndex]);
            
            $carouselSlider.find('.carousel_image').removeClass('current_active');
            $newActiveImage.addClass('current_active');
            $currentZoomableImage = $newActiveImage;
            
            const wrapperWidth = $('#carousel_wrapper').outerWidth();
            const newImageWidth = $newActiveImage.outerWidth(true);
            let totalWidthBeforeNew = 0;
            $newActiveImage.prevAll('.carousel_image').each(function() {
                totalWidthBeforeNew += $(this).outerWidth(true);
            });
            
            const newTargetTranslateX = -(totalWidthBeforeNew + (newImageWidth / 2) - (wrapperWidth / 2));
            
            $carouselSlider.css('transition', 'none');
            $carouselSlider.css('transform', `translateX(${newTargetTranslateX}px)`);
            prevTranslateX = newTargetTranslateX;

            setTimeout(() => {
                $carouselSlider.css('transition', `transform ${carouselTransitionDuration / 1000}s ease`);
            }, 50);
            
        } else if (currentSliderIndex >= $allCarouselImages.length - numClones) {
            const newSliderIndex = currentSliderIndex - currentImages.length;
            const $newActiveImage = $($allCarouselImages[newSliderIndex]);
            
            $carouselSlider.find('.carousel_image').removeClass('current_active');
            $newActiveImage.addClass('current_active');
            $currentZoomableImage = $newActiveImage;

            const wrapperWidth = $('#carousel_wrapper').outerWidth();
            const newImageWidth = $newActiveImage.outerWidth(true);
            let totalWidthBeforeNew = 0;
            $newActiveImage.prevAll('.carousel_image').each(function() {
                totalWidthBeforeNew += $(this).outerWidth(true);
            });
            
            const newTargetTranslateX = -(totalWidthBeforeNew + (newImageWidth / 2) - (wrapperWidth / 2));
            
            $carouselSlider.css('transition', 'none');
            $carouselSlider.css('transform', `translateX(${newTargetTranslateX}px)`);
            prevTranslateX = newTargetTranslateX;

            setTimeout(() => {
                $carouselSlider.css('transition', `transform ${carouselTransitionDuration / 1000}s ease`);
            }, 50);
        }

        renderThumbnails();
        updateImageCounter();
    });
}

// Function to slide to the next image in the carousel
function slideNext() {
    if (isZoomed) return;
    currentImageIndex = (currentImageIndex + 1) % currentImages.length;

    const $carouselSlider = $('#carousel_slider');
    const $currentActiveImage = $carouselSlider.find('.carousel_image.current_active');
    const $allCarouselImages = $carouselSlider.find('.carousel_image');
    const currentSliderIndex = $allCarouselImages.index($currentActiveImage);
    const $nextImage = $($allCarouselImages[currentSliderIndex + 1]);
    
    if ($nextImage.length) {
        $carouselSlider.find('.carousel_image').removeClass('current_active');
        $nextImage.addClass('current_active');
        $currentZoomableImage = $nextImage;
    }
    
    animateSlide(1);
}

// Function to slide to the previous image in the carousel
function slidePrev() {
    if (isZoomed) return;
    currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;

    const $carouselSlider = $('#carousel_slider');
    const $currentActiveImage = $carouselSlider.find('.carousel_image.current_active');
    const $allCarouselImages = $carouselSlider.find('.carousel_image');
    const currentSliderIndex = $allCarouselImages.index($currentActiveImage);
    const $prevImage = $($allCarouselImages[currentSliderIndex - 1]);
    
    if ($prevImage.length) {
        $carouselSlider.find('.carousel_image').removeClass('current_active');
        $prevImage.addClass('current_active');
        $currentZoomableImage = $prevImage;
    }
    
    animateSlide(-1);
}

// Function to show a notification message
function showNotification() {
    clearTimeout(notificationTimeout);
    $('#fullscreen_notification').addClass('show');
    notificationTimeout = setTimeout(() => {
        $('#fullscreen_notification').removeClass('show');
    }, 3000); 
}

// Function to start the progress bar for autoplay
function startProgressBar() {
    const $progressBar = $('#autoplay_progress_bar');
    const $progressBarContainer = $('#autoplay_progress_bar_container');

    clearTimeout(progressBarTimeout);

    $progressBar.css({ 'transition': 'none', 'width': '0%' });
    $progressBarContainer.css('display', 'block').addClass('active');

    $progressBar[0].offsetWidth;

    $progressBar.css({ 'transition': `width ${autoplayDuration / 1000}s linear`, 'width': '100%' });

    progressBarTimeout = setTimeout(() => {
        $progressBarContainer.removeClass('active');
    }, autoplayDuration - 50);
}

// Function to reset the progress bar
function resetProgressBar() {
    const $progressBar = $('#autoplay_progress_bar');
    const $progressBarContainer = $('#autoplay_progress_bar_container');
    clearTimeout(progressBarTimeout);
    $progressBar.css({ 'transition': 'none', 'width': '0%' });
    $progressBarContainer.removeClass('active').css('display', 'none');
}

// Function to start autoplay functionality
function startAutoplay() {
    if (currentImages.length <= 1 || isZoomed) {
        return;
    }

    isAutoplayActive = true;
    $('#play_button').addClass('active');
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
    }
    autoplayInterval = setInterval(() => {
        slideNext();
        startProgressBar();
    }, autoplayDuration);

    startProgressBar();
}

// Function to stop autoplay functionality
function stopAutoplay() {
    isAutoplayActive = false;
    $('#play_button').removeClass('active');
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
        autoplayInterval = null;
    }
    resetProgressBar();
}

// Function to toggle fullscreen mode
function applyZoomTransform() {
    if (!$currentZoomableImage || !$currentZoomableImage.length) return;

    $currentZoomableImage.toggleClass('zoomed', isZoomed);

    const $wrapper = $currentZoomableImage.closest('#carousel_wrapper, #single_image_area');
    if (!$wrapper.length) return;

    const wrapperWidth = $wrapper.innerWidth();
    const wrapperHeight = $wrapper.innerHeight();

    const currentRenderedImageWidth = $currentZoomableImage.width();
    const currentRenderedImageHeight = $currentZoomableImage.height();

    const scaledImageWidth = currentRenderedImageWidth * currentZoomLevel;
    const scaledImageHeight = currentRenderedImageHeight * currentZoomLevel;

    const maxPanX = Math.max(0, (scaledImageWidth - wrapperWidth) / 2 / currentZoomLevel);
    const maxPanY = Math.max(0, (scaledImageHeight - wrapperHeight) / 2 / currentZoomLevel);

    zoomPanX = Math.max(-maxPanX, Math.min(maxPanX, zoomPanX));
    zoomPanY = Math.max(-maxPanY, Math.min(maxPanY, zoomPanY));

    targetPanX = Math.max(-maxPanX, Math.min(maxPanX, targetPanX));
    targetPanY = Math.max(-maxPanY, Math.min(maxPanY, targetPanY));

    $currentZoomableImage.css({
        'transition': isPanning ? 'none' : 'transform 0.1s ease-out',
        'transform': `scale(${currentZoomLevel}) translate(${zoomPanX}px, ${zoomPanY}px)`
    });

    if (isZoomed) {
        $('#zoom_button').addClass('active');
        $('.nav_button').prop('disabled', true);
        $('#thumbnail_container').addClass('disabled');
        $('#play_button').prop('disabled', true);
        stopAutoplay();
    } else {
        $('#zoom_button').removeClass('active');
        $('.nav_button').prop('disabled', false);
        $('#thumbnail_container').removeClass('disabled');
        $('#play_button').prop('disabled', false);
    }
}

// Function to toggle zoom in and out
function toggleZoom() {
    if (!$currentZoomableImage || !$currentZoomableImage.length) {
        console.warn("No current image found for zooming.");
        return;
    }

    if (isZoomed) {
        currentZoomLevel = 1;
        zoomPanX = 0;
        zoomPanY = 0;
        targetPanX = 0;
        targetPanY = 0;
        currentPanX = 0;
        currentPanY = 0;
        isZoomed = false;
        applyZoomTransform();
    } else {
        currentZoomLevel = maxZoomLevel;
        targetPanX = zoomPanX;
        targetPanY = zoomPanY;
        currentPanX = zoomPanX;
        currentPanY = zoomPanY;
        isZoomed = true;
        applyZoomTransform();
    }
}

// Function to reset zoom to default state
function resetZoom() {
    if (isZoomed) {
        currentZoomLevel = 1;
        zoomPanX = 0;
        zoomPanY = 0;
        targetPanX = 0;
        targetPanY = 0;
        currentPanX = 0;
        currentPanY = 0;
        isZoomed = false;
        
        if (panningAnimationId) {
            cancelAnimationFrame(panningAnimationId);
            panningAnimationId = null;
        }
        
        if ($currentZoomableImage && $currentZoomableImage.length) {
             $currentZoomableImage.css({
                'transition': 'transform 0.2s ease-out',
                'transform': `scale(1) translate(0px, 0px)`
            });
            $currentZoomableImage.removeClass('zoomed');
        }
        $('#zoom_button').removeClass('active');
        $('.nav_button').prop('disabled', false);
        $('#thumbnail_container').removeClass('disabled');
        $('#play_button').prop('disabled', false);
    }
}

// Enhanced zoom panning variables
let isDragging = false;
let lastX = 0, lastY = 0;
let velocityX = 0, velocityY = 0;
let panningAnimationId = null;
let smoothPanTimeout = null;
let targetPanX = 0, targetPanY = 0;
let currentPanX = 0, currentPanY = 0;
const panSmoothness = 0.15;
const velocityDecay = 0.92;
const minVelocity = 0.05;

function smoothPanAnimation() {
    if (!isZoomed || isPanning) return;
    
    const diffX = targetPanX - currentPanX;
    const diffY = targetPanY - currentPanY;
    
    if (Math.abs(diffX) > 0.1 || Math.abs(diffY) > 0.1) {
        currentPanX += diffX * panSmoothness;
        currentPanY += diffY * panSmoothness;
        
        zoomPanX = currentPanX;
        zoomPanY = currentPanY;
        applyZoomTransform();
        
        panningAnimationId = requestAnimationFrame(smoothPanAnimation);
    } else {
        currentPanX = targetPanX;
        currentPanY = targetPanY;
        zoomPanX = currentPanX;
        zoomPanY = currentPanY;
        applyZoomTransform();
        panningAnimationId = null;
    }
}

// Function to apply inertia after dragging
function applyInertia() {
    if (!isDragging && (Math.abs(velocityX) > minVelocity || Math.abs(velocityY) > minVelocity)) {
        targetPanX += velocityX;
        targetPanY += velocityY;
        velocityX *= velocityDecay;
        velocityY *= velocityDecay;
        
        if (!panningAnimationId) {
            smoothPanAnimation();
        }
        
        requestAnimationFrame(applyInertia);
    }
}

// Enhanced event listener for dragging and panning
$('#carousel_wrapper, #single_image_area')
.on('mousedown touchstart', function(e) {
    if (!isZoomed) return;
    
    e.preventDefault();
    isDragging = true;
    isPanning = true;
    
    if (panningAnimationId) {
        cancelAnimationFrame(panningAnimationId);
        panningAnimationId = null;
    }
    
    const evt = e.type === 'touchstart' ? e.originalEvent.touches[0] : e;
    lastX = evt.clientX;
    lastY = evt.clientY;
    
    currentPanX = zoomPanX;
    currentPanY = zoomPanY;
    targetPanX = zoomPanX;
    targetPanY = zoomPanY;
    
    velocityX = 0;
    velocityY = 0;
})
.on('mousemove touchmove', function(e) {
    if (!isDragging || !isZoomed) return;
    
    e.preventDefault();
    const evt = e.type === 'touchmove' ? e.originalEvent.touches[0] : e;
    const currentX = evt.clientX;
    const currentY = evt.clientY;
    
    const deltaX = currentX - lastX;
    const deltaY = currentY - lastY;
    
    targetPanX += deltaX;
    targetPanY += deltaY;
    
    velocityX = deltaX * 0.8;
    velocityY = deltaY * 0.8;
    
    lastX = currentX;
    lastY = currentY;
    
    if (!panningAnimationId) {
        smoothPanAnimation();
    }
})
.on('mouseup touchend mouseleave touchcancel', function(e) {
    if (!isDragging) return;
    
    isDragging = false;
    isPanning = false;
    
    if (Math.abs(velocityX) > minVelocity || Math.abs(velocityY) > minVelocity) {
        applyInertia();
    }
});

// Event listener for zoom button
$('#carousel_wrapper, #single_image_area').on('wheel', function(e) {
    if (!$currentZoomableImage || !$currentZoomableImage.length) return;
    
    const originalEvent = e.originalEvent;
    const deltaX = originalEvent.deltaX;
    const deltaY = originalEvent.deltaY;
    
    if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 10 && !isZoomed) {
        e.preventDefault();
        
        if (window.trackpadScrollTimeout) {
            clearTimeout(window.trackpadScrollTimeout);
        }
        
        window.trackpadScrollTimeout = setTimeout(() => {
            if (deltaX > 0) {
                slideNext();
            } else {
                slidePrev();
            }
        }, 150);
        
        return;
    }
    
    if (isZoomed) {
        e.preventDefault();

        const delta = -deltaY;
        const zoomFactor = delta > 0 ? 1.1 : 0.9;
        const newZoomLevel = Math.min(maxZoomLevel, Math.max(1, currentZoomLevel * zoomFactor));

        const rect = $currentZoomableImage[0].getBoundingClientRect();
        const offsetX = originalEvent.clientX - rect.left;
        const offsetY = originalEvent.clientY - rect.top;

        const percentX = offsetX / rect.width;
        const percentY = offsetY / rect.height;

        const prevZoomLevel = currentZoomLevel;
        currentZoomLevel = newZoomLevel;

        const zoomChange = currentZoomLevel / prevZoomLevel;

        zoomPanX -= (percentX - 0.5) * $currentZoomableImage.width() * (zoomChange - 1);
        zoomPanY -= (percentY - 0.5) * $currentZoomableImage.height() * (zoomChange - 1);

        targetPanX = zoomPanX;
        targetPanY = zoomPanY;
        currentPanX = zoomPanX;
        currentPanY = zoomPanY;

        isZoomed = currentZoomLevel > 1;
        applyZoomTransform();
    }
    else if (Math.abs(deltaY) > Math.abs(deltaX)) {
        e.preventDefault();

        const delta = -deltaY;
        const zoomFactor = delta > 0 ? 1.1 : 0.9;
        const newZoomLevel = Math.min(maxZoomLevel, Math.max(1, currentZoomLevel * zoomFactor));

        const rect = $currentZoomableImage[0].getBoundingClientRect();
        const offsetX = originalEvent.clientX - rect.left;
        const offsetY = originalEvent.clientY - rect.top;

        const percentX = offsetX / rect.width;
        const percentY = offsetY / rect.height;

        const prevZoomLevel = currentZoomLevel;
        currentZoomLevel = newZoomLevel;

        const zoomChange = currentZoomLevel / prevZoomLevel;

        zoomPanX -= (percentX - 0.5) * $currentZoomableImage.width() * (zoomChange - 1);
        zoomPanY -= (percentY - 0.5) * $currentZoomableImage.height() * (zoomChange - 1);

        targetPanX = zoomPanX;
        targetPanY = zoomPanY;
        currentPanX = zoomPanX;
        currentPanY = zoomPanY;

        isZoomed = currentZoomLevel > 1;
        applyZoomTransform();
    }
});

// Function to reset all interaction states
function resetInteractionStates() {
    isDraggingX = false;
    isDraggingY = false;
    isPanning = false;
    hasDraggedX = false;
    hasDraggedY = false;
    startPosX = undefined;
    startPosY = undefined;
    currentTranslateX = 0;
    currentTranslateY = 0;
}

// Function to close the fullscreen library
function closeFullscreenLibrary() {
    $('#fullscreen_container').fadeOut(function() {
        $('body').css({
            position: '',
            top: '',
            width: '',
            overflow: ''
        });
        window.scrollTo(0, initialScrollY);
        stopAutoplay();
        resetZoom();
        fullscreenContentScrollTop = 0;
        $('#carousel_slider').empty();
        $('#thumbnail_container').empty();
        
        // Reset all interaction states
        resetInteractionStates();
        
        $('#fullscreen_container').removeClass('dragging no-select');
        $('#fullscreen_content').css({
            'transition': '',
            'transform': 'translateY(0px)'
        });
        $('#carousel_slider').css({
            'transition': '',
            'transform': ''
        });
    });
}


// Function to toggle native fullscreen mode in browser
function toggleNativeFullscreen(elementToFullscreen) {
    if (!elementToFullscreen) return;

    if (!document.fullscreenElement) {
        isFullscreenOperationInProgress = true;
        const scrollableContent = $('#carousel_wrapper').is(':visible') ? $('#carousel_wrapper')[0] : $('#single_image_area')[0];
        if (scrollableContent) {
            fullscreenContentScrollTop = scrollableContent.scrollTop;
        }

        const requestFn = elementToFullscreen.requestFullscreen ||
                              elementToFullscreen.mozRequestFullScreen ||
                              elementToFullscreen.webkitRequestFullscreen ||
                              elementToFullscreen.msRequestFullscreen;
        if (requestFn) {
            requestFn.call(elementToFullscreen)
                .then(() => {
                    const scrollableContentAfterFs = $('#carousel_wrapper').is(':visible') ? $('#carousel_wrapper')[0] : $('#single_image_area')[0];
                     if (scrollableContentAfterFs) {
                        setTimeout(() => {
                            scrollableContentAfterFs.scrollTop = fullscreenContentScrollTop;
                        }, 50); 
                    }
                })
                .catch(error => {
                    console.error("Fullscreen request failed:", error);
                    isFullscreenOperationInProgress = false;
                });
        }
    } else {
        isFullscreenOperationInProgress = true;
        const exitFn = document.exitFullscreen ||
                               document.mozCancelFullScreen ||
                               document.webkitExitFullscreen ||
                               document.msExitFullscreen;
        if (exitFn) {
            exitFn.call(document)
                .then(() => {
                    const scrollableContent = $('#carousel_wrapper').is(':visible') ? $('#carousel_wrapper')[0] : $('#single_image_area')[0];
                    if (scrollableContent) {
                        scrollableContent.scrollTop = fullscreenContentScrollTop;
                    }
                })
                .catch(error => {
                    console.error("Fullscreen exit failed:", error);
                    isFullscreenOperationInProgress = false;
                });
        }
    }
}

// Event listener for the fullscreen button
document.addEventListener('fullscreenchange', (event) => {
    if (document.fullscreenElement) {
        $('body').addClass('image-fullscreen-active');
        showNotification();
        const scrollableContent = $('#carousel_wrapper').is(':visible') ? $('#carousel_wrapper')[0] : $('#single_image_area')[0];
        if (document.fullscreenElement === $('#fullscreen_content')[0] && scrollableContent) {
            setTimeout(() => {
                scrollableContent.scrollTop = fullscreenContentScrollTop;
            }, 50);
        }
    } else {
        $('body').removeClass('image-fullscreen-active');
        clearTimeout(notificationTimeout);
        $('#fullscreen_notification').removeClass('show');

        const scrollableContent = $('#carousel_wrapper').is(':visible') ? $('#carousel_wrapper')[0] : $('#single_image_area')[0];
        if (scrollableContent && $('#fullscreen_container').is(':visible')) {
             setTimeout(() => {
                scrollableContent.scrollTop = fullscreenContentScrollTop;
            }, 50);
        }
    }
    setTimeout(() => {
        isFullscreenOperationInProgress = false;
    }, 50);
});

// Function to apply controls to the container like autoplay, zoom, fullscreen etc.
function applyControlVisibility($container) {
    const controlsAttribute = $container.data('velisoft-img-libcontrols');
    let hideControls = false;

    if (controlsAttribute === false || controlsAttribute === 'false') {
        hideControls = true;
    } else if (controlsAttribute === true || controlsAttribute === 'true') {
        hideControls = false;
    }

    const elementsToControl = {
        '#imageCounter': 'flex',
        '#autoplay_progress_bar_container': 'block',
        '#zoom_button': 'flex',
        '#fullerscreen_button': 'flex',
        '#play_button': 'flex'
    };

    for (const selector in elementsToControl) {
        const $el = $(selector);
        const displayType = elementsToControl[selector];

        if (hideControls) {
            $el.css('display', 'none');
        } else {
            $el.css('display', displayType);
        }
    }
}

// Function to initialize the image library in full
$(document).ready(function () {
    resetInteractionStates();
    
    if ($('#fullscreen_container').length === 0) {
        $('body').append(
            `<div id="fullscreen_container">
                <div id="imageCounter">
                    <span id="currentImageCount">1</span> / <span id="totalImageCount"></span>
                </div>
                <div id="fullscreen_notification">Press "ESC" to exit</div>

                <div id="autoplay_progress_bar_container">
                    <div id="autoplay_progress_bar"></div>
                </div>

                <div id="full-buttons_container">
                    <button id="zoom_button">
                        <svg class="zoom-in-icon" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="11" y1="8" x2="11" y2="14" />
                            <line x1="8" y1="11" x2="14" y2="11" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <svg class="zoom-out-icon" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="8" y1="11" x2="14" y2="11" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </button>
                    <button id="fullerscreen_button">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4H9V2H2V9H4V4Z" fill="currentColor"/>
                            <path d="M20 4H15V2H22V9H20V4Z" fill="currentColor"/>
                            <path d="M4 20H9V22H2V15H4V20Z" fill="currentColor"/>
                            <path d="M20 20H15V22H22V15H20V20Z" fill="currentColor"/>
                        </svg>
                    </button>
                    <button id="play_button">
                        <svg class="play-icon" width="35" height="35" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="8,5 19,12 8,19" />
                        </svg>
                        <svg class="pause-icon" width="35" height="35" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <rect x="6" y="5" width="4" height="14"/>
                            <rect x="14" y="5" width="4" height="14"/>
                        </svg>
                    </button>
                    <button id="closing_button">
                        <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <div id="fullscreen_content">
                    <div id="carousel_area">
                        <div id="carousel_wrapper">
                            <div id="carousel_slider"></div>
                        </div>
                        <p id="fullscreen_title"></p>
                        <div id="thumbnail_container"></div>
                        <button id="prev_button" class="nav_button">
                            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                        </button>
                        <button id="next_button" class="nav_button">
                            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </button>
                    </div>
                    <div id="single_image_area" style="display: none;">
                        <img id="single_fullscreen_image" src="" alt="" class="fullscreen_image">
                        <p id="single_fullscreen_title"></p>
                    </div>
                </div>
            </div>
            `
        );
    }

    $('[data-velisoft-img-lib]').on('click', '.gallery_image', function (e) {
        if (!isDraggingX && !isDraggingY && !isPanning) {
            hasDraggedX = false;
            hasDraggedY = false;
        }
        
        if (hasDraggedX || hasDraggedY) {
            hasDraggedX = false;
            hasDraggedY = false;
            e.preventDefault();
            return;
        }

        initialScrollY = window.scrollY || window.pageYOffset;

        $('body').css({
            position: 'fixed',
            top: `-${initialScrollY}px`,
            width: '100%',
            overflow: 'hidden' 
        });


        const $clickedImg = $(this);
        const $container = $clickedImg.closest('[data-velisoft-img-lib]');
        const libType = $container.data('velisoft-img-lib');

        $('#imageCounter, #autoplay_progress_bar_container, #zoom_button, #fullerscreen_button, #play_button, .nav_button, #thumbnail_container').hide();

        $('#carousel_area').hide();
        $('#single_image_area').hide();

        if (libType === 'gallery') {
            currentImages = $container.find('.gallery_image').toArray();
            currentImageIndex = currentImages.indexOf($clickedImg[0]);

            $('#carousel_area').show();
            $('.nav_button').show();
            $('#thumbnail_container').show();
            setupCarouselImages();
            fullscreenContentScrollTop = $('#carousel_wrapper')[0].scrollTop;
        } else {
            currentImages = [$clickedImg[0]];
            currentImageIndex = 0;

            $('#single_image_area').show();
            const imgSrc = $clickedImg.attr('src');
            const imgAlt = $clickedImg.attr('alt') || '';
            const $singleImage = $('#single_fullscreen_image');
            $singleImage.attr('src', imgSrc).attr('alt', imgAlt);
            $currentZoomableImage = $singleImage;

            $('.nav_button').hide();
            $('#thumbnail_container').empty().hide();
            $('#carousel_slider').empty();
            fullscreenContentScrollTop = $('#single_image_area')[0].scrollTop;
        }

        applyControlVisibility($container);

        $('#totalImageCount').text(currentImages.length);
        updateImageCounter();

        $('#fullscreen_container').fadeIn();

        $('#fullscreen_content').css('transform', 'translateY(0px)');

        stopAutoplay();
        resetZoom();
    });

    $(document).on('click', '#closing_button', function (e) {
        e.stopPropagation();
        closeFullscreenLibrary();
    });

    $(document).on('click', '#fullerscreen_button', function (e) {
        e.stopPropagation();
        const elementToFullscreen = $('#fullscreen_content')[0];

        if (elementToFullscreen) {
            toggleNativeFullscreen(elementToFullscreen);
        }
    });

    $(document).on('click', '#play_button', function (e) {
        e.stopPropagation();
        if (isZoomed) return;
        if (isAutoplayActive) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });

    $(document).on('click', '#zoom_button', function (e) {
        e.stopPropagation();
        toggleZoom();
    });

    $(document).on('dblclick', '#carousel_wrapper, #single_image_area', function (e) {
        e.preventDefault();
        toggleZoom();
    });

    $(document).on('keydown', function (e) {
        if (e.key === "Escape" || e.keyCode === 27) {
            if (isZoomed) {
                resetZoom();
            } else if (document.fullscreenElement) {
                document.exitFullscreen();
            } else if ($('#fullscreen_container').is(':visible')) {
                closeFullscreenLibrary();
            }
        }
    });

    $(document).on('click', '#prev_button', function (e) {
        e.stopPropagation();
        if (isZoomed) return;
        slidePrev();
    });

    $(document).on('click', '#next_button', function (e) {
        e.stopPropagation();
        if (isZoomed) return;
        slideNext();
    });

    $(document).on('mousedown touchstart', '#carousel_wrapper', function (e) {
        if (isZoomed) {
            isPanning = true;
            $currentZoomableImage.addClass('panning no-select');
            const clientX = e.clientX || e.originalEvent.touches[0].clientX;
            const clientY = e.clientY || e.originalEvent.touches[0].clientY;
            zoomStartPointerX = clientX - zoomPanX;
            zoomStartPointerY = clientY - zoomPanY;
            e.preventDefault();
        } else {
            if (e.type === 'mousedown') {
                const clientX = e.clientX;
                const clientY = e.clientY;
                
                startPosX = clientX;
                startPosY = clientY;
                
                $('#fullscreen_container').addClass('no-select');
                $('#carousel_slider').css('transition', 'none');
                stopAutoplay();

                e.preventDefault();
            } else {
                // Touch events
                const clientX = e.originalEvent.touches[0].clientX;
                const clientY = e.originalEvent.touches[0].clientY;
                
                startPosX = clientX;
                startPosY = clientY;
                
                $('#fullscreen_container').addClass('no-select');
                $('#carousel_slider').css('transition', 'none');
                stopAutoplay();
            }
        }
    });

    $(document).on('mousedown touchstart', '#single_image_area', function (e) {
        if (isZoomed) {
            isPanning = true;
            $('#single_fullscreen_image').addClass('panning no-select');
            const clientX = e.clientX || e.originalEvent.touches[0].clientX;
            const clientY = e.clientY || e.originalEvent.touches[0].clientY;
            zoomStartPointerX = clientX - zoomPanX;
            zoomStartPointerY = clientY - zoomPanY;
            e.preventDefault();
        } else {
            // Allow vertical swipe to close on single images too
            const clientX = e.clientX || e.originalEvent.touches[0].clientX;
            const clientY = e.clientY || e.originalEvent.touches[0].clientY;
            
            startPosX = clientX;
            startPosY = clientY;
            
            $('#fullscreen_container').addClass('no-select');
        }
    });

    $(document).on('mousemove touchmove', function (e) {
        if (isPanning) {
            const clientX = e.clientX || e.originalEvent.touches[0].clientX;
            const clientY = e.clientY || e.originalEvent.touches[0].clientY;

            zoomPanX = clientX - zoomStartPointerX;
            zoomPanY = clientY - zoomStartPointerY;
            applyZoomTransform();
        } else if (isDraggingX) {
            const currentX = e.type === 'mousemove' ? e.clientX : e.originalEvent.touches[0].clientX;
            currentTranslateX = prevTranslateX + (currentX - startPosX);
            $('#carousel_slider').css('transform', `translateX(${currentTranslateX}px)`);

            if (Math.abs(currentX - startPosX) > 10) {
                hasDraggedX = true;
            }
        } else if (isDraggingY) {
            const currentY = e.type === 'mousemove' ? e.clientY : e.originalEvent.touches[0].clientY;
            currentTranslateY = currentY - startPosY;
            $('#fullscreen_content').css('transform', `translateY(${currentTranslateY}px)`);

            if (Math.abs(currentY - startPosY) > 10) {
                hasDraggedY = true;
            }
        } else if (!isZoomed && (startPosX !== undefined && startPosY !== undefined)) {
            // Determine drag direction based on movement
            const currentX = e.type === 'mousemove' ? e.clientX : e.originalEvent.touches[0].clientX;
            const currentY = e.type === 'mousemove' ? e.clientY : e.originalEvent.touches[0].clientY;
            const deltaX = Math.abs(currentX - startPosX);
            const deltaY = Math.abs(currentY - startPosY);
            
            // Only start dragging if movement exceeds threshold
            if (deltaX > 15 || deltaY > 15) {
                if (deltaY > deltaX) {
                    // Vertical movement - start vertical drag to close
                    isDraggingY = true;
                    $('#fullscreen_container').addClass('dragging');
                    $('#fullscreen_content').css('transition', 'none');
                    
                    // Apply initial transform
                    currentTranslateY = currentY - startPosY;
                    $('#fullscreen_content').css('transform', `translateY(${currentTranslateY}px)`);
                    hasDraggedY = true;
                } else {
                    // Horizontal movement - start horizontal drag for navigation
                    isDraggingX = true;
                    $('#fullscreen_container').addClass('dragging');
                    $('#carousel_wrapper').addClass('dragging');
                    
                    // Apply initial transform
                    currentTranslateX = prevTranslateX + (currentX - startPosX);
                    $('#carousel_slider').css('transform', `translateX(${currentTranslateX}px)`);
                    hasDraggedX = true;
                }
            }
        }
    });

    $(document).on('mouseup touchend mouseleave', function (e) {
        // Always reset states when mouse leaves the document or on mouseup/touchend
        if (isPanning) {
            isPanning = false;
            if ($currentZoomableImage) {
                $currentZoomableImage.removeClass('panning no-select');
            }
            applyZoomTransform();
        } else if (isDraggingX) {
            isDraggingX = false;
            $('#fullscreen_container').removeClass('dragging no-select');
            $('#carousel_wrapper').removeClass('dragging no-select');

            const endPosX = e.type === 'mouseup' || e.type === 'mouseleave' ? e.clientX : e.originalEvent.changedTouches[0].clientX;
            const diffX = endPosX - startPosX;
            const threshold = 50;

            const $carouselSlider = $('#carousel_slider');
            const $currentActiveImage = $carouselSlider.find('.carousel_image.current_active');
            if ($currentActiveImage.length === 0) {
                setupCarouselImages();
                return;
            }

            if (diffX > threshold) {
                currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
                
                const $allCarouselImages = $carouselSlider.find('.carousel_image');
                const currentSliderIndex = $allCarouselImages.index($currentActiveImage);
                const $prevImage = $($allCarouselImages[currentSliderIndex - 1]);
                
                if ($prevImage.length) {
                    $carouselSlider.find('.carousel_image').removeClass('current_active');
                    $prevImage.addClass('current_active');
                    $currentZoomableImage = $prevImage;
                }
                
                animateSlide(-1);
            } else if (diffX < -threshold) {
                currentImageIndex = (currentImageIndex + 1) % currentImages.length;
                
                const $allCarouselImages = $carouselSlider.find('.carousel_image');
                const currentSliderIndex = $allCarouselImages.index($currentActiveImage);
                const $nextImage = $($allCarouselImages[currentSliderIndex + 1]);
                
                if ($nextImage.length) {
                    $carouselSlider.find('.carousel_image').removeClass('current_active');
                    $nextImage.addClass('current_active');
                    $currentZoomableImage = $nextImage;
                }
                
                animateSlide(1);
            } else {
                animateSlide(0);
            }
            
            resetInteractionStates();
        } else if (isDraggingY) {
            isDraggingY = false;
            $('#fullscreen_container').removeClass('dragging no-select');
            
            const endPosY = e.type === 'mouseup' || e.type === 'mouseleave' ? e.clientY : e.originalEvent.changedTouches[0].clientY;
            const diffY = endPosY - startPosY;

            if (Math.abs(diffY) > 60) {
                hasDraggedY = true;
                closeFullscreenLibrary();
                
                setTimeout(() => {
                    resetInteractionStates();
                }, 100);
            } else {
                $('#fullscreen_content').css({
                    'transition': `transform ${closeAnimationDuration / 1000}s ease-out`,
                    'transform': 'translateY(0px)'
                });
                hasDraggedY = false;
                resetInteractionStates();
            }
        } else {
            $('#fullscreen_container').removeClass('no-select dragging');
            resetInteractionStates();
        }
        
        setTimeout(() => {
            $('#carousel_slider').css('transition', `transform ${carouselTransitionDuration / 1000}s ease`);
        }, 50);
    });

    $(document).on('mouseleave', '#carousel_wrapper', function(e) {
        if (isDraggingX || isDraggingY) {
            isDraggingX = false;
            isDraggingY = false;
            $('#fullscreen_container').removeClass('dragging no-select');
            $('#carousel_wrapper').removeClass('dragging no-select');
            
            if (hasDraggedX) {
                animateSlide(0);
            }
            
            if (hasDraggedY) {
                $('#fullscreen_content').css({
                    'transition': `transform ${closeAnimationDuration / 1000}s ease-out`,
                    'transform': 'translateY(0px)'
                });
            }
            
            resetInteractionStates();
            
            setTimeout(() => {
                $('#carousel_slider').css('transition', `transform ${carouselTransitionDuration / 1000}s ease`);
            }, 50);
        }
    });

    $(document).on('dragstart', '.no-select', function(e) {
        e.preventDefault();
    });

    $(document).on('click', '#fullscreen_container', function(e) {
        const $target = $(e.target);

        const doNotCloseSelectors = [
            '#carousel_wrapper',
            '#single_image_area',
            '#full-buttons_container',
            '#thumbnail_container',
            '.nav_button',
            '#imageCounter',
            '#autoplay_progress_bar_container',
            '#fullscreen_notification',
            '#fullscreen_title'
        ];

        let clickedOnProtectedElement = false;
        for (const selector of doNotCloseSelectors) {
            if ($target.closest(selector).length) {
                clickedOnProtectedElement = true;
                break;
            }
        }

        if (!clickedOnProtectedElement) {
            closeFullscreenLibrary();
        }
    });
});