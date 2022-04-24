"use strict";
(function ($) {
    $(document).ready(function () {
        var sliders = $("section.alpins-slider");
        $(sliders).on("mouseenter", ".glide__slide:not(.glide__slide--clone)", function () {
            var slider = $(this).closest("section").find(".background-slider");
            $(slider).find(" > div").addClass("remove-active").eq($(this).index()).addClass("active").removeClass("remove-active");

            setTimeout(function () {
                $(slider).find(".remove-active").removeClass("active remove-active");
            }, 800); 
        }); 
    });
}(jQuery)); 

jQuery(document).ready(function () {
    // Image upload
    ImgUpload();
    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];
        $('.upload-inputfile').each(function () {
            $(this).on('change', function (e) {
                imgWrap = $(this).closest('.upload-box').find('.upload-img-wrap');
                var maxLength = $(this).attr('data-max-length');

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                var iterator = 0;
                filesArr.forEach(function (f, index) {

                    if (!f.type.match('image.*')) {
                        return;
                    }

                    if (imgArray.length > maxLength) {
                        return false
                    } else {
                        var len = 0;
                        for (var i = 0; i < imgArray.length; i++) {
                            if (imgArray[i] !== undefined) {
                                len++;
                            }
                        }
                        if (len > maxLength) {
                            return false;
                        } else {
                            imgArray.push(f);

                            var reader = new FileReader();
                            reader.onload = function (e) {
                                var html = "<div class='upload-img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload-img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload-img-close'></div></div></div>";
                                imgWrap.append(html);
                                iterator++;
                            }
                            reader.readAsDataURL(f);
                        }
                    }
                });
            });
        });

        $('body').on('click', ".upload-img-close", function (e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i].name === file) {
                    imgArray.splice(i, 1);
                    break;
                }
            }
            $(this).parent().parent().remove();
        });
    }

    // Star Rating
    $('#rating-input').rating({
        'showClear': false,
        'showCaption': false,
        'displayOnly': false,
        'min': '0',
        'max': '5',
        'step': '1',
        'size': 'sm'
    });
    $('.star-rating').rating({
        'showClear': false,
        'showCaption': false,
        'displayOnly': true,
        'min': '0',
        'max': '5',
        'step': '1',
        'size': 'xs'
    });
    $('.star-rating-loc').rating({
        'showClear': false,
        'showCaption': true,
        'displayOnly': true,
        'min': '0',
        'max': '5',
        'step': '0.5',
        'size': 'xs',
        'starCaptions': {
            1: '1',
            1.5: '1.5',
            2: '2',
            2.5: '2.5',
            3: '3',
            3.5: '3.5',
            4: '4',
            4.5: '4.5',
            5: '5'
        }
    });
    $('.star-rating-summary').rating({
        'showClear': false,
        'showCaption': true,
        'displayOnly': true,
        'min': '0',
        'max': '5',
        'step': '0.1',
        'size': 'xs',
        'starCaptions': {
            1: '1',
            1.1: '1.1',
            1.2: '1.2',
            1.3: '1.3',
            1.4: '1.4',
            1.5: '1.5',
            1.6: '1.6',
            1.7: '1.7',
            1.8: '1.8',
            1.9: '1.9',
            2: '2',
            2.1: '2.1',
            2.2: '2.2',
            2.3: '2.3',
            2.4: '2.4',
            2.5: '2.5',
            2.6: '2.6',
            2.7: '2.7',
            2.8: '2.8',
            2.9: '2.9',
            3: '3',
            3.1: '3.1',
            3.2: '3.2',
            3.3: '3.3',
            3.4: '3.4',
            3.5: '3.5',
            3.6: '3.6',
            3.7: '3.7',
            3.8: '3.8',
            3.9: '3.9',
            4: '4',
            4.1: '4.1',
            4.2: '4.2',
            4.3: '4.3',
            4.4: '4.4',
            4.5: '4.5',
            4.6: '4.6',
            4.7: '4.7',
            4.8: '4.8',
            4.9: '4.9',
            5: '5'}
    });

});