<script setup lang="ts">
import { useId, PropType } from "vue";

defineProps({
    name: {
        type: String as PropType<string>,
    },
    value: {
        type: String as PropType<string>,
    },
    label: {
        type: String as PropType<string>,
    },
    checked: {
        type: Boolean as PropType<boolean>,
    },
});

const id = useId();
const emit = defineEmits(["update"]);

function update(event: Event) {
    emit("update", event);
}
</script>

<template>
    <label class="radio" :for="id">
        <input
            type="radio"
            :name="name"
            :value="value"
            :checked="checked"
            :id="id"
            @input="update"
        />
        <span class="radio__ball">
            <span class="radio__check"></span>
        </span>
        <span class="radio__label">{{ label }}</span>
    </label>
</template>

<style scoped lang="scss">
.radio {
    display: flex;
    align-items: center;
    gap: 5px;
    position: relative;
    cursor: pointer;

    &__ball {
        width: 15px;
        height: 15px;
        background: $white;
        border: 3px solid $white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    &__check {
        width: 100%;
        height: 100%;
        background: transparent;
        border-radius: 50%;
    }

    input {
        position: absolute;
        width: 0;
    }

    input:checked + .radio__ball > .radio__check {
        background: $primary;
    }
}
</style>
