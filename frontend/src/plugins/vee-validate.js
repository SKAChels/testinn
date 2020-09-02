import Vue from 'vue';
import {extend, localize, ValidationProvider} from 'vee-validate';
import ru from 'vee-validate/dist/locale/ru.json';
import {required} from "vee-validate/dist/rules";

Vue.component('ValidationProvider', ValidationProvider);

localize('ru', ru);

extend('required', {
    ...required
});
extend('length_one_of', {
    validate(value, values) {
        if (values.indexOf(String(value.length)) !== -1) {
            return true;
        }

        return '{_field_} должно быть длиной 10 или 12 символов';
    },
});