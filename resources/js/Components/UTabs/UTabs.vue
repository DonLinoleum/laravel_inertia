<script lang="ts" setup>
import { PropType, ref, defineProps } from "vue";

interface Tab {
    name: string;
    label: string;
}

const props = defineProps({
    tabs: {
        type: Array as PropType<Tab[]>,
        required: true,
    },
    defaultTab: {
        type: String as PropType<string>,
    },
});

const currentTab = ref(props.defaultTab || props.tabs[0]?.name || "");

function selectTab(tabName: string) {
    currentTab.value = tabName;
}

const isActive = (tabName: string) => {
    return currentTab.value === tabName;
};
</script>

<template>
    <div class="tabs">
        <div class="tabs__list">
            <div
                v-for="tab in props.tabs"
                :key="tab.name"
                class="tabs__button"
                :class="{ _active: isActive(tab.name) }"
                @click="selectTab(tab.name)"
            >
                {{ tab.label }}
            </div>
        </div>
        <div class="tabs__inner">
            <div v-if="currentTab" class="tabs__content">
                <slot :name="currentTab"></slot>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.tabs {
    @include GlassEffect;
    min-width: 600px;
    border: 1px solid $grey;
    border-radius: 10px;
    &__list {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        gap: 10px;
        border-bottom: 1px solid $grey;
    }

    &__button {
        @include H3;
        padding: 10px;
        min-width: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border-radius: 5px;

        &._active {
            background-color: $grey-30;
        }
    }

    &__inner {
        padding: 25px;
    }
}
</style>
