<script setup lang="ts">
import { Avatar } from "../index";
import { PropType } from "vue";

defineProps({
    avatar: {
        type: String as PropType<string>,
    },
    title: {
        type: String as PropType<string>,
    },
});
</script>

<template>
    <div class="card">
        <div class="card__inner">
            <div class="card__info">
                <Avatar size="large" :avatar="avatar" />
                <h2 class="card__title">{{ title }}</h2>
            </div>
            <div class="card__content">
                <slot name="content"></slot>
            </div>
            <div class="card__actions">
                <slot name="actions"></slot>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.card {
    @include GlassEffect;
    width: 100%;
    border: 1px solid $grey;
    border-radius: 8px;

    &__inner {
        padding: 20px;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: space-between;
        gap: 50px;
        color: $white;
    }

    &__title {
        @include Text-base;
    }

    &__info {
        display: flex;
        align-items: center;
        gap: 20px;
    }
}
</style>
