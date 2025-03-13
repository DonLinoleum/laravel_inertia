<script lang="ts" setup>
import { URadio } from "~/Components/index";
import { ref } from "vue";

const emit = defineEmits(["update-category"]);

const categories = ref([
    {
        label: "Все",
        value: "all",
        checked: true,
    },
    {
        label: "Друзья",
        value: "friends",
        checked: false,
    },
    {
        label: "Подписки",
        value: "subscribers",
        checked: false,
    },
    {
        label: "Подписчики",
        value: "subscriptions",
        checked: false,
    },
    {
        label: "Все пользователи",
        value: "all_users",
        checked: false,
    },
]);
function updateCategory(event: Event) {
    const target = event.target as HTMLInputElement;
    const value = target.value;
    emit("update-category", value);
}
</script>

<template>
    <div class="filter">
        <div class="filter__inner">
            <URadio
                v-for="category in categories"
                :key="category.value"
                :label="category.label"
                :value="category.value"
                :checked="category.checked"
                name="category-filter"
                @update="updateCategory"
            />
        </div>
    </div>
</template>

<style scoped lang="scss">
.filter {
    @include GlassEffect;
    border: 1px solid $grey;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;

    &__inner {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 40px;
    }
}
</style>
