<script lang="ts" setup>
import { UButton, UInput } from "~/Components/index";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
});

async function login() {
    await form.post("/login", {
        onError: (error) => {
            console.log(error);
        },
    });
}
</script>

<template>
    <form @submit.prevent="login" class="login-form">
        <UInput
            v-model="form.email"
            placeholder="Электронная почта"
            :error="form.errors.email"
        />
        <UInput
            v-model="form.password"
            type="password"
            placeholder="Пароль"
            :error="form.errors.password"
        />
        <UButton>Войти</UButton>
    </form>
</template>

<style lang="scss" scoped>
.login-form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 25px;
}
</style>
