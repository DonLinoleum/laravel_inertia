<script lang="ts" setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import UTabs from "~/Components/UTabs/UTabs.vue";
import { LoginForm, RegisterForm } from "~/Modules/Auth/index";

const title = ref("Вход");
const tabs = ref([
    { name: "login", label: "Вход" },
    { name: "register", label: "Регистрация" },
]);
</script>

<template>
    <Head :title="title" />
    <div class="container">
        <div class="home__inner">
            <UTabs :tabs="tabs">
                <template #login>
                    <LoginForm />
                </template>
                <template v-slot:register>
                    <RegisterForm />
                </template>
            </UTabs>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.home {
    width: 100%;
    height: 100%;
    &__inner {
        width: 100%;
        height: 100dvh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
</style>
