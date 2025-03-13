<script lang="ts" setup>
import { PropType } from "vue";
import dayjs from "dayjs";

defineProps({
    isCurrent: {
        type: Boolean as PropType<boolean>,
    },
    text: {
        type: String as PropType<string>,
    },
    date: {
        type: String as PropType<string>,
    },
});
</script>

<template>
    <div class="message" :class="{ _current: isCurrent }">
        <div class="message__inner" :class="{ _current: isCurrent }">
            <p class="message__content">{{ text }}</p>
            <span class="message__date">{{
                dayjs(date).format("DD.MM.YY HH:mm")
            }}</span>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.message {
    display: flex;
    width: 100%;
    justify-content: flex-start;
    align-items: end;

    &._current {
        justify-content: flex-end;
    }

    &__inner {
        background-color: $grey;
        padding: 15px;
        border-radius: 5px;
        max-width: 500px;

        &._current {
            background-color: $primary;
        }
    }

    &__content {
        @include Text-base;
        margin-bottom: 10px;
        word-wrap: normal;
        overflow-wrap: break-word;
        width: 100%;
        display: inline-block;
    }

    &__date {
        @include Text-small;
        color: $black-50;
    }
}
</style>
