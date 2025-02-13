<script lang="ts" setup>
import { UButton, UInput } from "~/Components/index";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    name: "",
    password: "",
    password_confirmation: "",
});

async function createUser() {
    await form.post("/register", {
        onError: (error) => {
            console.log(error);
        },
    });
}
</script>

<template>
    <form @submit.prevent="createUser" class="register-form">
        <UInput
            v-model="form.email"
            placeholder="Электронная почта"
            :error="form.errors.email"
        />
        <UInput
            v-model="form.name"
            placeholder="Имя пользователя"
            :error="form.errors.name"
        />
        <UInput
            v-model="form.password"
            type="password"
            placeholder="Пароль"
            :error="form.errors.password"
        />
        <UInput
            v-model="form.password_confirmation"
            type="password"
            placeholder="Повторите пароль"
        />
        <UButton>Создать аккаунт</UButton>
    </form>
</template>

<style lang="scss" scoped>
.register-form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 25px;
}
</style>
