<script lang="ts" setup>
defineProps({
    type: {
        type: String as PropType<"primary" | "secondary">,
        default: "primary",
    },
    disabled: {
        type: Boolean as PropType<boolean>,
        required: false,
    },
});
</script>

<template>
    <button class="btn" :class="{ [`_${type}`]: type }" :disabled="disabled">
        <slot></slot>
    </button>
</template>

<style lang="scss" scoped>
.btn {
    @include Text-base;
    border: none;
    padding: 14px 25px;
    cursor: pointer;
    border-radius: 8px;
    transition: box-shadow 0.3s;

    &:hover {
        @include PrimaryShadow;
    }

    &._primary {
        background-color: $primary;
        color: $white;

        &:disabled {
            background-color: $disabled-primary;
        }
    }
    &._secondary {
        background-color: $grey;
        color: $white;
    }

    &:disabled {
        cursor: default;

        &:hover {
            box-shadow: none;
        }
    }
}
</style>
