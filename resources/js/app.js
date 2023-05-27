import './bootstrap';

import {livewire_hot_reload} from 'virtual:livewire-hot-reload';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts';

livewire_hot_reload();

Alpine.data('ToastComponent', ToastComponent);

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
