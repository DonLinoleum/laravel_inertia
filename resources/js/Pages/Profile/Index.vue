<script lang="ts" setup>
import { ProfileForm } from "~/Modules/Profile/index";
import AuthLayout from "~/Shared/Layouts/AuthLayout.vue";
import { ref, PropType } from "vue";
import { Head } from "@inertiajs/vue3";

//const title = ref("Профиль");
defineProps({
    title: {
        type: String as PropType<string>,
        default: "Профиль",
    },
});
</script>

<template>
    <Head :title="title" />
    <AuthLayout>
        <div class="profile">
            <div class="container">
                <div class="profile__inner">
                    <ProfileForm />
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<style lang="scss" scoped>
.profile {
    &__inner {
        padding: 20px 0;
    }
}
</style>
