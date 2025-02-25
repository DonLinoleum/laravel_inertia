import {
    UserIcon,
    UsersIcon,
    ChatBubbleLeftEllipsisIcon,
} from "@heroicons/vue/16/solid";
import type { FunctionalComponent, HTMLAttributes, VNodeProps } from "vue";

interface Route {
    label: string;
    url: string;
    icon: FunctionalComponent<HTMLAttributes & VNodeProps>;
}

export const LayoutRoutes: Route[] = [
    {
        label: "Профиль",
        url: "/profile",
        icon: UserIcon,
    },
    {
        label: "Друзья",
        url: "/friends",
        icon: UsersIcon,
    },
    {
        label: "Чаты",
        url: "/chats",
        icon: ChatBubbleLeftEllipsisIcon,
    },
];
