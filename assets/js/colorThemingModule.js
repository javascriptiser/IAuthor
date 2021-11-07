import {cookieModule} from "./cookieModule";

export const colorThemeModule = {
    checkBoxElement: null,
    cookieName: 'colorTheme',
    themeDark: 'theme-dark',
    themeLight: 'theme-light',
    cookieExpireDays: 60,
    cookieModule,
    setColorTheme: function (colorTheme) {
        document.documentElement.className = colorTheme;
        this.storeColorTheme(colorTheme);
    },
    storeColorTheme: function (colorTheme) {
        cookieModule.setCookie(this.cookieName, colorTheme, this.cookieExpireDays)
    },
    toggleColorTheme: function () {
        if (this.checkBoxElement.checked) {
            this.setColorTheme(this.themeDark)
        } else {
            this.setColorTheme(this.themeLight)
        }
    },
    initColorThemeWithCookie: function () {
        let initialColorTheme = cookieModule.getCookie(this.cookieName)

        if (initialColorTheme) {
            this.setColorTheme(initialColorTheme)
        } else {
            this.setColorTheme(this.themeDark)
        }

        let storedColorTheme = cookieModule.getCookie(this.cookieName);

        if (storedColorTheme === this.themeDark) {
            this.checkBoxElement.checked = true;
        }
    },
    initModule: function () {
        this.checkBoxElement = document.getElementById('slider');

        if (this.checkBoxElement) {
            this.checkBoxElement.addEventListener('click', this.toggleColorTheme.bind(colorThemeModule))
        }

        this.initColorThemeWithCookie();
    }
}

colorThemeModule.initModule();
