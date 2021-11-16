export const imageModule = {
    readUrl: function (input) {
        if (input.files && input.files[0]) {
            return new Promise((resolve) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagePreview')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                    resolve(reader.result)
                };

                reader.readAsDataURL(input.files[0]);
            })
        }
    }
}