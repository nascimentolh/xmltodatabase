$(function () {
    $('.colorpicker').colorpicker();

    //Dropzone
    Dropzone.options.frmFileUpload = {
        paramName: "file",
        maxFilesize: 2
    };


    //Multi-select
    $('#optgroup').multiSelect({ selectableOptgroup: true });

    //noUISlider
    var sliderBasic = document.getElementById('nouislider_basic_example');
    noUiSlider.create(sliderBasic, {
        start: [30],
        connect: 'lower',
        step: 1,
        range: {
            'min': [0],
            'max': [100]
        }
    });
    getNoUISliderValue(sliderBasic, true);

    //Range Example
    var rangeSlider = document.getElementById('nouislider_range_example');
    noUiSlider.create(rangeSlider, {
        start: [32500, 62500],
        connect: true,
        range: {
            'min': 25000,
            'max': 100000
        }
    });
    getNoUISliderValue(rangeSlider, false);
});

//Get noUISlider Value and write on
function getNoUISliderValue(slider, percentage) {
    slider.noUiSlider.on('update', function () {
        var val = slider.noUiSlider.get();
        if (percentage) {
            val = parseInt(val);
            val += '%';
        }
        $(slider).parent().find('span.js-nouislider-value').text(val);
    });
}