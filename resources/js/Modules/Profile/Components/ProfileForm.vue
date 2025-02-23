<script setup lang="ts">
import { usePage, useForm, router } from "@inertiajs/vue3";
import { AvatarUploader, UButton, UInput } from "~/Components/index";
import { IUser } from "~/Types/User";
import { ref } from "vue";

const page = usePage();
const authUser: IUser = page.props.auth.user;
const form = useForm({
    name: authUser.name ?? null,
    email: authUser.email ?? null,
});

const formDisabled = ref<boolean>(true);
function setFormEditable() {
    formDisabled.value = false;
}
function setFormDisabled() {
    form.reset();
    formDisabled.value = true;
}

async function updateProfile() {
    await form.put("user/profile-information", {
        onSuccess: async () => {
            await location.reload();
        },
    });
}

async function updateProfileAvavatar(file: File) {
    await router.post(
        "/profile/update-avatar",
        {
            avatar: file,
        },
        {
            forceFormData: true,
            onSuccess: async () => {
                await location.reload();
            },
        },
    );
}
</script>

<template>
    <AvatarUploader
        :url="authUser.avatar"
        :alt="authUser.name"
        @upload-file="updateProfileAvavatar"
    />
    <form @submit.prevent="updateProfile" class="form">
        <UInput v-model="form.name" :disabled="formDisabled" />
        <UInput v-model="form.email" :disabled="formDisabled" />
        <template v-if="formDisabled">
            <UButton @click.prevent="setFormEditable">Редактировать</UButton>
        </template>
        <template v-else>
            <div class="form__controls">
                <UButton>Сохранить</UButton>
                <UButton type="secondary" @click.prevent="setFormDisabled"
                    >Отменить</UButton
                >
            </div>
        </template>
    </form>
</template>

<style lang="scss" scoped>
.form {
    margin-top: 20px;
    display: flex;
    align-items: flex-start;
    flex-direction: column;
    gap: 20px;

    &__controls {
        display: flex;
        align-items: center;
        gap: 20px;
    }
}
</style>
