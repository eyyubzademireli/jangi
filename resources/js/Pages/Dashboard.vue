<template>
    <div class="w-full h-full bg-white">
        <div class="w-[1280px] h-full mx-auto flex">
            <div class="w-[280px] fixed top-0 py-4 h-screen min-h-[500px] scroll-auto overflow-auto">
                <a :href="item.link" :class="{'w-full py-2 my-2 flex justify-start space-x-4 cursor-pointer items-center font-semibold text-md text-gray-500 hover:text-blue-500 transition-all': currentPage != item.route, 'w-full py-2 my-2 flex justify-start space-x-4 cursor-pointer items-center font-semibold text-md text-blue-700': currentPage == item.route,}" v-for="item in leftmenu" :key="item.id"><i :class="item.icon"></i><span>{{ item.text }}</span></a>
                <div @click="logout" class="w-full py-2 my-2 flex justify-start space-x-4 cursor-pointer items-center font-semibold text-md text-gray-500 hover:text-blue-500 transition-all"><i class="fas fa-right-from-bracket"></i><span>Çıxış</span></div>
            </div>
            <div class="w-[1000px] fixed top-0 ml-[280px] py-4 h-screen min-h-[500px] scroll-auto overflow-auto">
                <managers-component v-if="currentPage == 'managers'" :managers="managers" />
                <teams-component v-if="currentPage == 'teams'" :teams="teams" />
                <awards-component v-if="currentPage == 'awards'" :awards="awards" />
                <events-component v-if="currentPage == 'events'" :events="events" />
                <media-component v-if="currentPage == 'media'" :media="media" />
                <messages-component v-if="currentPage == 'messages'" :messages="messages" />
                <info-component v-if="currentPage == 'info'" :info="info" />
                <about-component v-if="currentPage == 'about'" :about="about" />
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import ManagersComponent from './DashboardComponents/ManagersComponent.vue';
import TeamsComponent from './DashboardComponents/TeamsComponent.vue';
import AwardsComponent from './DashboardComponents/AwardsComponent.vue';
import EventsComponent from './DashboardComponents/EventsComponent.vue';
import MediaComponent from './DashboardComponents/MediaComponent.vue';
import MessagesComponent from './DashboardComponents/MessagesComponent.vue';
import InfoComponent from './DashboardComponents/InfoComponent.vue';
import AboutComponent from './DashboardComponents/AboutComponent.vue';
import { Inertia } from '@inertiajs/inertia';

export default defineComponent ({
    name: "Home",
    components: {
        ManagersComponent,
        TeamsComponent,
        AwardsComponent,
        EventsComponent,
        MediaComponent,
        MessagesComponent,
        InfoComponent,
        AboutComponent,
    },
    props: [
        'managers',
        'teams',
        'awards',
        'events',
        'media',
        'messages',
        'info',
        'about',
        'currentPage',
    ],
    setup(props) {
        // Properties
        const leftmenu = [
            {
                id: 1,
                text: "İdarəçilər",
                icon: "fas fa-user-shield",
                route: "managers",
                link: "/composer/managers",
            },
            {
                id: 2,
                text: "Komandamız",
                icon: "fas fa-people-group",
                route: "teams",
                link: "/composer/teams",
            },
            {
                id: 3,
                text: "Mükafatlar",
                icon: "fas fa-award",
                route: "awards",
                link: "/composer/awards",
            },
            {
                id: 4,
                text: "Tədbirlər",
                icon: "fas fa-calendar",
                route: "events",
                link: "/composer/events",
            },
            {
                id: 5,
                text: "Media",
                icon: "fas fa-images",
                route: "media",
                link: "/composer/media",
            },
            {
                id: 6,
                text: "İsmarıclar",
                icon: "fas fa-message",
                route: "messages",
                link: "/composer/messages",
            },
            {
                id: 7,
                text: "Məlumatlar",
                icon: "fas fa-file-contract",
                route: "info",
                link: "/composer/info",
            },
            {
                id: 7,
                text: "Haqqımızda",
                icon: "fas fa-address-card",
                route: "about",
                link: "/composer/about",
            },
        ];

        const logout = () => {
            Inertia.post(route('logout'));
        };

        const managers = props.managers;
        const teams = props.teams;
        const awards = props.awards;
        const events = props.events;
        const media = props.media;
        const messages = props.messages;
        const info = props.info;
        const about = props.about;

        const currentPage = props.currentPage !== null? props.currentPage : 'managers';

        return {
            // Properties
            leftmenu,
            managers,
            teams,
            awards,
            events,
            media,
            messages,
            info,
            about,
            currentPage,
            logout
        }
    }
})
</script>
