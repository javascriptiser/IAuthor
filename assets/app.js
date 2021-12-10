/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/colorTheme.css'
import './styles/media.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'font-awesome/css/font-awesome.css';
import 'select2/dist/css/select2.min.css'
import 'simplemde/dist/simplemde.min.css'

const $ = require('jquery');
global.$ = global.jQuery = $;
import 'select2'
import 'popper.js';
import 'bootstrap';
import './js/colorThemingModule'
import './js/swiper'
import Sortable from 'sortablejs/modular/sortable.core.esm.js';
import {imageModule} from "./js/imageModule";
import {likesModule} from "./js/likesModule";
import 'cropperjs/dist/cropper.min'
import 'cropperjs/dist/cropper.min.css'
import 'jquery-cropper/dist/jquery-cropper.min'
import SimpleMDE from 'simplemde/dist/simplemde.min'

window.simpleMde = SimpleMDE;
window.imageModule = imageModule;
window.likesModule = likesModule;
window.sortable = Sortable;

