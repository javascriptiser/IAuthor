export const cookieModule = {
    setCookie: function (name, value, days = 60) {
        if (name && value) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            let expires = "; expires=" + date.toUTCString();
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        } else {
            console.log('Error in cookieModule')
        }
    },
    getCookie: function (name) {
        // return cookie with name,
        // or undefined, if this cookie doesnt exists
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([.$?*|{}()\[\]\\\/+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
}