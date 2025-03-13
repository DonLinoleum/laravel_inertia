<script setup lang="ts">
import {
    Filter,
    FriendsList,
    SubscribersList,
    SubscriptionsList,
    UsersList,
} from "~/Modules/Friends/index";
import { AuthLayout } from "~/Shared/index";
import { PropType, ref } from "vue";
import { IUser } from "~/Types/User";
import { Head } from "@inertiajs/vue3";

const title = ref<string>("Друзья");
const category = ref<
    "all" | "subscriptions" | "sunsribers" | "friends" | "all_users"
>("all");

defineProps({
    users: { type: Array as PropType<IUser[]> },
    friends: { type: { Array } },
    subscribers: { type: { Array } },
    subscriptions: { type: { Array } },
});

function updateCategory(
    value: "all" | "subscriptions" | "sunsribers" | "friends" | "all_users",
) {
    category.value = value;
}
</script>

<template>
    <Head :title="title" />
    <AuthLayout>
        <div class="friends">
            <div class="container">
                <div class="friends__inner">
                    <Filter @update-category="updateCategory" />
                    <FriendsList
                        v-if="category == 'all' || category == 'friends'"
                        :users="friends"
                    />
                    <SubscriptionsList
                        v-if="category == 'all' || category == 'subscriptions'"
                        :users="subscriptions"
                    />
                    <SubscribersList
                        v-if="category == 'all' || category == 'subscribers'"
                        :users="subscribers"
                    />
                    <UsersList
                        v-if="category == 'all' || category == 'all_users'"
                        :users="users"
                    />
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
