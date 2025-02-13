<script lang="ts" setup>
import { router, Link } from "@inertiajs/vue3";
import { LayoutRoutes } from "~/Routing/index";
import { ArrowLeftEndOnRectangleIcon } from "@heroicons/vue/16/solid";

async function logout() {
    await router.post("/logout");
}
</script>

<template>
    <div class="layout">
        <nav class="layout__navbar navbar">
            <div class="navbar__inner">
                <div class="navbar__user"></div>
                <div class="navbar__menu">
                    <Link
                        v-for="route in LayoutRoutes"
                        :key="route.url"
                        :href="route.url"
                        class="layout__link link"
                    >
                        <component class="layout__icon" :is="route.icon" />
                        {{ route.label }}
                    </Link>
                </div>
                <span @click="logout" class="navbar__logout"
                    ><ArrowLeftEndOnRectangleIcon class="layout__icon" />
                    Выйти
                </span>
            </div>
        </nav>
        <main class="layout__page">
            <slot></slot>
        </main>
    </div>
</template>

<style lang="scss" scoped>
.layout {
    width: 100%;
    height: 100%;

    &__page {
        backdrop-filter: blur(50px);
        padding-left: 250px;
    }

    &__icon {
        width: 35px;
    }

    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        z-index: z("site-header");
        border-right: 1px solid gray;
        backdrop-filter: blur(3px);
        height: 100%;
    }
}
</style>
