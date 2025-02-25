<script lang="ts" setup>
import { IUser } from "~/Types/User";
import { PropType } from "vue";
import { UButton, UCard } from "~/Components/index";

defineProps({
    users: {
        type: Array as PropType<IUser[]>,
    },
});
</script>

<template>
    <div class="users">
        <div class="users__inner">
            <h2 class="users__title">Все пользователи</h2>
            <div class="users__list">
                <UCard
                    v-for="user in users"
                    :key="user.id"
                    :title="user.name"
                    :avatar="user.avatar"
                >
                    <template v-slot:actions>
                        <UButton>Добавить в друзья</UButton>
                    </template>
                </UCard>
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
}
</style>
