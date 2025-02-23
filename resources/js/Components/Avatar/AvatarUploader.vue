<script setup lang="ts">
import { PropType, useId, ref } from "vue";
import { UserIcon, PlusIcon } from "@heroicons/vue/16/solid";

defineProps({
    url: {
        type: String as PropType<string>,
    },
    alt: {
        type: String as PropType<string>,
    },
});
const id = useId();
const emit = defineEmits<{
    (e: "uploadFile", file: File): void;
}>();

function onFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        const file = target.files[0];
        emit("uploadFile", file);
    }
}
</script>

<template>
    <label :for="id" class="avatar">
        <template v-if="url">
            <img :src="url" :alt="alt" />
        </template>
        <template v-else>
            <UserIcon class="avatar__icon" />
        </template>
        <input
            :id="id"
            type="file"
            accept="image/*"
            class="avatar__uploader"
            @input="onFileChange"
        />
        <span class="avatar__upload-hover">
            <PlusIcon class="plus-icon" />
        </span>
    </label>
</template>

<style scoped lang="scss">
.avatar {
    width: 200px;
    height: 200px;
    border: 1px solid $grey;
    border-radius: 50%;
    color: $grey;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    overflow: hidden;
    position: relative;

    img {
        width: auto;
        height: 100%;
    }

    &__icon {
        width: 150px;
    }

    &__uploader {
        position: absolute;
        width: 0;
    }

    &__upload-hover {
        position: absolute;
        bottom: -100%;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        height: 50%;
        background-color: $grey-50;
        color: $white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;

        .plus-icon {
            width: 42px;
        }
    }

    &:hover {
        .avatar {
            &__upload-hover {
                bottom: 0;
            }
        }
    }
}
</style>
