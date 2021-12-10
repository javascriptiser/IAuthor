export const likesModule = {
    addLikeButton:null,
    addLike: function (idStory) {

        $.post({
            url: `/story/${idStory}/like`,
            data: JSON.stringify({idStory}),
            contentType: "application/json",
            dataType: 'json',
        }).done(function (e) {
            likesModule.addLikeButton.innerHTML = `Нравится ${e}`;
        })
    },
    init: function (idStory) {
        this.addLikeButton = document.getElementById('addLikeButton');
        this.addLikeButton.addEventListener('click',function (e) {
            e.preventDefault();
            likesModule.addLike(idStory);
        })
    }

}