<script lang="ts" setup>
import { IUser } from "~/Types/User";
import { PropType } from "vue";
import { UButton, UCard } from "~/Components/index";
import { router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import { useToast } from "vue-toastification";

const props = defineProps({
    users: {
        type: Array as PropType<IUser[]>,
    },
});

const toast = useToast();

let prev_user_id: number;
let friends = computed(() =>
    props.users.filter((el: IUser) => {
        let result = el.id != prev_user_id;
        prev_user_id = el.id;
        return result;
    }),
);
onMounted(() => {});

async function createChat(friendId: number) {
    await router.post(
        "/chats/create",
        {
            friend_id: friendId,
        },
        {
            onError: (err: any) => {
                toast.error("Не удалось");
                console.error(err);
            },
        },
    );
}
</script>

<template>
    <div class="users">
        <div class="users__inner">
            <h2 class="users__title">Друзья</h2>
            <div class="users__list">
                <template v-if="users?.length > 0">
                    <UCard
                        v-for="user in friends"
                        :key="user.id"
                        :title="user.name"
                        :avatar="user.avatar"
                    >
                        <template v-slot:actions>
                            <UButton @click="createChat(user.id)"
                                >Отправить сообщение</UButton
                            >
                        </template>
                    </UCard>
                </template>
                <template v-else>
                    <h2 class="zero-users">У вас нет друзей</h2>
                </template>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.users {
    margin-bottom: 20px;

    &__title {
        @include H1;
        margin-bottom: 20px;
    }

    &__list {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .zero-users {
        @include H3;
    }
}
</style>
