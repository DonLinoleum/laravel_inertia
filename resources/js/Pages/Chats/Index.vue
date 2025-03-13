<script setup lang="ts">
import AuthLayout from "~/Shared/Layouts/AuthLayout.vue";
import { ref, PropType } from "vue";
import { Head } from "@inertiajs/vue3";
import { IChat } from "~/Types/Chat";
import { ChatCard } from "~/Modules/Chats/index";

const title = ref<string>("Чаты");

defineProps({
    chats: {
        type: Array as PropType<IChat[]>,
    },
});
</script>

<template>
    <Head :title="title" />
    <AuthLayout>
        <!--<pre>{{ chats }}</pre>!-->
        <div class="container">
            <div class="chats__inner">
                <h2 class="chats__title">Чаты</h2>
                <div class="chats__list">
                    <template v-if="chats?.length > 0">
                        <ChatCard
                            v-for="chat in chats"
                            :avatar="chat.other_user_info.avatar"
                            :chat-name="chat.other_user_info.name"
                            :chat-url="`/chats/${chat.chat_id}`"
                            :last-message="chat.last_message?.message"
                        />
                    </template>
                    <template v-else>
                        <h2 class="no-chats">У вас ент ни одного чата.</h2>
                    </template>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<style lang="scss" scoped>
.chats {
    &__inner {
        padding: 30px 0;
    }

    &__title {
        @include H1;
        color: $white;
        margin-bottom: 30px;
    }
}
</style>
