<script lang="ts" setup>
import { IUser } from "~/Types/User";
import { PropType } from "vue";
import { UButton, UCard } from "~/Components/index";
import { router } from "@inertiajs/vue3";

defineProps({
    users: {
        type: Array as PropType<IUser[]>,
    },
});

async function acceptRequest(id: number) {
    await router.post("/friends/accept", {
        friendship_id: id,
    });
}
</script>

<template>
    <div class="users">
        <div class="users__inner">
            <h2 class="users__title">Подписчики</h2>
            <div class="users__list">
                <template v-if="users?.length > 0">
                    <UCard
                        v-for="user in users"
                        :key="user.id"
                        :title="user.name"
                        :avatar="user.avatar"
                    >
                        <template v-slot:actions>
                            <UButton @click="acceptRequest(user.pivot.id)"
                                >Принять заявку</UButton
                            >
                        </template>
                    </UCard>
                </template>
                <template v-else>
                    <h2 class="zero-friends">На вас ни кто не подписан</h2>
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
