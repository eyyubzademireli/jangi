<template>
    <div class="w-full h-full bg-white">
        <welcome-component :info="info" id="welcome" :scrolled="scrolled" @currentPage="currentPage" />

        <team-component :teams="teams" id="team" />

        <about-component :abouts="abouts" id="about" />

        <awards-component :awards="xawards" id="awards" />

        <events-component :events="xevent" id="events" />

        <media-component :media="xmedia" id="media" />

        <contacts-component :info="info" id="contacts" />



        <div class="w-full h-28 bg-gray-900">
            <div class="text-white 2xl:w-[72rem] h-full flex justify-between items-center mx-auto">
                <div>
                    <span class="brush text-2xl">JANGI</span>
                </div>
                <div class="text-lg flex space-x-4 items-center">
                    <i class="fa-solid fa-copyright"></i>
                    <span>Bütün hüquqlar qorunur</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, onMounted, ref, watch } from 'vue';
import WelcomeComponent from './Components/WelcomeComponent.vue';
import TeamComponent from './Components/TeamComponent.vue';
import AboutComponent from './Components/AboutComponent.vue';
import ContactsComponent from './Components/ContactsComponent.vue';
import EventsComponent from './Components/EventsComponent.vue';
import MediaComponent from './Components/MediaComponent.vue';
import AwardsComponent from './Components/AwardsComponent.vue';

export default defineComponent ({
    name: "Home",
    components: {
        WelcomeComponent,
        TeamComponent,
        AboutComponent,
        ContactsComponent,
        EventsComponent,
        MediaComponent,
        AwardsComponent,
    },
    props: [
        'info',
        'media',
        'events',
        'awards',
        'about',
        'teams',
    ],
    setup(props) {
        // Properties
        const scrolled = ref(false);
        let position = ref(0);
        let welcome = null;
        let team = null;
        let about = null;
        let awards = null;
        let events = null;
        let media = null;
        let contacts = null;

        const info = props.info;
        const xmedia = props.media;
        const xevent = props.events;
        const xawards = props.awards;
        const abouts = props.about;
        const teams = props.teams;


        // Watchers
        watch(position, (n, o) => {
            if(n == 0) {
                scrolled.value = false;
            }else {
                scrolled.value = true;
            }
        });

        const currentPage = (tag) => {
            switch(tag) {
                case 'welcome':
                    welcome.scrollIntoView();
                    break;
                case 'team':
                    team.scrollIntoView();
                    break;
                case 'about':
                    about.scrollIntoView();
                    break;
                case 'awards':
                    awards.scrollIntoView();
                    break;
                case 'events':
                    events.scrollIntoView();
                    break;
                case 'media':
                    media.scrollIntoView();
                    break;
                case 'contacts':
                    contacts.scrollIntoView();
                    break;
            }
        }

        onMounted(() => {
            window.addEventListener('scroll', () => {
                position.value = window.scrollY;
            });

            welcome = document.getElementById('welcome');
            team = document.getElementById('team');
            about = document.getElementById('about');
            awards = document.getElementById('awards');
            events = document.getElementById('events');
            media = document.getElementById('media');
            contacts = document.getElementById('contacts');
        })

        return {
            // Properties
            scrolled,
            info,
            xmedia,
            xevent,
            xawards,
            abouts,
            teams,

            // Methods
            currentPage
        }
    }
})
</script>
