<script setup lang="ts">
import { UserIcon } from "@heroicons/vue/16/solid";
import { PropType } from "vue";

defineProps({
    avatar: {
        type: String as PropType<string>,
    },
    size: {
        type: String as PropType<"base" | "large" | "small">,
        default: "base",
    },
});
</script>

<template>
    <div class="avatar" :class="{ [`_${size}`]: size }">
        <img v-if="avatar" :src="avatar" :alt="avatar" />
        <UserIcon v-else class="user-icon" />
    </div>
</template>

<style scoped lang="scss">
.avatar {
    border: 1px solid $grey;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    overflow: hidden;
    color: $white;

    &._base {
        width: 70px;
        height: 70px;

        .user-icon {
            width: 50px;
        }
    }

    &._large {
        width: 100px;
        height: 100px;

        .user-icon {
            width: 80px;
        }
    }

    &._small {
        width: 50px;
        height: 50px;

        .user-icon {
            width: 30px;
        }
    }

    img {
        width: auto;
        height: 100%;
    }
}
</style>
