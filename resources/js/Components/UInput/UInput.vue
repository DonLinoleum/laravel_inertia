<script lang="ts" setup>
import { PropType, useId, defineEmits, ref } from "vue";
const id = useId();

defineProps({
    placeholder: {
        type: String as PropType<string>,
        required: false,
    },
    type: {
        type: String as PropType<"text" | "password" | "email">,
        default: "text",
    },
    error: {
        type: String as PropType<string>,
        required: false,
    },
    disabled: {
        type: Boolean as PropType<boolean>,
        required: false,
    },
});
const data = defineModel<string>();
</script>

<template>
    <label :for="id" class="input">
        <input
            class="input__field"
            :class="{ _error: error }"
            :id="id"
            :type="type"
            :placeholder="placeholder"
            :disabled="disabled"
            v-model="data"
        />
        <span v-if="error" class="input__error">{{ error }}</span>
    </label>
</template>

<style lang="scss">
.input {
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 100%;

    &__field {
        @include Text-base;
        width: 100%;
        background-color: transparent;
        color: $white;
        outline: none;
        border: 1px solid $grey;
        border-radius: 8px;
        padding: 10px 15px;
        border-radius: 8px;

        &:disabled {
            color: $grey;
        }

        &:focus {
            @include PrimaryShadow;
        }

        &._error {
            border: 1px solid $error;

            &:focus {
                @include ErrorShadow;
            }
        }
    }

    &__error {
        @include Text-small;
        color: $error;
    }
}
</style>
