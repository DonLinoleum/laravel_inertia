<script setup lang="ts">
import { UsersList } from "~/Modules/Friends/index";
import { AuthLayout } from "~/Shared/index";
import { PropType } from "vue";
import { IUser } from "~/Types/User";

defineProps({
    users: { type: Array as PropType<IUser[]> },
    friends: { type: { Array } },
    subscribers: { type: { Array } },
    subscriptions: { type: { Array } },
});
</script>

<template>
    <AuthLayout>
        <div class="friends">
            <div class="container">
                <div class="friends__inner">
                    <UsersList :users="users" />
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<style lang="scss" scoped>
.friends {
    &__inner {
        padding: 20px 0;
    }
}
</style>
