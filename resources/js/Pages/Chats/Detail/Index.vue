<script setup lang="ts">
import { Head, usePage } from "@inertiajs/vue3";
import { AuthLayout } from "~/Shared/index";
import { onMounted, PropType } from "vue";
import { IChat, IUser } from "~/Types";
import { IMessage } from "~/Types/Chat";
import { router } from "@inertiajs/vue3";
import { Avatar } from "~/Components/index";
import ChatMessage from "~/Modules/Chats/Components/ChatMessage.vue";
import { ChatMessageInput } from "~/Modules/Chats/index";
import { ref, useTemplateRef, watch, nextTick } from "vue";

type IDetailChat = IChat & {
    id: number;
};

const props = defineProps({
    chat: {
        type: Object as PropType<IDetailChat>,
    },
    otherUser: Object as PropType<IUser>,
});
const page = usePage();
const authUser = page.props.auth.user;
const title = ref<string>(`Чат c ${props.otherUser?.name}`);
const newMessage = ref<string>("");
const messages = ref([]);
const scrollAnchor = useTemplateRef("scrollAnchor");

onMounted(async () => {
    messages.value = props.chat.messages;
    window.Echo.private(`chat-room.${props.chat.id}`).listen(
        "MessageSentEvent",
        (event: IMessage) => {
            messages.value.push(event.message);
        },
    );
    await nextTick();
    scrollToBottom();
    watch(
        () => messages.value.length,
        async (length: number) => {
            await nextTick();
            await scrollToBottom();
        },
    );
});

function scrollToBottom() {
    if (scrollAnchor.value) {
        scrollAnchor.value.scrollTo({
            top: scrollAnchor.value.scrollHeight,
            behavior: "smooth",
        });
    }
}

async function sendMessage() {
    if (newMessage.value.trim() == "") return;
    await router.post(
        "/send-message",
        {
            user_id: props.otherUser.id,
            chat_id: props.chat.id,
            message: newMessage.value,
        },
        {
            onSuccess: () => {
                newMessage.value = "";
            },
        },
    );
}
</script>

<template>
    <Head :title="title" />
    <AuthLayout>
        <div class="chat-wrapper">
            <div class="container">
                <div class="chat-wrapper__inner">
                    <div class="chat">
                        <div class="chat__head">
                            <Avatar :avatar="otherUser?.avatar" />
                            <h2 class="username">{{ otherUser.name }}</h2>
                        </div>
                        <div class="chat__messages" ref="scrollAnchor">
                            <ChatMessage
                                v-for="message in messages"
                                :key="message.id"
                                :is-current="
                                    message.from_user_id == authUser.id
                                "
                                :text="message.message"
                                :date="message.created_at"
                            />
                        </div>
                        <div class="chat__bottom">
                            <ChatMessageInput
                                v-model="newMessage"
                                @submit="sendMessage"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<style lang="scss" scoped>
.chat-wrapper {
    width: 100%;
    height: 100%;

    &__inner {
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat {
        @include GlassEffect;
        width: 100%;
        height: 80dvh;
        border: 1px solid $grey;
        border-radius: 8px;
        display: grid;
        grid-template-rows: 1fr 10fr 1fr;

        &__head {
            border-bottom: 1px solid $grey;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            padding: 10px 20px;

            .username {
                @include H2;
            }
        }

        &__bottom {
            border-top: 1px solid $grey;
            display: flex;
            align-items: center;
            padding: 20px;
        }

        &__messages {
            display: flex;
            flex-direction: column;
            padding: 20px 50px;
            gap: 10px;
            max-height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }
    }
}
</style>
