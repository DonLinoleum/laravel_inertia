<script lang="ts" setup>
import { router, Link, usePage } from "@inertiajs/vue3";
import { LayoutRoutes } from "~/Routing/index";
import { ArrowLeftEndOnRectangleIcon } from "@heroicons/vue/16/solid";
import Avatar from "~/Components/Avatar/Avatar.vue";
import { computed, onMounted } from "vue";
import { IUser } from "~/Types/User";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

const page = usePage();
const authUser: IUser = computed(() => page.props.auth.user);

async function logout() {
    await router.post("/logout");
}

onMounted(() => {
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        wsHost: "127.0.0.1",
        wsPort: 6001,
        forseTLS: false,
        disabledStats: false,
    });
});
</script>

<template>
    <div class="layout">
        <nav class="layout__navbar navbar">
            <div class="navbar__inner">
                <div class="navbar__user">
                    <Avatar :avatar="authUser.avatar" size="small" />
                    <h2>{{ authUser.name }}</h2>
                </div>
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

        &__inner {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            height: 100%;
        }

        &__user {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;

            h2 {
                @include Text-base;
            }
        }
        &__menu {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        &__logout {
            @include Text-large;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: $white;
            padding: 15px 30px;
            cursor: pointer;
            gap: 20px;
            transition: background-color 0.2;

            &:hover {
                background: $grey-30;
            }
        }
    }

    .link {
        @include Text-large;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: $white;
        padding: 15px 30px;
        cursor: pointer;
        gap: 20p;
        text-decoration: none;
        transition: background-color 0.2;

        &:hover {
            background: $grey-30;
        }
    }
}
</style>
