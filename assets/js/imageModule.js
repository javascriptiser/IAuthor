export const imageModule = {
    readUrl: function (input) {
        if (input.files && input.files[0]) {
            return new Promise((resolve) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagePreview')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                    resolve(reader.result)
                };

                reader.readAsDataURL(input.files[0]);
            })
        }
    },
    init: function () {
        var $image = $('#imagePreview')

        $('.preview').css({
            overflow: 'hidden',
            maxHeight: 70,
            maxWidth: 70,
            minHeight: 70,
            minWidth: 70,
            borderRadius: '50%'
        });

        $image.cropper({
            minCropBoxWidth: 100,
            minCropBoxHeight: 100,
            preview: '.preview',
            ready: function (e) {
                $(this).cropper('setData', {});
            }
        });
    }

}