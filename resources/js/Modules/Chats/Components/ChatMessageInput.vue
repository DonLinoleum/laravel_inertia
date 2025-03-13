<script lang="ts" setup>
import { PaperAirplaneIcon, FaceSmileIcon } from "@heroicons/vue/16/solid";
import EmojiPicker, { type EmojiExt } from "vue3-emoji-picker";
import "vue3-emoji-picker/css";
import { ref, useTemplateRef } from "vue";

const message = defineModel();
const emit = defineEmits<{
    submit: [];
}>();
const picker = useTemplateRef("picker");
const showPicker = ref<boolean>(false);

function sendMessage() {
    emit("submit");
}

function selectEmoji(emoji: EmojiExt) {
    message.value += emoji.i;
}

function togglePicker() {
    showPicker.value = !showPicker.value;
}
</script>

<template>
    <form @submit.prevent="sendMessage" class="message">
        <div class="message__emoji">
            <EmojiPicker
                v-show="showPicker"
                ref="picker"
                class="emoji-picker"
                theme="dark"
                disable-skin-tones
                disable-sticky-group-names
                @select="selectEmoji"
            />
            <FaceSmileIcon @click="togglePicker" class="emoji-icon" />
        </div>
        <input
            type="text"
            class="message__input"
            placeholder="Введите сообщение"
            v-model="message"
        />
        <button v-if="message.length > 0" class="message__send">
            <PaperAirplaneIcon class="paper-icon" />
        </button>
    </form>
</template>

<style lang="scss" scoped>
.message {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 10px;
    background: $grey-30;
    border-radius: 20px;
    gap: 30px;
    box-shadow: 0 0 10px $grey-30;

    &__emoji {
        position: relative;
        .emoji-picker {
            position: absolute;
            bottom: 50px;
        }
    }
    &__input {
        @include Text-base;
        width: 100%;
        border: none;
        outline: none;
        background: none;
        color: $white;
    }

    &__send {
        background: none;
        border: none;
        cursor: pointer;
    }

    .emoji-icon,
    .paper-icon {
        width: 30px;
        color: $white;
        cursor: pointer;
    }
}
</style>
