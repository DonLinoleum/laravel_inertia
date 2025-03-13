<script lang="ts" setup>
import { PropType } from "vue";
import { Link } from "@inertiajs/vue3";
import { Avatar } from "~/Components/index";

defineProps({
    chatUrl: {
        type: String as PropType<string>,
    },
    lastMessage: {
        type: String as PropType<string>,
    },
    avatar: {
        type: String as PropType<string>,
    },
    chatName: {
        type: String as PropType<string>,
    },
});
</script>

<template>
    <Link class="chat-card" :href="chatUrl">
        <div class="chat-card__inner">
            <div class="chat-card__user">
                <Avatar :avatar="avatar" />
                <h2 class="chat-card__name">{{ chatName }}</h2>
            </div>
            <span v-if="lastMessage" class="chat-card__last-message">{{
                lastMessage
            }}</span>
        </div>
    </Link>
</template>

<style lang="scss" scoped>
.chat-card {
    @include GlassEffect;
    display: block;
    padding: 25px;
    border: 1px solid $grey;
    border-radius: 8px;
    text-decoration: none;
    color: $white;

    &__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    &__user {
        display: flex;
        align-items: center;
        gap: 20px;
    }
}
</style>
