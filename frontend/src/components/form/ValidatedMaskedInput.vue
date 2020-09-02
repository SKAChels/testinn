<template lang="pug">
    validation-provider(
        :rules="rules"
        :name="text"
        v-slot="{ valid, errors }"
    )
        b-input.input(
            v-model="valueLocal"
            :placeholder="placeholder"
            v-mask="mask"
            :state="errors[0] ? false : (valid ? true : null)"
            @input="$emit('input', $event)"
            @change="$emit('change', $event)"
        )
        b-form-invalid-feedback {{ errors[0] }}
</template>

<script>
    import {mask} from 'vue-the-mask'

    export default {
        name: 'ValidatedMaskedInput',
        directives: {mask},
        props: {
            text: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
                default: ''
            },
            mask: {
                type: String,
                default: ''
            },
            rules: {
                type: String,
                default: null
            },
            value: null,
        },
        computed: {
            valueLocal: {
                get: function() {
                    return this.value;
                },
                set: function(value) {
                    this.$emit('update:value', value);
                }
            },
        }
    }
</script>

<style scoped lang="sass">
    .input.form-control,
    .form-control.is-valid:focus,
    .was-validated .form-control:valid:focus,
    .was-validated .form-control:invalid:focus,
    .form-control.is-invalid:focus
        display: inline-block
        height: 3.4rem
        border-radius: 3px
        box-shadow: 0 2px 2px 0 rgba(110, 110, 110, 0.15)
        border: solid 1px #f3f3f3
        font-size: 1.5rem
</style>